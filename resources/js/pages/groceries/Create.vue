<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { Head } from '@inertiajs/vue3';
import { ChevronLeft, Mic, Plus, Search } from 'lucide-vue-next';
import { ref } from 'vue';
import axios from 'axios';


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
const searchResults = ref<GroceryItem[]>([]);
const isSearching = ref(false);

const shoppingItems = ref<ShoppingItem[]>([
    { id: 1, name: 'ডিম (১ ডজন)', quantity: '১', unit: 'ডজন', price: '৳ ১৪৫' },
    { id: 2, name: 'সয়াবিন তেল', quantity: '', unit: '', price: '৳ ৯০৭' },
    { id: 3, name: 'সয়াবিন তেল (৫ লিটার)', quantity: '৫', unit: 'লিটার', price: '৳ ৩২৮' },
    { id: 4, name: 'মুগ ডাল', quantity: '', unit: '', price: '৳ ১২৮' },
]);

const addItem = () => {
    console.log('Add new item');
};

const incrementItem = (id: number) => {
    console.log('Increment item', id);
};

// Debounce timer
let debounceTimer: ReturnType<typeof setTimeout> | null = null;

const handleChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const query = target.value;

    // Clear previous timer
    if (debounceTimer) {
        clearTimeout(debounceTimer);
    }

    // If query is empty, clear results
    if (!query.trim()) {
        searchResults.value = [];
        isSearching.value = false;
        return;
    }

    isSearching.value = true;

    // Set new debounce timer (500ms delay)
    debounceTimer = setTimeout(() => {
        axios.get('/grocery-search', {
            params: {
                query: query,
            },
        }).then(response => {
            searchResults.value = response.data.data;
            isSearching.value = false;
        }).catch(error => {
            console.error('There was an error!', error);
            isSearching.value = false;
        });
    }, 500);
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

        <!-- Title Section -->
        <div class="px-4 py-4">
            <h2 class="text-xl font-bold text-gray-800">{{ title }}</h2>
            <p class="text-sm text-gray-400 mt-1">{{ location }}</p>
        </div>

        <div class="px-4 py-4 border-t border-gray-100">
            <div class="grid gap-2">
                <Label for="search">প্রয়োজনীয় আইটেম যোগ করুন</Label>
                <div class="relative w-full max-w-full items-center">
                    <Input id="search" type="text" placeholder="Search..." class="pl-10" @input="handleChange" />
                    <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                        <Search class="size-6 text-muted-foreground" />
                    </span>
                </div>
            </div>

            <!-- Search Results -->
            <div v-if="isSearching || searchResults.length > 0" class="mt-4">
                <div v-if="isSearching" class="text-center py-4">
                    <p class="text-sm text-gray-500">খুঁজছি...</p>
                </div>
                <div v-else-if="searchResults.length > 0" class="space-y-2">
                    <p class="text-sm font-medium text-gray-700 mb-2">সার্চ রেজাল্ট:</p>
                    <div class="max-h-60 overflow-y-auto space-y-2">
                        <div v-for="item in searchResults" :key="item.id"
                            class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">{{ item.icon }}</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ item.name_bn }}</p>
                                    <p class="text-xs text-gray-500">{{ item.name_bn_en }}</p>
                                </div>
                            </div>
                            <button @click="addItem"
                                class="w-8 h-8 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition-colors active:scale-95">
                                <Plus :size="16" :stroke-width="3" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Toggle -->
        <div class="px-4 py-3 flex items-center justify-between border-b border-gray-100">
            <span class="text-gray-700">AI সাহায্যে খুঁজে দেখুন</span>
            <button @click="aiEnabled = !aiEnabled" class="relative w-12 h-6 rounded-full transition-colors"
                :class="aiEnabled ? 'bg-green-500' : 'bg-gray-300'">
                <span class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform"
                    :class="aiEnabled ? 'translate-x-6' : 'translate-x-0'"></span>
            </button>
        </div>

        <!-- Shopping Section Title -->
        <div class="px-4 py-4">
            <h3 class="text-base font-semibold text-gray-800">আপনার জন্য পণ্য সাজেশন</h3>
        </div>

        <!-- Shopping Items Grid -->
        <div class="px-4 pb-24">
            <div class="grid grid-cols-2 gap-4">
                <div v-for="item in shoppingItems" :key="item.id"
                    class="border border-gray-200 rounded-lg p-3 relative">
                    <div class="mb-2">
                        <h4 class="text-sm font-medium text-gray-800 leading-tight">
                            {{ item.name }}
                        </h4>
                        <p v-if="item.quantity" class="text-xs text-gray-500 mt-1">
                            {{ item.quantity }} {{ item.unit }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between mt-3">
                        <span class="text-base font-semibold text-gray-800">
                            {{ item.price }}
                        </span>
                        <button @click="incrementItem(item.id)"
                            class="w-7 h-7 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white transition-colors active:scale-95">
                            <Plus :size="18" :stroke-width="3" />
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>
