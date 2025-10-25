<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ShoppingCart, AlertCircle, TrendingUp, Apple, Salad, Cherry, Flame, Plus } from 'lucide-vue-next';
import CircularProgressButton from '@/components/CircularProgressButton.vue';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

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
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="min-h-screen bg-white">
                <!-- Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                    <h1 class="text-lg font-medium text-gray-800">
                        বাজার ড্যাশবোর্ড
                    </h1>
                    <Button @click="$inertia.visit('/groceries')" variant="ghost">
                        <Plus :size="24" />
                    </Button>
                </div>

                <!-- Content -->
                <div class="p-4 space-y-6">
                    <div class="flex items-center justify-center">
                        <CircularProgressButton label="আজকের বাজার তালিকা" :value="15" :total="20" />
                    </div>

                    <div class="space-y-6 text-center">
                        <Button variant="outline" class="w-full" @click="$inertia.visit('/groceries-list')">
                            <ShoppingCart class="mr-2 h-4 w-4" />
                            আজকের বাজার শুরু করুন
                        </Button>

                        <div class="flex items-center justify-center gap-2 text-gray-700 text-sm">
                            <AlertCircle class="h-4 w-4" />
                            <span>গত সপ্তাহে পেঁয়াজ শেষ হয়েছিল, আজ নেবেন?</span>
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
                            <p>এই মাসে মোট খরচ ৳১২,৫০০ — তেল ও দুধে বেশি ব্যয়।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>


</template>
