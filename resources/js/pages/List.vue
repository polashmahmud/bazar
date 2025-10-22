<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ChevronLeft, Mic, Plus } from 'lucide-vue-next';
import { ref } from 'vue';

interface ListItem {
    id: number;
    title: string;
    amount: string;
    checked: boolean;
}

const items = ref<ListItem[]>([
    { id: 1, title: 'তাজা পণ্যাজি', amount: '২০০০.০০০', checked: false },
    { id: 2, title: 'আটা', amount: '১৮০০.০০০', checked: true },
    { id: 3, title: 'মাছ ও মাংস', amount: '৩৬০০.০০০', checked: true },
    { id: 4, title: 'ডিম-দুধ', amount: '১৫০০.০০০', checked: true },
    { id: 5, title: 'ডালনির মসলা', amount: '২৪০০.০০০', checked: true },
    { id: 6, title: 'ডাল ও তেল', amount: '১৩০০.০০০', checked: true },
    { id: 7, title: 'রান্নাঘর সামগ্রী', amount: '২৫০০.০০০', checked: false },
]);

const toggleItem = (id: number) => {
    const item = items.value.find(i => i.id === id);
    if (item) {
        item.checked = !item.checked;
    }
};
</script>

<template>

    <Head title="Smart Bazar" />

    <div class="min-h-screen bg-white">
        <!-- Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
            <button class="text-green-600 p-1">
                <ChevronLeft :size="24" />
            </button>
            <h1 class="text-lg font-medium text-gray-800">Smart Bazar</h1>
            <button class="text-green-600 p-1">
                <Mic :size="24" />
            </button>
        </div>

        <!-- Date Section -->
        <div class="px-4 py-4 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-green-600">আজ, ২৪ আগস্ট</h2>
        </div>

        <!-- Location -->
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <span class="text-gray-800 font-medium">শাহবাগ বাজার</span>
            <span class="text-gray-400 text-sm">স্থান পরিবর্তন</span>
        </div>

        <!-- List Items -->
        <div class="px-4 py-2">
            <div v-for="item in items" :key="item.id"
                class="flex items-center justify-between py-3 border-b border-gray-100">
                <div class="flex items-center gap-3 flex-1">
                    <button @click="toggleItem(item.id)"
                        class="w-6 h-6 rounded border-2 flex items-center justify-center transition-colors"
                        :class="item.checked ? 'bg-green-500 border-green-500' : 'bg-white border-gray-300'">
                        <svg v-if="item.checked" class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                    <span class="text-base font-medium transition-all"
                        :class="item.checked ? 'text-green-600 line-through' : 'text-gray-800'">
                        {{ item.title }}
                    </span>
                </div>
                <span class="text-gray-400 text-sm">{{ item.amount }}</span>
            </div>
        </div>

        <!-- Floating Action Button -->
        <button
            class="fixed bottom-8 right-6 w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full shadow-lg flex items-center justify-center text-white transition-all active:scale-95">
            <Plus :size="28" :stroke-width="3" />
        </button>
    </div>
</template>
