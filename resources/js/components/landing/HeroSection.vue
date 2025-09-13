<script lang="ts" setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <section class="relative px-4 py-12 sm:px-6 sm:py-20 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="text-center">
                <h1 class="mb-4 text-3xl font-bold text-gray-900 sm:mb-6 sm:text-4xl md:text-6xl">
                    Welcome to
                    <span class="bg-gradient-to-r from-indigo-600 to-cyan-600 bg-clip-text text-transparent"> Bazar </span>
                </h1>
                <p class="mx-auto mb-6 max-w-3xl px-4 text-lg text-gray-600 sm:mb-8 sm:text-xl md:text-2xl">
                    Your ultimate shopping companion. Manage your cart, track your purchases, and enjoy a seamless shopping experience.
                </p>

                <!-- Hero CTA Buttons -->
                <div class="flex flex-col justify-center gap-4 px-4 sm:flex-row">
                    <template v-if="!user">
                        <Link
                            href="/register"
                            class="transform rounded-lg bg-indigo-600 px-6 py-3 text-lg font-semibold text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:bg-indigo-700 hover:shadow-xl sm:px-8"
                        >
                            Get Started
                        </Link>
                        <Link
                            href="/pin-login"
                            class="rounded-lg border-2 border-indigo-600 bg-white px-6 py-3 text-lg font-semibold text-indigo-600 shadow-md transition-all duration-200 hover:bg-indigo-50 hover:shadow-lg sm:px-8"
                        >
                            Sign In
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            href="/dashboard"
                            class="transform rounded-lg bg-indigo-600 px-6 py-3 text-lg font-semibold text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:bg-indigo-700 hover:shadow-xl sm:px-8"
                        >
                            Go to Dashboard
                        </Link>
                    </template>
                </div>
            </div>
        </div>

        <!-- Hero Background Elements -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div
                class="animate-blob absolute top-0 left-0 h-72 w-72 rounded-full bg-gradient-to-br from-indigo-200 to-cyan-200 opacity-70 mix-blend-multiply blur-xl filter sm:h-96 sm:w-96"
            ></div>
            <div
                class="animate-blob animation-delay-2000 absolute top-0 right-0 h-72 w-72 rounded-full bg-gradient-to-br from-yellow-200 to-pink-200 opacity-70 mix-blend-multiply blur-xl filter sm:h-96 sm:w-96"
            ></div>
            <div
                class="animate-blob animation-delay-4000 absolute -bottom-8 left-20 h-72 w-72 rounded-full bg-gradient-to-br from-purple-200 to-pink-200 opacity-70 mix-blend-multiply blur-xl filter sm:h-96 sm:w-96"
            ></div>
        </div>
    </section>
</template>
