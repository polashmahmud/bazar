<script setup lang="ts">
import GrocerySearch from '@/components/groceries/GrocerySearch.vue';
import { Head } from '@inertiajs/vue3';
import { ChevronLeft, Mic, Plus } from 'lucide-vue-next';
import { ref } from 'vue';

interface GroceryItem {
    id: number;
    icon: string;
    name_bn: string;
    name_bn_en: string;
    name_en: string;
}

interface ShoppingItem {
    id: number;
    name: string;
    quantity: string;
    unit: string;
    price: string;
}

const title = ref('নতুন বাজারের তালিকা তৈরি করুন');
const location = ref('স্থান: পাড়ার বাজার মার্কেট');
const aiEnabled = ref(true);

const shoppingItems = ref<ShoppingItem[]>([
    { id: 1, name: 'ডিম (১ ডজন)', quantity: '১', unit: 'ডজন', price: '৳ ১৪৫' },
    { id: 2, name: 'সয়াবিন তেল', quantity: '', unit: '', price: '৳ ৯০৭' },
    { id: 3, name: 'সয়াবিন তেল (৫ লিটার)', quantity: '৫', unit: 'লিটার', price: '৳ ৩২৮' },
    { id: 4, name: 'মুগ ডাল', quantity: '', unit: '', price: '৳ ১২৮' },
]);

const incrementItem = (id: number) => {
    console.log('Increment item', id);
};

const handleItemSelected = (item: GroceryItem) => {
    console.log('Item selected:', item);
    // এখানে আপনি selected item দিয়ে যা করতে চান তা করতে পারবেন
    // যেমন: shopping list এ add করা
};
</script>

<template>

    <Head title="Smart Bazar" />

    <div class="min-h-screen bg-white">
        <!-- Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
            <button @click="$inertia.visit('/dashboard')" class="text-green-600 p-1">
                <ChevronLeft :size="24" />
            </button>
            <h1 class="text-lg font-medium text-gray-800">Smart Bazar</h1>
            <button class="text-green-600 p-1">
                <Mic :size="24" />
            </button>
        </div>

        <!-- Grocery Search Component -->
        <GrocerySearch @item-selected="handleItemSelected" />
    </div>
</template>
