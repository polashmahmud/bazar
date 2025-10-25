<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { type GroceryList } from '@/types/grocery';
import SingleItem from '@/components/groceries/List/SingleItem.vue';
import { Button } from '@/components/ui/button';
import { Alert, AlertDescription } from '@/components/ui/alert';
import { CheckCircle2, AlertCircle } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import { useBanglaDate } from '@/composables/useBanglaDate';

const page = usePage();
const { getTodayInBangla } = useBanglaDate();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'ড্যাশবোর্ড',
        href: '/dashboard',
    },
    {
        title: 'বাজারের তালিকা',
        href: '/groceries-list',
    }
];

defineProps<{
    items: GroceryList[];
}>();

const showSuccess = ref(false);
const showError = ref(false);
const successMessage = computed(() => page.props.success as string | undefined);
const errorMessage = computed(() => page.props.error as string | undefined);

// Watch for flash messages
watch(
    () => page.props,
    (newProps) => {
        if (newProps.success) {
            showSuccess.value = true;
            setTimeout(() => {
                showSuccess.value = false;
            }, 5000);
        }
        if (newProps.error) {
            showError.value = true;
            setTimeout(() => {
                showError.value = false;
            }, 5000);
        }
    },
    { immediate: true }
);

</script>

<template>

    <Head title="Smart Bazar" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-gray-50">
            <!-- Header Section -->
            <div class="sticky top-0 bg-white border-b border-gray-200 z-10 shadow-sm">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                    <!-- Success Message -->
                    <Transition enter-active-class="transition ease-out duration-300"
                        enter-from-class="opacity-0 transform -translate-y-2"
                        enter-to-class="opacity-100 transform translate-y-0"
                        leave-active-class="transition ease-in duration-200"
                        leave-from-class="opacity-100 transform translate-y-0"
                        leave-to-class="opacity-0 transform -translate-y-2">
                        <Alert v-if="showSuccess && successMessage"
                            class="mb-4 bg-gray-50 border-gray-900 text-gray-900">
                            <CheckCircle2 class="size-4" />
                            <AlertDescription>
                                {{ successMessage }}
                            </AlertDescription>
                        </Alert>
                    </Transition>

                    <!-- Error Message -->
                    <Transition enter-active-class="transition ease-out duration-300"
                        enter-from-class="opacity-0 transform -translate-y-2"
                        enter-to-class="opacity-100 transform translate-y-0"
                        leave-active-class="transition ease-in duration-200"
                        leave-from-class="opacity-100 transform translate-y-0"
                        leave-to-class="opacity-0 transform -translate-y-2">
                        <Alert v-if="showError && errorMessage" class="mb-4 bg-gray-50 border-gray-900 text-gray-900">
                            <AlertCircle class="size-4" />
                            <AlertDescription>
                                {{ errorMessage }}
                            </AlertDescription>
                        </Alert>
                    </Transition>

                    <!-- Header Title & Button -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">{{
                                getTodayInBangla() }}
                            </h1>
                            <p class="text-sm text-gray-500 mt-1">বাজারের তালিকা</p>
                        </div>
                        <Button @click="$inertia.post('/groceries-price-update')"
                            class="bg-gray-900 text-white hover:bg-gray-800 border-0 px-4 sm:px-6 py-2.5 font-medium text-sm whitespace-nowrap">
                            মূল্য আপডেট করুন
                        </Button>
                    </div>
                </div>
            </div>

            <!-- Items List -->
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200">
                    <!-- Table Header (Desktop Only) -->
                    <div class="hidden sm:block bg-gray-50 border-b border-gray-200">
                        <div class="flex items-center px-6 py-3">
                            <div class="text-xs font-semibold text-gray-600 uppercase tracking-wide"
                                style="flex: 0 0 40%;">
                                আইটেম
                            </div>
                            <div class="text-xs font-semibold text-gray-600 uppercase tracking-wide text-center"
                                style="flex: 0 0 15%;">
                                পরিমাণ
                            </div>
                            <div class="text-xs font-semibold text-gray-600 uppercase tracking-wide text-center"
                                style="flex: 0 0 15%;">
                                একক মূল্য
                            </div>
                            <div class="text-xs font-semibold text-gray-600 uppercase tracking-wide text-right"
                                style="flex: 0 0 20%;">
                                মোট মূল্য
                            </div>
                            <div style="flex: 0 0 10%;"></div>
                        </div>
                    </div>

                    <!-- Items -->
                    <div v-if="items.length === 0" class="px-4 sm:px-6 py-12 text-center text-gray-500">
                        কোনো আইটেম নেই
                    </div>
                    <div v-else v-for="(item, index) in items" :key="item.id">
                        <SingleItem :item="item" />
                        <div v-if="index < items.length - 1" class="border-b border-gray-100"></div>
                    </div>
                </div>
            </div>

            <!-- Footer Summary -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 shadow-sm">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Stats -->
                        <div class="flex items-center gap-4 sm:gap-6 text-sm">
                            <span class="text-gray-900 font-medium">
                                মোট: <span class="font-bold">{{ items.length }}</span>
                            </span>
                            <span class="text-gray-600">
                                সম্পন্ন: <span class="font-medium">{{items.filter(item =>
                                    item.purchased).length}}</span>
                            </span>
                            <span class="text-gray-600">
                                বাকি: <span class="font-medium">{{items.filter(item => !item.purchased).length}}</span>
                            </span>
                        </div>

                        <!-- Total Price -->
                        <div class="flex items-center justify-between sm:justify-end gap-3">
                            <span class="text-xs text-gray-500 uppercase tracking-wide">আনুমানিক খরচ</span>
                            <div class="text-xl sm:text-2xl font-bold text-gray-900">
                                ৳{{items.reduce((total, item) => total + (item.total_price ?
                                    Number(item.total_price) : 0), 0).toFixed(2)}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
