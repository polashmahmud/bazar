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

                        <!-- Theme Toggle -->
                        <AppearanceTabs />

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
            <!-- Items Grid -->
            <div v-if="filteredItems.length > 0" class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3 xl:grid-cols-4">
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
                    <div class="p-3 sm:p-4">
                        <h3 class="mb-3 truncate text-center text-sm font-semibold text-gray-900 sm:mb-4 sm:text-lg dark:text-white">
                            {{ item.name }}
                        </h3>

                        <!-- Add to Cart Button -->
                        <button
                            @click="addToCart(item)"
                            class="flex w-full items-center justify-center space-x-2 rounded-lg bg-green-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-green-600 sm:py-3 sm:text-base"
                        >
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13v8a2 2 0 002 2h6a2 2 0 002-2v-8m-8 0V9a2 2 0 012-2h4a2 2 0 012 2v4.01"
                                />
                            </svg>
                            <span>Add to Cart</span>
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
                        <div class="flex space-x-3 pt-4">
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
const ArrowRightOnRectangleIcon = {
    template:
        '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>',
};

// Props from Laravel controller
interface Props {
    items: Item[];
}

const props = defineProps<Props>();

// Reactive state
const allItems = ref<(Item | OfflineItem)[]>([]);
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
    // Load server items
    const serverItems = props.items;

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
                    // Add to local list
                    allItems.value.unshift(response.data.item);
                    resetForm();
                    showAddModal.value = false;
                }
            } catch (error) {
                // If server fails, save offline
                console.error('Server save failed:', error);

                const offlineItem = await offlineSyncService.saveOffline(itemData);
                allItems.value.unshift(offlineItem);
                resetForm();
                showAddModal.value = false;
                await updateSyncStatus();
            }
        } else {
            // Save offline
            const offlineItem = await offlineSyncService.saveOffline(itemData);
            allItems.value.unshift(offlineItem);
            resetForm();
            showAddModal.value = false;
            await updateSyncStatus();
        }
    } catch (error) {
        console.error('Failed to add item:', error);
        alert('Failed to add item. Please try again.');
    } finally {
        isSubmitting.value = false;
    }
};

const deleteItem = async (item: Item | OfflineItem) => {
    if (!confirm('Are you sure you want to delete this item?')) return;

    if ('offline_id' in item) {
        // Delete offline item
        await offlineSyncService.deleteOffline(item.offline_id);
        allItems.value = allItems.value.filter((i) => !('offline_id' in i) || i.offline_id !== item.offline_id);
        await updateSyncStatus();
    } else if (item.id) {
        // Delete server item
        try {
            const response = await axios.delete(`/items/${item.id}`);
            if (response.data.success) {
                allItems.value = allItems.value.filter((i) => !('id' in i) || i.id !== item.id);
            }
        } catch (error) {
            console.error('Failed to delete item:', error);
            alert('Failed to delete item. Please try again.');
        }
    }
};

const resetForm = () => {
    form.value = {
        name: '',
        image: '',
    };
    if (imageInput.value) {
        imageInput.value.value = '';
    }
};

const addToCart = async (item: Item | OfflineItem) => {
    const currentDate = new Date();
    const currentMonth = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}`;
    const cartId = `cart_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;

    try {
        // Save to database
        const response = await axios.post('/cart/add', {
            item_id: 'id' in item ? item.id : null,
            cart_id: cartId,
            quantity: 1,
            quantity_unit: 'পিস',
            price: 0,
            month: currentMonth,
        });

        if (response.data.success) {
            // Update cart count
            cartItemCount.value++;
        }
    } catch (error) {
        console.error('Failed to add to cart:', error);
        alert('Failed to add item to cart. Please try again.');
    }
};

const handleOnlineStatusChange = () => {
    isOnline.value = navigator.onLine;
    updateSyncStatus();
};

const goToDashboard = () => {
    router.get('/dashboard');
};

const goToCart = () => {
    router.get('/cart');
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

// Lifecycle
onMounted(async () => {
    // Setup offline sync
    offlineSyncService.setupAutoSync();

    // Load items and cart count
    await loadItems();
    await loadCartCount();
    await updateSyncStatus();

    // Listen for online/offline events
    window.addEventListener('online', handleOnlineStatusChange);
    window.addEventListener('offline', handleOnlineStatusChange);

    // Attempt sync if online
    if (isOnline.value) {
        offlineSyncService.attemptSync();
    }
});

onUnmounted(() => {
    window.removeEventListener('online', handleOnlineStatusChange);
    window.removeEventListener('offline', handleOnlineStatusChange);
});
</script>
