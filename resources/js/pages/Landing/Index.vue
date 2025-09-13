<script setup lang="ts">
import AboutSection from '@/components/landing/AboutSection.vue';
import CTASection from '@/components/landing/CTASection.vue';
import FeaturesSection from '@/components/landing/FeaturesSection.vue';
import Footer from '@/components/landing/Footer.vue';
import HeroSection from '@/components/landing/HeroSection.vue';
import { logout } from '@/routes';
import register from '@/routes/register';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);

// Mobile menu state
const mobileMenuOpen = ref(false);

// Route URLs
const loginUrl = '/pin-login'; // Pin login URL
const registerUrl = register.store.url();
const dashboardUrl = '/dashboard';
const logoutUrl = logout.url();
</script>

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

                    <!-- Desktop Navigation Links -->
                    <div class="hidden items-center space-x-8 md:flex">
                        <a href="#features" class="text-gray-600 transition-colors duration-200 hover:text-indigo-600"> Features </a>
                        <a href="#about" class="text-gray-600 transition-colors duration-200 hover:text-indigo-600"> About </a>

                        <!-- Show different buttons based on authentication -->
                        <template v-if="!user">
                            <Link href="/pin-login" class="text-gray-600 transition-colors duration-200 hover:text-indigo-600"> Login </Link>
                            <Link
                                href="/register"
                                class="rounded-lg bg-indigo-600 px-6 py-2 text-white shadow-md transition-colors duration-200 hover:bg-indigo-700 hover:shadow-lg"
                            >
                                Register
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                href="/dashboard"
                                class="rounded-lg bg-indigo-600 px-6 py-2 text-white shadow-md transition-colors duration-200 hover:bg-indigo-700 hover:shadow-lg"
                            >
                                Dashboard
                            </Link>
                            <Link :href="logoutUrl" method="post" as="button" class="text-gray-600 transition-colors duration-200 hover:text-red-600">
                                Logout
                            </Link>
                        </template>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex items-center justify-center rounded-md bg-gray-100 p-2 text-gray-400 transition-colors duration-200 hover:bg-gray-200 hover:text-gray-500"
                            :aria-expanded="mobileMenuOpen"
                            aria-label="Toggle navigation menu"
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
                        <a
                            href="#features"
                            class="block px-3 py-2 text-gray-600 transition-colors duration-200 hover:text-indigo-600"
                            @click="mobileMenuOpen = false"
                        >
                            Features
                        </a>
                        <a
                            href="#about"
                            class="block px-3 py-2 text-gray-600 transition-colors duration-200 hover:text-indigo-600"
                            @click="mobileMenuOpen = false"
                        >
                            About
                        </a>

                        <!-- Mobile auth buttons -->
                        <template v-if="!user">
                            <Link
                                :href="loginUrl"
                                class="block px-3 py-2 text-gray-600 transition-colors duration-200 hover:text-indigo-600"
                                @click="mobileMenuOpen = false"
                            >
                                Login
                            </Link>
                            <Link
                                :href="registerUrl"
                                class="block rounded-lg bg-indigo-600 px-3 py-2 text-center text-white transition-colors duration-200 hover:bg-indigo-700"
                                @click="mobileMenuOpen = false"
                            >
                                Register
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                :href="dashboardUrl"
                                class="block rounded-lg bg-indigo-600 px-3 py-2 text-center text-white transition-colors duration-200 hover:bg-indigo-700"
                                @click="mobileMenuOpen = false"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="logoutUrl"
                                method="post"
                                as="button"
                                class="block px-3 py-2 text-gray-600 transition-colors duration-200 hover:text-red-600"
                                @click="mobileMenuOpen = false"
                            >
                                Logout
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <HeroSection />

        <!-- Features Section -->
        <FeaturesSection />
        <!-- About Section -->
        <AboutSection />
        <!-- CTA Section -->
        <CTASection />

        <!-- Footer -->
        <Footer />
    </div>
</template>

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
