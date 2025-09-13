<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { nextTick, ref } from 'vue';

const form = useForm({
    email: '',
    pin_code: '',
});

const pinInputs = ref<HTMLInputElement[]>([]);
const pinDigits = ref(['', '', '', '']);

const onPinInput = (index: number, event: Event) => {
    const target = event.target as HTMLInputElement;
    const value = target.value;

    // Only allow digits
    if (!/^\d$/.test(value) && value !== '') {
        target.value = '';
        return;
    }

    pinDigits.value[index] = value;

    // Move to next input if digit entered
    if (value && index < 3) {
        nextTick(() => {
            pinInputs.value[index + 1]?.focus();
        });
    }

    // Update form data
    form.pin_code = pinDigits.value.join('');
};

const onPinKeydown = (index: number, event: KeyboardEvent) => {
    // Handle backspace
    if (event.key === 'Backspace' && !pinDigits.value[index] && index > 0) {
        nextTick(() => {
            pinInputs.value[index - 1]?.focus();
        });
    }
};

const onPinPaste = (event: ClipboardEvent) => {
    event.preventDefault();
    const pastedData = event.clipboardData?.getData('text') || '';
    const digits = pastedData.replace(/\D/g, '').slice(0, 4).split('');

    digits.forEach((digit, index) => {
        if (index < 4) {
            pinDigits.value[index] = digit;
            if (pinInputs.value[index]) {
                pinInputs.value[index].value = digit;
            }
        }
    });

    form.pin_code = pinDigits.value.join('');

    // Focus last filled input or first empty
    const lastIndex = Math.min(digits.length - 1, 3);
    nextTick(() => {
        pinInputs.value[lastIndex]?.focus();
    });
};

const submit = () => {
    form.post('/pin-login', {
        onFinish: () => {
            // Clear pin on error
            if (form.hasErrors) {
                pinDigits.value = ['', '', '', ''];
                pinInputs.value.forEach((input) => {
                    if (input) input.value = '';
                });
                nextTick(() => {
                    pinInputs.value[0]?.focus();
                });
            }
        },
    });
};
</script>

<template>
    <AuthBase title="Pin Login" description="Enter your email and 4-digit pin to access your account">
        <Head title="Pin Login" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <!-- Email Input -->
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@example.com"
                        :class="{ 'border-red-500': form.errors.email }"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <!-- Pin Code Input -->
                <div class="grid gap-2">
                    <Label for="pin">4-Digit Pin Code</Label>
                    <div class="flex justify-center gap-2">
                        <input
                            v-for="(digit, index) in pinDigits"
                            :key="index"
                            :ref="(el) => (pinInputs[index] = el as HTMLInputElement)"
                            type="text"
                            maxlength="1"
                            :value="digit"
                            @input="onPinInput(index, $event)"
                            @keydown="onPinKeydown(index, $event)"
                            @paste="onPinPaste"
                            :tabindex="index + 2"
                            class="h-12 w-12 rounded-lg border border-gray-300 text-center text-lg font-semibold focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                            :class="{ 'border-red-500': form.errors.pin_code }"
                        />
                    </div>
                    <InputError :message="form.errors.pin_code" />
                </div>

                <Button type="submit" class="mt-2 w-full" :tabindex="6" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Login with Pin
                </Button>
            </div>

            <div class="space-y-2 text-center text-sm text-muted-foreground">
                <div>
                    Don't have a pin set?
                    <TextLink href="/login" class="underline underline-offset-4" :tabindex="7"> Login with Email & Password </TextLink>
                </div>
                <div>
                    Don't have an account?
                    <TextLink href="/register" class="underline underline-offset-4" :tabindex="8"> Create account </TextLink>
                </div>
            </div>
        </form>
    </AuthBase>
</template>
