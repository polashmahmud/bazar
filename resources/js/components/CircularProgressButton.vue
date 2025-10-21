<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    label: string;
    value: number;
    total: number;
    percentage?: number;
}

const props = withDefaults(defineProps<Props>(), {
    percentage: undefined,
});

const progressPercentage = computed(() => {
    return props.percentage ?? (props.value / props.total) * 100;
});

const circumference = 2 * Math.PI * 54; // radius = 54
const strokeDashoffset = computed(() => {
    return circumference - (progressPercentage.value / 100) * circumference;
});
</script>

<template>
    <button
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
            {{ Math.round(progressPercentage) }}%
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center justify-center space-y-1">
            <!-- Value/Total (Large) -->
            <p class="text-4xl font-bold text-gray-900">
                {{ value }}<span class="text-2xl text-gray-400">/{{ total }}</span>
            </p>

            <!-- Percentage (Medium) -->
            <p class="text-xl font-semibold text-green-600">
                {{ Math.round(progressPercentage) }}% সম্পন্ন
            </p>

            <!-- Label Text (Small) -->
            <p class="text-xs text-gray-500 text-center px-4 pt-1">
                {{ label }}
            </p>
        </div>
    </button>
</template>
