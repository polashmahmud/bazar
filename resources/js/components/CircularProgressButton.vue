<script setup lang="ts">
import type { GroceryList } from '@/types/grocery';
import { computed } from 'vue';

const props = defineProps<{
    items: GroceryList[];
}>()

const radius = 54
const circumference = 2 * Math.PI * radius

const purchasedCount = computed(() => props.items.filter(i => i.purchased).length)
const totalCount = computed(() => props.items.length)
const progress = computed(() => totalCount.value ? purchasedCount.value / totalCount.value : 0)
const strokeDashoffset = computed(() => circumference * (1 - progress.value))
</script>

<template>
    <button @click="$inertia.visit('/groceries-list')"
        class="relative flex flex-col items-center justify-center w-48 h-48 rounded-full bg-white shadow-lg hover:shadow-xl transition-shadow duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
        <!-- SVG Circular Progress -->
        <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 120 120">
            <!-- Background Circle (Light Gray) -->
            <circle cx="60" cy="60" r="54" stroke="#e5e7eb" stroke-width="8" fill="none" />

            <!-- Progress Circle (Green) -->
            <circle cx="60" cy="60" r="54" stroke="#4ade80" stroke-width="8" fill="none"
                :stroke-dasharray="circumference" :stroke-dashoffset="strokeDashoffset" stroke-linecap="round"
                class="transition-all duration-1000 ease-out" />
        </svg>

        <!-- Percentage Badge (Top Right) -->
        <div class="absolute top-2 right-2 bg-green-50 text-green-600 text-xs font-semibold px-2 py-1 rounded-full">
            {{ Math.round(progress * 100) }}%
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center justify-center space-y-1">
            <!-- Value/Total (Large) -->
            <p class="text-4xl font-bold text-gray-900">
                {{ purchasedCount }}<span class="text-2xl text-gray-400">/{{ totalCount }}</span>
            </p>

            <!-- Percentage (Medium) -->
            <p class="text-xl font-semibold text-green-600">
                {{ Math.round(progress * 100) }}% সম্পন্ন
            </p>

            <!-- Label Text (Small) -->
            <p class="text-xs text-gray-500 text-center px-4 pt-1">
                আজকের বাজার তালিকা
            </p>
        </div>
    </button>
</template>
