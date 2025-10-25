<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { AlertCircle, TrendingUp, Apple, Salad, Cherry, Flame } from 'lucide-vue-next';
import CircularProgressButton from '@/components/CircularProgressButton.vue';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { GroceryList } from '@/types/grocery';


defineProps<{
    items: GroceryList[];
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const quickAddItems = [
    { name: 'আলু', icon: Apple },
    { name: 'পেয়াজ', icon: Salad },
    { name: 'টমেটো', icon: Cherry },
    { name: 'মরিচ', icon: Flame },
];

// Format expense message
const expenseMessage = () => {
    //
};

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-6">

            <!-- Content -->

            <div class="flex items-center justify-center">
                <CircularProgressButton :items="items" />
            </div>

            <div class="space-y-6 text-center">
                <div class="flex items-center justify-center gap-2 text-gray-700 text-sm">
                    <AlertCircle class="h-4 w-4" />
                    <span>গত সপ্তাহে Alu শেষ হয়েছিল, আজ নেবেন?</span>
                </div>

                <p class="text-sm text-gray-600">আরো বাজারে যুক্ত করতে পারেন</p>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <Button v-for="(item, index) in 4" :key="index" variant="outline"
                        class="h-auto py-3 flex items-center justify-center gap-2">
                        <!-- <component :is="item.icon" class="h-4 w-4" /> -->
                        <span>alu</span>
                    </Button>
                </div>

                <div class="flex items-center justify-center gap-2 text-gray-700 text-sm">
                    <TrendingUp class="h-4 w-4" />
                    <p>
                        এই মাসে আপনার মোট খরচ হয়েছে ৳ ১,২০০। গত মাসের তুলনায় ১৫% বেশি।
                    </p>
                </div>
            </div>

        </div>
    </AppLayout>


</template>
