<template>
    <div class="min-h-screen bg-gray-50 pb-16 transition-colors duration-300 sm:pb-0 dark:bg-gray-900">
        <!-- Header -->
        <div class="border-b border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Title -->
                    <div class="flex items-center space-x-4">
                        <h1 class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white">📊 Dashboard</h1>
                        <span class="hidden text-sm text-gray-500 sm:block dark:text-gray-400">
                            {{ monthlySummary.month_name }}
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <!-- Profile Icon -->
                        <div class="relative">
                            <button
                                @click="toggleProfileMenu"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-white transition-colors hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                            >
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </button>

                            <!-- Profile Dropdown -->
                            <div
                                v-if="showProfileMenu"
                                class="absolute right-0 z-50 mt-2 w-48 rounded-md border bg-white py-1 shadow-lg dark:border-gray-700 dark:bg-gray-800"
                            >
                                <div class="border-b px-4 py-2 text-sm text-gray-700 dark:border-gray-600 dark:text-gray-300">
                                    <p class="font-medium">{{ user.name }}</p>
                                    <p class="text-gray-500 dark:text-gray-400">{{ user.email }}</p>
                                </div>

                                <button
                                    v-if="!user.pin_code"
                                    @click="goToPinSetup"
                                    class="flex w-full items-center space-x-2 px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                        />
                                    </svg>
                                    <span>Set Pin Code</span>
                                </button>

                                <button
                                    v-if="user.pin_code"
                                    @click="removePinCode"
                                    class="flex w-full items-center space-x-2 px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span>Remove Pin Code</span>
                                </button>

                                <hr class="dark:border-gray-600" />

                                <button
                                    @click="logout"
                                    class="flex w-full items-center space-x-2 px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                        />
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>

                        <!-- Theme Toggle (hidden on mobile) -->
                        <div class="hidden sm:block">
                            <AppearanceTabs />
                        </div>

                        <!-- Items Page Button (hidden on mobile) -->
                        <button
                            @click="goToItems"
                            class="hidden items-center space-x-2 rounded-lg bg-blue-600 px-3 py-2 font-medium text-white transition-colors hover:bg-blue-700 sm:flex"
                        >
                            <ShoppingCartIcon class="h-5 w-5" />
                            <span>Items</span>
                        </button>

                        <!-- Logout Button (hidden on mobile) -->
                        <button
                            @click="logout"
                            class="hidden items-center space-x-2 rounded-lg bg-red-600 px-3 py-2 font-medium text-white transition-colors hover:bg-red-700 sm:flex"
                        >
                            <ArrowRightOnRectangleIcon class="h-5 w-5" />
                            <span>Logout</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <!-- Month Selector -->
            <div class="mb-6">
                <select
                    v-model="selectedMonth"
                    @change="changeMonth"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:border-transparent focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                >
                    <option v-for="month in availableMonths" :key="month.value" :value="month.value">
                        {{ month.label }}
                    </option>
                </select>
            </div>

            <!-- Summary Cards -->
            <div class="mb-6 grid grid-cols-1 gap-4 sm:mb-8 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
                <!-- Total Items -->
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                                <CheckIcon class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Items Purchased</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ monthlySummary.total_items }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Total Quantity -->
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900">
                                <HashtagIcon class="h-5 w-5 text-purple-600 dark:text-purple-400" />
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Quantity</dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ monthlySummary.total_quantity }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchased Items Table -->
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-200 px-4 py-3 sm:px-6 sm:py-4 dark:border-gray-700">
                    <h2 class="text-base font-medium text-gray-900 sm:text-lg dark:text-white">
                        ✅ Purchased Items - {{ monthlySummary.month_name }}
                    </h2>
                </div>

                <div v-if="doneItems.length === 0" class="p-6 text-center sm:p-8">
                    <div class="mb-3 text-4xl sm:mb-4 sm:text-6xl">📝</div>
                    <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg dark:text-white">No purchased items yet</h3>
                    <p class="text-sm text-gray-500 sm:text-base dark:text-gray-400">Items you mark as done will appear here with purchase details</p>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase sm:px-6 dark:text-gray-300">
                                    Item
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase sm:px-6 dark:text-gray-300">
                                    Quantity
                                </th>
                                <th class="px-3 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase sm:px-6 dark:text-gray-300">
                                    Date
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            <tr v-for="item in doneItems" :key="item.id" class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-2 py-3 whitespace-nowrap sm:px-6 sm:py-4">
                                    <div class="flex items-center">
                                        <div class="mr-2 h-8 w-8 flex-shrink-0 rounded-lg bg-gray-100 sm:mr-4 sm:h-10 sm:w-10 dark:bg-gray-700">
                                            <img v-if="item.image" :src="item.image" :alt="item.name" class="h-full w-full rounded-lg object-cover" />
                                            <div v-else class="flex h-full w-full items-center justify-center">
                                                <div class="text-sm sm:text-lg">📦</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs font-medium text-gray-900 sm:text-sm dark:text-white">
                                                {{ item.name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 py-3 text-xs whitespace-nowrap text-gray-900 sm:px-6 sm:py-4 sm:text-sm dark:text-white">
                                    {{ item.quantity }} {{ item.quantity_unit }}
                                </td>
                                <td class="px-2 py-3 text-xs whitespace-nowrap text-gray-500 sm:px-6 sm:py-4 sm:text-sm dark:text-gray-400">
                                    {{ formatDate(item.done_at || item.updated_at) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Bar -->
        <MobileNavBar :cartCount="cartCount" />
    </div>
</template>

<script setup lang="ts">
import AppearanceTabs from '@/components/AppearanceTabs.vue';
import MobileNavBar from '@/components/MobileNavBar.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

// Define icons as simple components
const CheckIcon = {
    template:
        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>',
};
const ArrowRightOnRectangleIcon = {
    template:
        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>',
};
const ShoppingCartIcon = {
    template:
        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13v8a2 2 0 002 2h6a2 2 0 002-2v-8m-8 0V9a2 2 0 012-2h4a2 2 0 012 2v4.01" /></svg>',
};
const HashtagIcon = {
    template:
        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" /></svg>',
};

// Props from Laravel controller
interface Item {
    id: number;
    cart_id?: string;
    name: string;
    quantity: number;
    quantity_unit: string;
    image?: string;
    month: string;
    is_done: boolean;
    created_at: string;
    updated_at: string;
    done_at?: string;
}

interface MonthlySummary {
    total_items: number;
    total_quantity: number;
    month: string;
    month_name: string;
}

interface Props {
    doneItems: Item[];
    currentMonth: string;
    monthlySummary: MonthlySummary;
    yearlyComparison: any[];
    user: {
        id: number;
        name: string;
        email: string;
        pin_code?: string;
    };
}

const props = defineProps<Props>();

// Reactive state
const selectedMonth = ref(props.currentMonth);
const cartCount = ref(0);
const showProfileMenu = ref(false);

// Profile menu methods
const toggleProfileMenu = () => {
    showProfileMenu.value = !showProfileMenu.value;
};

const goToPinSetup = () => {
    showProfileMenu.value = false;
    router.visit('/pin-setup');
};

const removePinCode = async () => {
    if (confirm('Are you sure you want to remove your pin code?')) {
        try {
            await axios.post('/pin-remove');
            showProfileMenu.value = false;
            // Reload page to update user data
            window.location.reload();
        } catch (error) {
            console.error('Failed to remove pin code:', error);
            alert('Failed to remove pin code. Please try again.');
        }
    }
};

// Close profile menu when clicking outside
const closeProfileMenu = (event: Event) => {
    const target = event.target as HTMLElement;
    if (!target.closest('.relative')) {
        showProfileMenu.value = false;
    }
};

// Add event listener for closing menu
onMounted(() => {
    loadCartCount();
    document.addEventListener('click', closeProfileMenu);
});

// Remove event listener on unmount
onBeforeUnmount(() => {
    document.removeEventListener('click', closeProfileMenu);
});

// Computed properties
const availableMonths = computed(() => {
    const months = [];
    const now = new Date();

    for (let i = -6; i <= 6; i++) {
        const date = new Date(now.getFullYear(), now.getMonth() + i, 1);
        const value = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
        const label = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });
        months.push({ value, label });
    }

    return months;
});

// Methods
const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const changeMonth = () => {
    router.get('/dashboard', { month: selectedMonth.value });
};

const goToItems = () => {
    router.get('/items');
};

const loadCartCount = async () => {
    try {
        const response = await axios.get('/cart/active');
        cartCount.value = response.data.length;
    } catch (error) {
        console.error('Failed to load cart count:', error);
        cartCount.value = 0;
    }
};

const logout = async () => {
    if (confirm('Are you sure you want to logout?')) {
        try {
            await axios.post('/pin-logout');
            window.location.href = '/';
        } catch (error) {
            console.error('Logout failed:', error);
            // Force redirect anyway
            window.location.href = '/';
        }
    }
};
</script>

<style scoped>
@media (max-width: 768px) {
    /* Hide theme toggle on mobile */
    .hidden.sm\\:block {
        display: none !important;
    }

    /* Ensure mobile navigation is visible */
    .sm\\:pb-0 {
        padding-bottom: 4rem;
    }
}
</style>
