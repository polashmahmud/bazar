<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ChevronLeft, Plus } from 'lucide-vue-next';
import { ref } from 'vue';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

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

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-6">

            <h2 class="text-2xl font-bold text-green-600">আজ, ২৪ আগস্ট</h2>

            <div>
                <div v-for="item in items" :key="item.id"
                    class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div class="flex items-center gap-3 flex-1">
                        <button @click="toggleItem(item.id)"
                            class="w-6 h-6 rounded border-2 flex items-center justify-center transition-colors"
                            :class="item.checked ? 'bg-green-500 border-green-500' : 'bg-white border-gray-300'">
                            <svg v-if="item.checked" class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
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
