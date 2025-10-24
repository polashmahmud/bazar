<script setup lang="ts">
import GrocerySearch from '@/components/groceries/GrocerySearch.vue';
import { Head } from '@inertiajs/vue3';
import { ChevronLeft, ShoppingBasket } from 'lucide-vue-next';
import type { GroceryItem } from '@/types/grocery';

defineProps<{
    items: GroceryItem[];
}>();

const basketItemCount = 100;

const handleItemSelected = (item: GroceryItem) => {
    console.log('Item selected:', item);
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

        <div class="p-4">
            <div class="grid grid-cols-2 gap-3">
                <button v-for="item in items" :key="item.id" @click="handleItemSelected(item)"
                    class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-500 active:bg-green-100 cursor-pointer transition-all duration-200 text-left">
                    <span class="text-2xl flex-shrink-0">{{ item.icon }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ item.name_bn }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ item.name_bn_en }}</p>
                    </div>
                </button>
            </div>
        </div>
    </div>
</template>
