<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'PageTitle',
        href: '/your-route',
    }
];
</script>

<template>

    <Head title="PageTitle" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <!-- Content goes here -->
        </div>
    </AppLayout>
</template>