<script lang="ts" setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <section class="bg-indigo-600 py-12 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="mb-6 text-2xl font-bold text-white sm:text-3xl md:text-4xl">Ready to Transform Your Shopping Experience?</h2>
            <p class="mx-auto mb-8 max-w-2xl text-lg text-indigo-100 sm:text-xl">
                Join Bazar today and discover how easy shopping can be with our powerful tools and intuitive interface.
            </p>
            <div class="flex flex-col justify-center gap-4 sm:flex-row">
                <template v-if="!user">
                    <Link
                        href="/register"
                        class="rounded-lg bg-white px-6 py-3 text-lg font-semibold text-indigo-600 shadow-lg transition-colors duration-200 hover:bg-gray-100 sm:px-8"
                    >
                        Create Account
                    </Link>
                    <Link
                        href="/pin-login"
                        class="rounded-lg border-2 border-white bg-transparent px-6 py-3 text-lg font-semibold text-white transition-colors duration-200 hover:bg-white hover:text-indigo-600 sm:px-8"
                    >
                        Sign In
                    </Link>
                </template>
                <template v-else>
                    <Link
                        href="/dashboard"
                        class="rounded-lg bg-white px-6 py-3 text-lg font-semibold text-indigo-600 shadow-lg transition-colors duration-200 hover:bg-gray-100 sm:px-8"
                    >
                        Go to Dashboard
                    </Link>
                </template>
            </div>
        </div>
    </section>
</template>
