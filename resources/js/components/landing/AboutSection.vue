<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <section id="about" class="bg-gradient-to-br from-gray-50 to-white py-12 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-8 sm:gap-12 lg:grid-cols-2">
                <div>
                    <h2 class="mb-6 text-2xl font-bold text-gray-900 sm:text-3xl md:text-4xl">About Bazar</h2>
                    <p class="mb-6 text-lg text-gray-600">
                        Bazar is a modern shopping companion designed to simplify your shopping experience. Whether you're grocery shopping or
                        planning your next purchase, our platform provides all the tools you need to stay organized and efficient.
                    </p>
                    <p class="mb-8 text-lg text-gray-600">
                        With features like smart cart management, secure PIN authentication, and detailed purchase tracking, Bazar ensures your
                        shopping is both secure and convenient.
                    </p>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <template v-if="!user">
                            <Link
                                href="/register"
                                class="rounded-lg bg-indigo-600 px-6 py-3 text-center font-semibold text-white transition-colors duration-200 hover:bg-indigo-700"
                            >
                                Start Shopping
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                href="/dashboard"
                                class="rounded-lg bg-indigo-600 px-6 py-3 text-center font-semibold text-white transition-colors duration-200 hover:bg-indigo-700"
                            >
                                Go to Dashboard
                            </Link>
                        </template>
                        <a
                            href="#features"
                            class="rounded-lg border-2 border-indigo-600 bg-white px-6 py-3 text-center font-semibold text-indigo-600 transition-colors duration-200 hover:bg-indigo-50"
                        >
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="rounded-2xl bg-gradient-to-br from-indigo-500 to-cyan-500 p-6 text-white sm:p-8">
                        <h3 class="mb-4 text-xl font-bold sm:text-2xl">Ready to Get Started?</h3>
                        <p class="mb-6 text-indigo-100">Join thousands of users who have already simplified their shopping experience with Bazar.</p>
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
</template>
