<template>
    <div class="min-h-screen bg-gray-50 pb-16 transition-colors duration-300 sm:pb-0 dark:bg-gray-900">
        <!-- Header -->
        <div class="border-b border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Title -->
                    <div class="flex items-center space-x-4">
                        <h1 class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white">🛒 Grocery Items</h1>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <!-- Sync Status -->
                        <div class="flex items-center space-x-2">
                            <div
                                class="h-2 w-2 rounded-full"
                                :class="
                                    isOnline && syncStatus.pendingCount === 0
                                        ? 'bg-green-500'
                                        : isOnline && syncStatus.pendingCount > 0
                                          ? 'bg-yellow-500'
                                          : 'bg-red-500'
                                "
                            ></div>
                            <span class="hidden text-xs text-gray-500 sm:block dark:text-gray-400">
                                {{ !isOnline ? 'Offline' : syncStatus.pendingCount > 0 ? `${syncStatus.pendingCount} pending` : 'Synced' }}
                            </span>
                        </div>

                        <!-- Theme Toggle (hidden on mobile) -->
                        <div class="hidden sm:block">
                            <AppearanceTabs />
                        </div>

                        <!-- Cart Button (hidden on mobile) -->
                        <button
                            @click="goToCart"
                            class="relative hidden items-center space-x-2 rounded-lg bg-green-600 px-3 py-2 font-medium text-white transition-colors hover:bg-green-700 sm:flex"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13v8a2 2 0 002 2h6a2 2 0 002-2v-8m-8 0V9a2 2 0 012-2h4a2 2 0 012 2v4.01"
                                />
                            </svg>
                            <span>Cart</span>
                            <span
                                v-if="cartItemCount > 0"
                                class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white"
                            >
                                {{ cartItemCount }}
                            </span>
                        </button>

                        <!-- Add Item Button -->
                        <button
                            @click="showAddModal = true"
                            class="flex items-center space-x-2 rounded-lg bg-blue-600 px-3 py-2 font-medium text-white transition-colors hover:bg-blue-700"
                        >
                            <PlusIcon class="h-5 w-5" />
                            <span class="hidden sm:block">Add Item</span>
                        </button>

                        <!-- Dashboard Button (hidden on mobile) -->
                        <button
                            @click="goToDashboard"
                            class="hidden items-center space-x-2 rounded-lg bg-purple-600 px-3 py-2 font-medium text-white transition-colors hover:bg-purple-700 sm:flex"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2V9a2 2 0 00-2-2h-2a2 2 0 00-2 2v10"
                                />
                            </svg>
                            <span>Dashboard</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <!-- Loading Skeleton -->
            <div
                v-if="allItems.length === 0 && !filteredItems.length"
                class="grid grid-cols-3 gap-1 sm:grid-cols-2 sm:gap-4 md:grid-cols-3 lg:grid-cols-4"
            >
                <div
                    v-for="n in 8"
                    :key="n"
                    class="animate-pulse overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800"
                >
                    <div class="aspect-square bg-gray-200 dark:bg-gray-600"></div>
                    <div class="p-2 sm:p-3">
                        <div class="mb-2 h-4 rounded bg-gray-200 dark:bg-gray-600"></div>
                        <div class="mb-3 h-3 w-2/3 rounded bg-gray-200 dark:bg-gray-600"></div>
                        <div class="h-8 rounded bg-gray-200 dark:bg-gray-600"></div>
                    </div>
                </div>
            </div>

            <!-- Items Grid -->
            <div v-else-if="filteredItems.length > 0" class="grid grid-cols-3 gap-1 sm:grid-cols-2 sm:gap-4 md:grid-cols-3 lg:grid-cols-4">
                <div
                    v-for="item in filteredItems"
                    :key="'offline_id' in item ? item.offline_id : item.id"
                    class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-md sm:rounded-2xl dark:border-gray-700 dark:bg-gray-800"
                >
                    <!-- Product Image -->
                    <div class="relative aspect-square bg-gray-100 dark:bg-gray-700">
                        <img v-if="(item as any).image" :src="(item as any).image" :alt="item.name" class="h-full w-full object-cover" />
                        <div v-else class="flex h-full w-full items-center justify-center">
                            <div class="text-6xl">📦</div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-1 sm:p-3 md:p-4">
                        <h3
                            class="mb-1 truncate text-center text-xs font-semibold text-gray-900 sm:mb-3 sm:text-sm md:mb-4 md:text-lg dark:text-white"
                        >
                            {{ item.name }}
                        </h3>

                        <!-- Add to Cart Button -->
                        <button
                            @click="addToCart(item)"
                            :disabled="!item.id"
                            :class="[
                                'flex w-full items-center justify-center space-x-1 rounded-md px-1 py-1 text-xs font-medium text-white transition-colors sm:space-x-2 sm:rounded-lg sm:px-4 sm:py-2 sm:text-sm md:py-3 md:text-base',
                                item.id ? 'bg-green-500 hover:bg-green-600' : 'cursor-not-allowed bg-gray-400',
                            ]"
                        >
                            <svg class="h-3 w-3 sm:h-4 sm:w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13v8a2 2 0 002 2h6a2 2 0 002-2v-8m-8 0V9a2 2 0 012-2h4a2 2 0 012 2v4.01"
                                />
                            </svg>
                            <span class="hidden sm:inline">Add to Cart</span>
                            <span class="sm:hidden">Add</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="py-12 text-center">
                <div class="mb-4 text-8xl">🛒</div>
                <h3 class="mb-2 text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ allItems.length > 0 ? 'All items are marked as done' : 'No items in your grocery list' }}
                </h3>
                <p class="mx-auto mb-6 max-w-md text-gray-500 dark:text-gray-400">
                    {{
                        allItems.length > 0
                            ? 'Add more items or check your completed items in the dashboard'
                            : 'Start by adding some items to your shopping list'
                    }}
                </p>
                <button
                    @click="showAddModal = true"
                    class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white transition-colors hover:bg-blue-700"
                >
                    {{ allItems.length > 0 ? 'Add More Items' : 'Add Your First Item' }}
                </button>
            </div>
        </div>

        <!-- Add Item Modal -->
        <div
            v-if="showAddModal"
            class="bg-opacity-50 fixed inset-0 z-50 flex items-center justify-center bg-black p-4"
            @click.self="showAddModal = false"
        >
            <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white shadow-xl dark:bg-gray-800">
                <div class="p-6">
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Add New Item</h2>
                        <button @click="showAddModal = false" class="text-gray-400 transition-colors hover:text-gray-600 dark:hover:text-gray-300">
                            <XMarkIcon class="h-6 w-6" />
                        </button>
                    </div>

                    <form @submit.prevent="addItem" class="space-y-4">
                        <!-- Image Upload -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"> Product Image (Optional) </label>
                            <div class="rounded-lg border-2 border-dashed border-gray-300 p-6 text-center dark:border-gray-600">
                                <div v-if="form.image" class="mb-4">
                                    <img :src="form.image" alt="Preview" class="mx-auto h-24 w-24 rounded-lg object-cover" />
                                </div>
                                <input ref="imageInput" type="file" accept="image/*" @change="handleImageUpload" class="hidden" />
                                <button
                                    type="button"
                                    @click="imageInput?.click()"
                                    class="font-medium text-blue-600 transition-colors hover:text-blue-700"
                                >
                                    {{ form.image ? 'Change Image' : 'Upload Image' }}
                                </button>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG up to 2MB</p>
                            </div>
                        </div>

                        <!-- Item Name -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"> Item Name * </label>
                            <input
                                v-model="form.name"
                                type="text"
                                required
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-transparent focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                placeholder="e.g., Mushroom Sauce"
                            />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex flex-col space-y-2 pt-4 sm:flex-row sm:space-y-0 sm:space-x-2">
                            <button
                                type="button"
                                @click="showAddModal = false"
                                class="flex-1 rounded-lg border border-gray-300 px-4 py-2 text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                :disabled="isSubmitting"
                                class="flex-1 rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors hover:bg-blue-700 disabled:bg-blue-400"
                            >
                                {{ isSubmitting ? 'Adding...' : 'Add Item' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Bar -->
        <MobileNavBar :cartCount="cartItemCount" />

        <!-- Dark mode menu (hidden on mobile) -->
        <div class="mobile-menu-hidden">
            <!-- Dark mode menu content here -->
        </div>
    </div>
</template>

<script setup lang="ts">
import AppearanceTabs from '@/components/AppearanceTabs.vue';
import MobileNavBar from '@/components/MobileNavBar.vue';
import { offlineSyncService, type Item, type OfflineItem } from '@/services/offlineSync';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, onMounted, onUnmounted, ref } from 'vue';

// Define icons as simple components
const PlusIcon = {
    template:
        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>',
};
const XMarkIcon = {
    template:
        '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>',
};

// Props from Laravel controller
interface Props {
    items: Item[];
}

const props = defineProps<Props>();

// Reactive state
const allItems = ref<(Item | OfflineItem)[]>(props.items || []);
const showAddModal = ref(false);
const isSubmitting = ref(false);
const isOnline = ref(navigator.onLine);
const syncStatus = ref({ pendingCount: 0, isOnline: true });
const imageInput = ref<HTMLInputElement>();
const cartItemCount = ref(0);

// Form data
const form = ref({
    name: '',
    image: '',
});

// Computed properties
const filteredItems = computed(() => {
    return allItems.value.filter((item) => !item.is_done);
});

// Methods
const loadItems = async () => {
    // If we already have server items from props, just load offline items
    const serverItems = allItems.value.filter((item) => !('offline_id' in item));

    // Load offline items
    const offlineItems = await offlineSyncService.getAllOffline();

    // Combine both, avoiding duplicates
    allItems.value = [...serverItems, ...offlineItems];
};

const loadCartCount = async () => {
    try {
        const response = await axios.get('/cart/active');
        cartItemCount.value = response.data.length;
    } catch (error) {
        console.error('Failed to load cart count:', error);
        cartItemCount.value = 0;
    }
};

const updateSyncStatus = async () => {
    syncStatus.value = await offlineSyncService.getSyncStatus();
};

const handleImageUpload = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert('Image size should be less than 2MB');
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            form.value.image = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const addItem = async () => {
    if (isSubmitting.value) return;

    isSubmitting.value = true;

    try {
        const currentDate = new Date();
        const currentMonth = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}`;

        const itemData = {
            ...form.value,
            quantity: 1, // Default quantity
            quantity_unit: 'পিস', // Default unit
            price: 0, // Default price
            month: currentMonth,
            is_done: false,
        };

        if (isOnline.value) {
            // Try to save to server
            try {
                const response = await axios.post('/items', itemData, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                });

                if (response.data.success) {
                    // Add to local storage
                    allItems.value.push(response.data.item);
                    showAddModal.value = false;
                    resetForm();
                }
            } catch (error) {
                console.error('Error adding item:', error);
                // Save offline if server fails
                const offlineItem = await offlineSyncService.saveOffline(itemData);
                allItems.value.push(offlineItem);
                showAddModal.value = false;
                resetForm();
            }
        } else {
            // Save offline
            const offlineItem = await offlineSyncService.saveOffline(itemData);
            allItems.value.push(offlineItem);
            showAddModal.value = false;
            resetForm();
        }

        isSubmitting.value = false;
    } catch (error) {
        console.error('Error in addItem:', error);
        isSubmitting.value = false;
    }
};

// Missing functions that are referenced in the template
const goToCart = () => {
    router.visit('/cart');
};

const goToDashboard = () => {
    router.visit('/dashboard');
};

const addToCart = async (item: Item | OfflineItem) => {
    try {
        console.log('Item being added to cart:', item);
        console.log('Item ID:', item.id);

        // Check if item has a valid ID (not offline item)
        if (!item.id) {
            console.error('Cannot add offline item to cart. Item must be saved first.');
            // You could show a toast notification here
            return;
        }

        const currentDate = new Date();
        const currentMonth = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}`;
        const cartId = `cart_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;

        const requestData = {
            item_id: item.id,
            cart_id: cartId,
            quantity: 1,
            quantity_unit: 'পিস',
            price: item.price || 0,
            month: currentMonth,
        };

        console.log('Request data:', requestData);

        const response = await axios.post('/cart/add', requestData);

        if (response.data.success) {
            cartItemCount.value++;
            console.log('Item added to cart successfully');
        }
    } catch (error: any) {
        console.error('Error adding item to cart:', error);
        if (error.response) {
            console.error('Response status:', error.response.status);
            console.error('Response data:', error.response.data);
        }
    }
};

const resetForm = () => {
    form.value.name = '';
    form.value.image = '';
};

// Update cart count on mount
onMounted(() => {
    // Only load offline items, since server items are already in props
    loadItems();
    loadCartCount();
    updateSyncStatus();
    window.addEventListener('online', handleOnlineStatusChange);
    window.addEventListener('offline', handleOnlineStatusChange);
});

onUnmounted(() => {
    window.removeEventListener('online', handleOnlineStatusChange);
    window.removeEventListener('offline', handleOnlineStatusChange);
});

const handleOnlineStatusChange = () => {
    isOnline.value = navigator.onLine;
    updateSyncStatus();
};
</script>

<style scoped>
.mobile-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.5rem;
}

.mobile-menu-hidden {
    display: none;
}

@media (max-width: 768px) {
    .mobile-menu-hidden {
        display: none !important;
    }

    /* Ensure mobile grid shows 3 items per row */
    .grid-cols-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    /* Adjust item sizing for mobile */
    .grid-cols-3 > div {
        min-width: 0; /* Allow flex items to shrink */
    }

    /* Smaller text and padding on mobile */
    .mobile-responsive-text {
        font-size: 0.75rem;
    }

    .mobile-responsive-button {
        padding: 0.375rem 0.5rem;
        font-size: 0.75rem;
    }

    /* Hide theme toggle on mobile */
    .hidden.sm\\:block {
        display: none !important;
    }
}
</style>
