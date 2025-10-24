<script setup lang="ts">
import { useForm, usePage, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import Button from '@/components/ui/button/Button.vue';

const page = usePage();
const user = computed(() => page.props.auth.user);

const hasApiKey = computed(() => !!user.value.gemini_api_key);

const form = useForm({
    gemini_api_key: '',
});

const submit = () => {
    form.post('/settings/gemini', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const deleteApiKey = () => {
    if (confirm('আপনি কি নিশ্চিত যে আপনি API কী মুছে ফেলতে চান?')) {
        router.delete('/settings/gemini', {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <div class="flex items-center justify-center min-h-[calc(100vh-200px)] p-6">
        <div class="w-full max-w-md">
            <div class="space-y-6">
                <div class="space-y-2 text-center">
                    <h1 class="text-2xl font-semibold tracking-tight">Gemini API সেটিংস</h1>
                    <p class="text-sm text-muted-foreground">
                        AI ফিচার সক্রিয় করতে আপনার Gemini API কী যুক্ত করুন
                    </p>
                </div>

                <!-- API Key Status -->
                <div v-if="hasApiKey" class="flex items-center justify-between p-4 border rounded-lg bg-muted/50">
                    <div class="space-y-1">
                        <p class="text-sm font-medium">API কী সেট করা আছে</p>
                        <p class="text-xs text-muted-foreground">আপনার API কী সক্রিয় এবং সুরক্ষিত আছে</p>
                    </div>
                    <Button variant="destructive" size="sm" @click="deleteApiKey">
                        মুছে ফেলুন
                    </Button>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div class="space-y-2">
                        <Label for="gemini_api_key">
                            {{ hasApiKey ? 'নতুন API কী' : 'API কী' }}
                        </Label>
                        <Input id="gemini_api_key" v-model="form.gemini_api_key" type="text"
                            :placeholder="hasApiKey ? 'নতুন API কী লিখুন' : 'আপনার Gemini API কী লিখুন'"
                            :disabled="form.processing" required />
                        <p v-if="form.errors.gemini_api_key" class="text-sm text-destructive">
                            {{ form.errors.gemini_api_key }}
                        </p>
                    </div>

                    <Button type="submit" class="w-full" :disabled="form.processing">
                        {{ form.processing ? 'সংরক্ষণ করা হচ্ছে...' : (hasApiKey ? 'API কী আপডেট করুন' : 'API কী সংরক্ষণ
                        করুন') }}
                    </Button>
                </form>

                <div class="text-xs text-muted-foreground text-center space-y-1">
                    <p>আপনার API কী এনক্রিপ্ট করে সুরক্ষিতভাবে সংরক্ষণ করা হয়।</p>
                    <p>
                        API কী নেই?
                        <a href="https://aistudio.google.com/app/apikey" target="_blank"
                            class="underline hover:text-foreground">
                            এখান থেকে নিন
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>