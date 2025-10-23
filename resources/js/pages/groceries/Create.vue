<script setup lang="ts">
import GrocerySearch from '@/components/groceries/GrocerySearch.vue';
import { Head } from '@inertiajs/vue3';
import { ChevronLeft, ShoppingBasket } from 'lucide-vue-next';

interface GroceryItem {
    id: number;
    icon: string;
    name_bn: string;
    name_bn_en: string;
    name_en: string;
}

const basketItemCount = 100;

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
            <button class="text-green-600 p-1 relative" @click="$inertia.visit('/groceries-list')">
                <ShoppingBasket :size="24" />
                <span v-if="basketItemCount > 0"
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ basketItemCount }}
                </span>
            </button>
        </div>

        <!-- Grocery Search Component -->
        <GrocerySearch @item-selected="handleItemSelected" />
    </div>
</template>
