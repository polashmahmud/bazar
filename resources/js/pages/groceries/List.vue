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

const page = usePage();

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
        <div class="p-4 space-y-6">
            <!-- Success Message -->
            <Transition enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 transform -translate-y-2"
                enter-to-class="opacity-100 transform translate-y-0"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 transform translate-y-0"
                leave-to-class="opacity-0 transform -translate-y-2">
                <Alert v-if="showSuccess && successMessage" class="bg-green-50 border-green-200">
                    <CheckCircle2 class="size-4 text-green-600" />
                    <AlertDescription class="text-green-800">
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
                <Alert v-if="showError && errorMessage" variant="destructive">
                    <AlertCircle class="size-4" />
                    <AlertDescription>
                        {{ errorMessage }}
                    </AlertDescription>
                </Alert>
            </Transition>

            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-green-600">আজ, ২৪ আগস্ট</h2>
                <Button @click="$inertia.post('/groceries-price-update')">
                    মূল্য আপডেট করুন
                </Button>
            </div>

            <div>
                <div v-for="item in items" :key="item.id">
                    <SingleItem :item="item" />
                </div>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-gray-800 font-medium text-sm">
                    মোট আইটেম: {{ items.length }}, ক্রয় করা হয়েছে: {{items.filter(item => item.purchased).length}},
                    বাকি: {{items.filter(item => !item.purchased).length}}
                </span>
                <span class="text-gray-400 text-sm">
                    আনুমানিক খরচ: ৳ {{items.reduce((total, item) => total + (item.total_price ?
                        Number(item.total_price) : 0), 0).toFixed(2)}}
                </span>
            </div>


        </div>
    </AppLayout>
</template>
