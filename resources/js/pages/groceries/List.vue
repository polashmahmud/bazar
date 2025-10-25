<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { type GroceryList } from '@/types/grocery';
import SingleItem from '@/components/groceries/List/SingleItem.vue';

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
}>()


const toggleItem = (id: number) => {
    //
};
</script>

<template>

    <Head title="Smart Bazar" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-6">

            <h2 class="text-2xl font-bold text-green-600">আজ, ২৪ আগস্ট</h2>

            <div>
                <div v-for="item in items" :key="item.id">
                    <SingleItem :item="item" />
                </div>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-gray-800 font-medium text-sm">
                    মোট আইটেম: ১০, ক্রয় করা হয়েছে: ৭, বাকি: ৩
                </span>
                <span class="text-gray-400 text-sm">
                    আনুমানিক খরচ: ৳৫০০০
                </span>
            </div>


        </div>
    </AppLayout>
</template>
