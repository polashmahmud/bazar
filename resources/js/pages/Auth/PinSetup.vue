<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { computed, nextTick, ref } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);

const form = useForm({
    pin_code: '',
    pin_code_confirmation: '',
});

const pinInputs = ref<HTMLInputElement[]>([]);
const confirmPinInputs = ref<HTMLInputElement[]>([]);
const pinDigits = ref(['', '', '', '']);
const confirmPinDigits = ref(['', '', '', '']);

const onPinInput = (index: number, event: Event, isConfirm = false) => {
    const target = event.target as HTMLInputElement;
    const value = target.value;

    // Only allow digits
    if (!/^\d$/.test(value) && value !== '') {
        target.value = '';
        return;
    }

    if (isConfirm) {
        confirmPinDigits.value[index] = value;
        form.pin_code_confirmation = confirmPinDigits.value.join('');

        // Move to next input if digit entered
        if (value && index < 3) {
            nextTick(() => {
                confirmPinInputs.value[index + 1]?.focus();
            });
        }
    } else {
        pinDigits.value[index] = value;
        form.pin_code = pinDigits.value.join('');

        // Move to next input if digit entered
        if (value && index < 3) {
            nextTick(() => {
                pinInputs.value[index + 1]?.focus();
            });
        } else if (value && index === 3) {
            // Move to confirmation pin
            nextTick(() => {
                confirmPinInputs.value[0]?.focus();
            });
        }
    }
};

const onPinKeydown = (index: number, event: KeyboardEvent, isConfirm = false) => {
    const inputs = isConfirm ? confirmPinInputs.value : pinInputs.value;
    const digits = isConfirm ? confirmPinDigits.value : pinDigits.value;

    // Handle backspace
    if (event.key === 'Backspace' && !digits[index] && index > 0) {
        nextTick(() => {
            inputs[index - 1]?.focus();
        });
    }

    // If backspace on first confirm input and it's empty, go to last pin input
    if (event.key === 'Backspace' && isConfirm && index === 0 && !digits[index]) {
        nextTick(() => {
            pinInputs.value[3]?.focus();
        });
    }
};

const onPinPaste = (event: ClipboardEvent, isConfirm = false) => {
    event.preventDefault();
    const pastedData = event.clipboardData?.getData('text') || '';
    const digits = pastedData.replace(/\D/g, '').slice(0, 4).split('');

    const targetDigits = isConfirm ? confirmPinDigits.value : pinDigits.value;
    const targetInputs = isConfirm ? confirmPinInputs.value : pinInputs.value;

    digits.forEach((digit, index) => {
        if (index < 4) {
            targetDigits[index] = digit;
            if (targetInputs[index]) {
                targetInputs[index].value = digit;
            }
        }
    });

    if (isConfirm) {
        form.pin_code_confirmation = confirmPinDigits.value.join('');
    } else {
        form.pin_code = pinDigits.value.join('');
    }

    // Focus last filled input or first empty
    const lastIndex = Math.min(digits.length - 1, 3);
    nextTick(() => {
        targetInputs[lastIndex]?.focus();
    });
};

const clearPins = () => {
    pinDigits.value = ['', '', '', ''];
    confirmPinDigits.value = ['', '', '', ''];
    form.pin_code = '';
    form.pin_code_confirmation = '';

    [...pinInputs.value, ...confirmPinInputs.value].forEach((input) => {
        if (input) input.value = '';
    });

    nextTick(() => {
        pinInputs.value[0]?.focus();
    });
};

const submit = () => {
    form.post('/pin-setup', {
        onFinish: () => {
            // Clear pins on error
            if (form.hasErrors) {
                clearPins();
            }
        },
    });
};

// Check if pins match
const pinsMatch = computed(() => {
    const pin = pinDigits.value.join('');
    const confirmPin = confirmPinDigits.value.join('');
    return pin.length === 4 && confirmPin.length === 4 && pin === confirmPin;
});

const canSubmit = computed(() => {
    return pinsMatch.value && !form.processing;
});
</script>

<template>
    <AuthBase title="Set Pin Code" description="Create a 4-digit pin for quick access to your account">
        <Head title="Pin Setup" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <!-- User Info -->
                <div class="rounded-lg bg-blue-50 p-4 text-center dark:bg-blue-900/20">
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        Setting up pin for: <strong>{{ user?.email }}</strong>
                    </p>
                </div>

                <!-- Pin Code Input -->
                <div class="grid gap-2">
                    <Label for="pin">Create 4-Digit Pin</Label>
                    <div class="flex justify-center gap-2">
                        <input
                            v-for="(digit, index) in pinDigits"
                            :key="`pin-${index}`"
                            :ref="(el) => (pinInputs[index] = el as HTMLInputElement)"
                            type="text"
                            maxlength="1"
                            :value="digit"
                            @input="onPinInput(index, $event, false)"
                            @keydown="onPinKeydown(index, $event, false)"
                            @paste="onPinPaste($event, false)"
                            :tabindex="index + 1"
                            class="h-12 w-12 rounded-lg border border-gray-300 text-center text-lg font-semibold focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                            :class="{
                                'border-red-500': form.errors.pin_code,
                                'border-green-500': pinDigits.join('').length === 4 && !form.errors.pin_code,
                            }"
                        />
                    </div>
                    <InputError :message="form.errors.pin_code" />
                </div>

                <!-- Pin Code Confirmation -->
                <div class="grid gap-2">
                    <Label for="confirm-pin">Confirm 4-Digit Pin</Label>
                    <div class="flex justify-center gap-2">
                        <input
                            v-for="(digit, index) in confirmPinDigits"
                            :key="`confirm-${index}`"
                            :ref="(el) => (confirmPinInputs[index] = el as HTMLInputElement)"
                            type="text"
                            maxlength="1"
                            :value="digit"
                            @input="onPinInput(index, $event, true)"
                            @keydown="onPinKeydown(index, $event, true)"
                            @paste="onPinPaste($event, true)"
                            :tabindex="index + 5"
                            class="h-12 w-12 rounded-lg border border-gray-300 text-center text-lg font-semibold focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                            :class="{
                                'border-red-500': form.errors.pin_code_confirmation || (confirmPinDigits.join('').length === 4 && !pinsMatch),
                                'border-green-500': pinsMatch,
                            }"
                        />
                    </div>
                    <InputError :message="form.errors.pin_code_confirmation" />

                    <!-- Pin match indicator -->
                    <div class="text-center text-sm" v-if="confirmPinDigits.join('').length === 4">
                        <span v-if="pinsMatch" class="text-green-600 dark:text-green-400"> ✓ Pins match! </span>
                        <span v-else class="text-red-600 dark:text-red-400"> ✗ Pins don't match </span>
                    </div>
                </div>

                <div class="flex gap-3">
                    <Button type="button" variant="outline" class="flex-1" :tabindex="9" @click="clearPins" :disabled="form.processing">
                        Clear
                    </Button>

                    <Button type="submit" class="flex-1" :tabindex="10" :disabled="!canSubmit">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Set Pin Code
                    </Button>
                </div>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                <p>You can change or remove your pin code later from your profile settings.</p>
                <a href="/dashboard" class="mt-2 inline-block underline underline-offset-4" :tabindex="11"> Skip for now and go to Dashboard </a>
            </div>
        </form>
    </AuthBase>
</template>
