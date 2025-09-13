<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <footer class="bg-gray-900 py-8 text-white sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-4">
                <div class="col-span-1 sm:col-span-2">
                    <h3 class="mb-4 text-xl font-bold sm:text-2xl">Bazar</h3>
                    <p class="mb-6 max-w-md text-gray-400">
                        Your ultimate shopping companion. Manage your cart, track your purchases, and enjoy a seamless shopping experience.
                    </p>
                </div>
                <div>
                    <h4 class="mb-4 text-lg font-semibold">Quick Links</h4>
                    <ul class="space-y-2">
                        <template v-if="!user">
                            <li>
                                <Link href="/register" class="text-gray-400 transition-colors duration-200 hover:text-white"> Register </Link>
                            </li>
                            <li>
                                <Link href="/login" class="text-gray-400 transition-colors duration-200 hover:text-white"> Login </Link>
                            </li>
                        </template>
                        <template v-else>
                            <li>
                                <Link href="/dashboard" class="text-gray-400 transition-colors duration-200 hover:text-white"> Dashboard </Link>
                            </li>
                        </template>
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
                        <li>polashmahmud@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Bazar. All rights reserved.</p>
            </div>
        </div>
    </footer>
</template>
