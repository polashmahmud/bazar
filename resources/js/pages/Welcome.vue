<script setup lang="ts">
import { Button } from '@/components/ui/button';
</script>

<template>
    <div class="flex items-center flex-col justify-center min-h-screen space-y-4 p-6">
        <img src="/android-chrome-192x192.png" alt="Logo" class="size-16" />
        <div class="text-center">
            <h1 class="text-xl font-bold">
                স্বাগতম Smart Bazar এ
            </h1>
            <p class="mt-4 text-sm text-gray-600">আপনার সকল প্রয়োজনের জন্য একটি একক সমাধান।</p>
        </div>
        <Button @click="$inertia.visit('/dashboard')" class="mt-6 w-full">
            শুরু করুন
        </Button>
    </div>
</template>
