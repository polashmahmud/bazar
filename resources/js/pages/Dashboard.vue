<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { AlertCircle, TrendingUp, Apple, Salad, Cherry, Flame } from 'lucide-vue-next';
import CircularProgressButton from '@/components/CircularProgressButton.vue';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

interface Stats {
    totalItems: number;
    purchasedItems: number;
    remainingItems: number;
    monthlyExpense: string;
    topExpenseItems: Array<{ name: string; total: number }>;
    lastWeekFinishedItem: string | null;
}

interface Props {
    stats: Stats;
}

const props = defineProps<Props>();

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
    if (props.stats.topExpenseItems.length === 0) {
        return `এই মাসে মোট খরচ ৳${props.stats.monthlyExpense}`;
    }
    const topItems = props.stats.topExpenseItems.map(item => item.name).join(' ও ');
    return `এই মাসে মোট খরচ ৳${props.stats.monthlyExpense} — ${topItems}তে বেশি ব্যয়।`;
};

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-6">

            <!-- Content -->

            <div class="flex items-center justify-center">
                <CircularProgressButton label="আজকের বাজার তালিকা" :value="stats.purchasedItems"
                    :total="stats.totalItems" />
            </div>

            <div class="space-y-6 text-center">
                <div v-if="stats.lastWeekFinishedItem"
                    class="flex items-center justify-center gap-2 text-gray-700 text-sm">
                    <AlertCircle class="h-4 w-4" />
                    <span>গত সপ্তাহে {{ stats.lastWeekFinishedItem }} শেষ হয়েছিল, আজ নেবেন?</span>
                </div>

                <p class="text-sm text-gray-600">আরো বাজারে যুক্ত করতে পারেন</p>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <Button v-for="item in quickAddItems" :key="item.name" variant="outline"
                        class="h-auto py-3 flex items-center justify-center gap-2">
                        <component :is="item.icon" class="h-4 w-4" />
                        <span>{{ item.name }}</span>
                    </Button>
                </div>

                <div class="flex items-center justify-center gap-2 text-gray-700 text-sm">
                    <TrendingUp class="h-4 w-4" />
                    <p>{{ expenseMessage() }}</p>
                </div>
            </div>

        </div>
    </AppLayout>


</template>
