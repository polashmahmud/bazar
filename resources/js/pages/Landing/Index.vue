<template>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 border-b border-gray-200 bg-white/80 backdrop-blur-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="bg-gradient-to-r from-indigo-600 to-cyan-600 bg-clip-text text-2xl font-bold text-transparent">Bazar</h1>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden items-center space-x-8 md:flex">
                        <a href="#features" class="text-gray-600 transition-colors duration-200 hover:text-indigo-600"> Features </a>
                        <a href="#about" class="text-gray-600 transition-colors duration-200 hover:text-indigo-600"> About </a>
                        <Link :href="loginUrl" class="text-gray-600 transition-colors duration-200 hover:text-indigo-600"> Login </Link>
                        <Link
                            :href="registerUrl"
                            class="rounded-lg bg-indigo-600 px-6 py-2 text-white shadow-md transition-colors duration-200 hover:bg-indigo-700 hover:shadow-lg"
                        >
                            Register
                        </Link>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex items-center justify-center rounded-md bg-gray-100 p-2 text-gray-400 transition-colors duration-200 hover:bg-gray-200 hover:text-gray-500"
                        >
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    v-if="!mobileMenuOpen"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div v-show="mobileMenuOpen" class="md:hidden">
                    <div class="mt-2 space-y-1 rounded-lg bg-white px-2 pt-2 pb-3 shadow-lg sm:px-3">
                        <a href="#features" class="block px-3 py-2 text-gray-600 transition-colors duration-200 hover:text-indigo-600"> Features </a>
                        <a href="#about" class="block px-3 py-2 text-gray-600 transition-colors duration-200 hover:text-indigo-600"> About </a>
                        <Link :href="loginUrl" class="block px-3 py-2 text-gray-600 transition-colors duration-200 hover:text-indigo-600">
                            Login
                        </Link>
                        <Link
                            :href="registerUrl"
                            class="block rounded-lg bg-indigo-600 px-3 py-2 text-center text-white transition-colors duration-200 hover:bg-indigo-700"
                        >
                            Register
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="text-center">
                    <h1 class="mb-6 text-4xl font-bold text-gray-900 md:text-6xl">
                        Welcome to
                        <span class="bg-gradient-to-r from-indigo-600 to-cyan-600 bg-clip-text text-transparent"> Bazar </span>
                    </h1>
                    <p class="mx-auto mb-8 max-w-3xl text-xl text-gray-600 md:text-2xl">
                        Your ultimate shopping companion. Manage your cart, track your purchases, and enjoy a seamless shopping experience.
                    </p>
                    <div class="flex flex-col justify-center gap-4 sm:flex-row">
                        <Link
                            :href="registerUrl"
                            class="transform rounded-lg bg-indigo-600 px-8 py-3 text-lg font-semibold text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:bg-indigo-700 hover:shadow-xl"
                        >
                            Get Started
                        </Link>
                        <Link
                            :href="loginUrl"
                            class="rounded-lg border-2 border-indigo-600 bg-white px-8 py-3 text-lg font-semibold text-indigo-600 shadow-md transition-all duration-200 hover:bg-indigo-50 hover:shadow-lg"
                        >
                            Sign In
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Hero Background Elements -->
            <div class="absolute inset-0 -z-10">
                <div
                    class="animate-blob absolute top-0 left-0 h-96 w-96 rounded-full bg-gradient-to-br from-indigo-200 to-cyan-200 opacity-70 mix-blend-multiply blur-xl filter"
                ></div>
                <div
                    class="animate-blob animation-delay-2000 absolute top-0 right-0 h-96 w-96 rounded-full bg-gradient-to-br from-yellow-200 to-pink-200 opacity-70 mix-blend-multiply blur-xl filter"
                ></div>
                <div
                    class="animate-blob animation-delay-4000 absolute -bottom-8 left-20 h-96 w-96 rounded-full bg-gradient-to-br from-purple-200 to-pink-200 opacity-70 mix-blend-multiply blur-xl filter"
                ></div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center">
                    <h2 class="mb-4 text-3xl font-bold text-gray-900 md:text-4xl">Powerful Features</h2>
                    <p class="mx-auto max-w-2xl text-xl text-gray-600">Discover what makes Bazar the perfect choice for your shopping needs</p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="rounded-xl bg-gradient-to-br from-indigo-50 to-cyan-50 p-8 transition-shadow duration-300 hover:shadow-lg">
                        <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-gray-900">Smart Cart Management</h3>
                        <p class="text-gray-600">Easily add, update, and track your shopping items with our intelligent cart system.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 p-8 transition-shadow duration-300 hover:shadow-lg">
                        <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-green-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-gray-900">Secure PIN Login</h3>
                        <p class="text-gray-600">Quick and secure access with our 4-digit PIN authentication system.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="rounded-xl bg-gradient-to-br from-purple-50 to-pink-50 p-8 transition-shadow duration-300 hover:shadow-lg">
                        <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-purple-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-gray-900">Purchase History</h3>
                        <p class="text-gray-600">Track and analyze your shopping patterns with detailed purchase history.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="rounded-xl bg-gradient-to-br from-yellow-50 to-orange-50 p-8 transition-shadow duration-300 hover:shadow-lg">
                        <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-gray-900">Lightning Fast</h3>
                        <p class="text-gray-600">Experience blazing fast performance with our optimized interface and PWA support.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 p-8 transition-shadow duration-300 hover:shadow-lg">
                        <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-gray-900">Mobile Optimized</h3>
                        <p class="text-gray-600">Fully responsive design that works perfectly on all your devices.</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="rounded-xl bg-gradient-to-br from-red-50 to-pink-50 p-8 transition-shadow duration-300 hover:shadow-lg">
                        <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-red-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                ></path>
                            </svg>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-gray-900">User Friendly</h3>
                        <p class="text-gray-600">Intuitive interface designed with user experience as the top priority.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="bg-gradient-to-br from-gray-50 to-white py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                    <div>
                        <h2 class="mb-6 text-3xl font-bold text-gray-900 md:text-4xl">About Bazar</h2>
                        <p class="mb-6 text-lg text-gray-600">
                            Bazar is a modern shopping companion designed to simplify your shopping experience. Whether you're grocery shopping or
                            planning your next purchase, our platform provides all the tools you need to stay organized and efficient.
                        </p>
                        <p class="mb-8 text-lg text-gray-600">
                            With features like smart cart management, secure PIN authentication, and detailed purchase tracking, Bazar ensures your
                            shopping is both secure and convenient.
                        </p>
                        <div class="flex flex-col gap-4 sm:flex-row">
                            <Link
                                :href="registerUrl"
                                class="rounded-lg bg-indigo-600 px-6 py-3 text-center font-semibold text-white transition-colors duration-200 hover:bg-indigo-700"
                            >
                                Start Shopping
                            </Link>
                            <a
                                href="#features"
                                class="rounded-lg border-2 border-indigo-600 bg-white px-6 py-3 text-center font-semibold text-indigo-600 transition-colors duration-200 hover:bg-indigo-50"
                            >
                                Learn More
                            </a>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="rounded-2xl bg-gradient-to-br from-indigo-500 to-cyan-500 p-8 text-white">
                            <h3 class="mb-4 text-2xl font-bold">Ready to Get Started?</h3>
                            <p class="mb-6 text-indigo-100">
                                Join thousands of users who have already simplified their shopping experience with Bazar.
                            </p>
                            <div class="rounded-lg bg-white/10 p-4 backdrop-blur-sm">
                                <div class="mb-2 flex items-center">
                                    <svg class="mr-2 h-5 w-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                    <span>Free to use</span>
                                </div>
                                <div class="mb-2 flex items-center">
                                    <svg class="mr-2 h-5 w-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                    <span>No setup required</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="mr-2 h-5 w-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                    <span>Secure & reliable</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-indigo-600 py-20">
            <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
                <h2 class="mb-6 text-3xl font-bold text-white md:text-4xl">Ready to Transform Your Shopping Experience?</h2>
                <p class="mx-auto mb-8 max-w-2xl text-xl text-indigo-100">
                    Join Bazar today and discover how easy shopping can be with our powerful tools and intuitive interface.
                </p>
                <div class="flex flex-col justify-center gap-4 sm:flex-row">
                    <Link
                        :href="registerUrl"
                        class="rounded-lg bg-white px-8 py-3 text-lg font-semibold text-indigo-600 shadow-lg transition-colors duration-200 hover:bg-gray-100"
                    >
                        Create Account
                    </Link>
                    <Link
                        :href="loginUrl"
                        class="rounded-lg border-2 border-white bg-transparent px-8 py-3 text-lg font-semibold text-white transition-colors duration-200 hover:bg-white hover:text-indigo-600"
                    >
                        Sign In
                    </Link>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 py-12 text-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                    <div class="col-span-1 md:col-span-2">
                        <h3 class="mb-4 text-2xl font-bold">Bazar</h3>
                        <p class="mb-6 max-w-md text-gray-400">
                            Your ultimate shopping companion. Manage your cart, track your purchases, and enjoy a seamless shopping experience.
                        </p>
                    </div>
                    <div>
                        <h4 class="mb-4 text-lg font-semibold">Quick Links</h4>
                        <ul class="space-y-2">
                            <li>
                                <Link :href="registerUrl" class="text-gray-400 transition-colors duration-200 hover:text-white"> Register </Link>
                            </li>
                            <li>
                                <Link :href="loginUrl" class="text-gray-400 transition-colors duration-200 hover:text-white"> Login </Link>
                            </li>
                            <li>
                                <a href="#features" class="text-gray-400 transition-colors duration-200 hover:text-white"> Features </a>
                            </li>
                            <li>
                                <a href="#about" class="text-gray-400 transition-colors duration-200 hover:text-white"> About </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="mb-4 text-lg font-semibold">Contact</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li>support@bazar.com</li>
                            <li>+1 (555) 123-4567</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-800 pt-8 text-center text-gray-400">
                    <p>&copy; 2025 Bazar. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
import { login } from '@/routes';
import register from '@/routes/register';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

// Mobile menu state
const mobileMenuOpen = ref(false);

// Route URLs
const loginUrl = login.url();
const registerUrl = register.store.url();
</script>

<style scoped>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
