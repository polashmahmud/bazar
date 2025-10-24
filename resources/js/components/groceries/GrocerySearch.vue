<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { Search } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import axios from 'axios';
import type { GroceryItem } from '@/types/grocery';

const emit = defineEmits<{
    itemSelected: [item: GroceryItem]
}>();

const searchResults = ref<GroceryItem[]>([]);
const isSearching = ref(false);
const searchQuery = ref('');
const inputRef = ref<HTMLInputElement | null>(null);

// Debounce timer
let debounceTimer: ReturnType<typeof setTimeout> | null = null;

// Watch searchQuery changes with debounce
watch(searchQuery, (newQuery) => {
    // Clear previous timer
    if (debounceTimer) {
        clearTimeout(debounceTimer);
    }

    // If query is empty, clear results
    if (!newQuery.trim()) {
        searchResults.value = [];
        isSearching.value = false;
        return;
    }

    isSearching.value = true;

    // Set new debounce timer (500ms delay)
    debounceTimer = setTimeout(() => {
        axios.get('/grocery-search', {
            params: {
                query: newQuery,
            },
        }).then(response => {
            searchResults.value = response.data || [];
            isSearching.value = false;
        }).catch(error => {
            console.error('There was an error!', error);
            searchResults.value = [];
            isSearching.value = false;
        });
    }, 500);
});

const clearSearch = () => {
    searchQuery.value = '';
    searchResults.value = [];
    isSearching.value = false;
    // Focus input after clearing
    if (inputRef.value) inputRef.value.focus();
};

const selectItem = (item: GroceryItem) => {
    emit('itemSelected', item);
};
</script>

<template>
    <div class="px-4 py-4 border-t border-gray-100">
        <div class="grid gap-2">
            <Label for="search">প্রয়োজনীয় আইটেম যোগ করুন</Label>
            <div class="relative w-full max-w-full items-center">
                <Input id="search" ref="inputRef" v-model="searchQuery" type="text" placeholder="Search..."
                    class="pl-10 pr-8" />
                <!-- Left icon: search or loading spinner -->
                <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                    <template v-if="isSearching">
                        <svg class="animate-spin h-5 w-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </template>
                    <template v-else>
                        <Search class="size-6 text-muted-foreground" />
                    </template>
                </span>
                <!-- Right icon: clear button -->
                <button v-if="searchQuery" @click="clearSearch"
                    class="absolute end-0 inset-y-0 flex items-center px-2 text-gray-400 hover:text-gray-600 focus:outline-none"
                    tabindex="-1" aria-label="Clear search" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 01-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 01-1.414-1.414L8.586 10l-4.95-4.95A1 1 0 115.05 3.636L10 8.586z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Search Results -->
        <div v-if="isSearching || (searchResults && searchResults.length > 0)" class="mt-4">
            <div v-if="isSearching" class="text-center py-4">
                <p class="text-sm text-gray-500">খুঁজছি...</p>
            </div>
            <div v-else-if="searchResults && searchResults.length > 0">
                <p class="text-sm font-medium text-gray-700 mb-3">সার্চ রেজাল্ট:</p>
                <div class="grid grid-cols-2 gap-3">
                    <button v-for="item in searchResults" :key="item.id" @click="selectItem(item)"
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
    </div>
</template>
