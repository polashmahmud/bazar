<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { DonutChart } from "@/components/ui/chart-donut"
import CircularProgressButton from '@/components/CircularProgressButton.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="flex flex-wrap gap-6">
                <!-- Example 1: আপনার ছবির মতো -->
                <CircularProgressButton label="আজ, ২৪ জানুয়ার কেনাকাটার দলগুলি" :value="20" :total="100" />

                <!-- Example 2: আরেকটি উদাহরণ -->
                <CircularProgressButton label="সম্পূর্ণ অর্ডার" :value="35" :total="50" />

                <!-- Example 3: কাস্টম পার্সেন্টেজ -->
                <CircularProgressButton label="মোট বিক্রয়" :value="75" :total="100" :percentage="75" />
            </div>
        </div>
    </AppLayout>
</template>
