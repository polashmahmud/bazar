<template>
    <div class="min-h-screen bg-gray-50 pb-16 transition-colors duration-300 sm:pb-0 dark:bg-gray-900">
        <!-- Header -->
        <div class="sticky top-0 z-10 border-b border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <!-- Offline Banner -->
            <div v-if="isOffline" class="bg-orange-500 px-4 py-2 text-center text-sm text-white">
                📱 You're offline. Changes will sync when you're back online.
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <h1 class="flex items-center text-xl font-bold text-gray-900 dark:text-white">
                        <span class="mr-2">🛒</span> Shopping Cart
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-0.5 text-sm text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            {{ cartItemCount }} items
                        </span>
                        <span
                            v-if="isOffline"
                            class="ml-2 rounded-full bg-orange-100 px-2 py-0.5 text-xs text-orange-800 dark:bg-orange-900 dark:text-orange-200"
                        >
                            OFFLINE
                        </span>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <!-- Loading Skeleton -->
            <div v-if="loading" class="space-y-4">
                <div class="animate-pulse">
                    <!-- Mobile actions skeleton -->
                    <div
                        class="mb-4 flex justify-between rounded-lg border border-gray-200 bg-white p-3 shadow-sm md:hidden dark:border-gray-700 dark:bg-gray-800"
                    >
                        <div class="h-4 w-20 rounded bg-gray-200 dark:bg-gray-600"></div>
                        <div class="h-8 w-24 rounded bg-gray-200 dark:bg-gray-600"></div>
                    </div>

                    <!-- Cart items skeleton -->
                    <div class="space-y-4">
                        <div
                            v-for="n in 3"
                            :key="n"
                            class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800"
                        >
                            <div class="flex space-x-4">
                                <div class="h-16 w-16 rounded-lg bg-gray-200 dark:bg-gray-600"></div>
                                <div class="flex-1 space-y-2">
                                    <div class="h-4 w-3/4 rounded bg-gray-200 dark:bg-gray-600"></div>
                                    <div class="h-3 w-1/2 rounded bg-gray-200 dark:bg-gray-600"></div>
                                    <div class="flex space-x-2">
                                        <div class="h-8 w-16 rounded bg-gray-200 dark:bg-gray-600"></div>
                                        <div class="h-8 w-20 rounded bg-gray-200 dark:bg-gray-600"></div>
                                    </div>
                                </div>
                                <div class="h-6 w-16 rounded bg-gray-200 dark:bg-gray-600"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else-if="cart.length === 0" class="py-12 text-center">
                <div class="mb-4 text-6xl">🛒</div>
                <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Your cart is empty</h3>
                <p class="mx-auto mb-6 max-w-md text-gray-500 dark:text-gray-400">Add some items to your cart to get started</p>
                <button @click="goToItems" class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white transition-colors hover:bg-blue-700">
                    Browse Items
                </button>
            </div>

            <!-- Cart Items List -->
            <div v-else>
                <!-- Mobile Quick Actions -->
                <div
                    class="mb-4 flex justify-between rounded-lg border border-gray-200 bg-white p-3 shadow-sm md:hidden dark:border-gray-700 dark:bg-gray-800"
                >
                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                        Total: <span class="text-lg">৳{{ cartTotal.toFixed(2) }}</span>
                    </div>
                    <button
                        @click="checkoutCart"
                        class="flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-green-700"
                    >
                        <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Complete
                    </button>
                </div>

                <div class="mb-6 grid grid-cols-1 gap-4">
                    <div class="space-y-4">
                        <div
                            v-for="item in cart"
                            :key="item.cart_id"
                            class="relative overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800"
                        >
                            <!-- Delete Button - Top Right -->
                            <button
                                @click="confirmRemoveItem(item)"
                                class="absolute top-2 right-2 rounded-full bg-red-500 p-1 text-white transition-colors hover:bg-red-600"
                                title="মুছুন"
                            >
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <div class="p-4">
                                <div class="flex space-x-4">
                                    <!-- Item Image - Left Side -->
                                    <div class="h-20 w-20 flex-shrink-0 rounded-lg bg-gray-100 dark:bg-gray-700">
                                        <img
                                            v-if="(item as any).image"
                                            :src="(item as any).image"
                                            :alt="item.name"
                                            class="h-full w-full rounded-lg object-cover"
                                        />
                                        <div v-else class="flex h-full w-full items-center justify-center">
                                            <div class="text-2xl">📦</div>
                                        </div>
                                    </div>

                                    <!-- Content - Right Side -->
                                    <div class="min-w-0 flex-1">
                                        <!-- Product Name -->
                                        <h4 class="mb-2 truncate text-lg font-medium text-gray-900 dark:text-white">
                                            {{ item.name }}
                                        </h4>

                                        <!-- Quantity Display/Edit -->
                                        <div
                                            v-if="editingCartItem !== getCartItemId(item) && completingCartItem !== getCartItemId(item)"
                                            class="mb-4"
                                        >
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ item.quantity }} {{ item.quantity_unit }}</p>
                                            <div v-if="item.is_done" class="mt-2">
                                                <span
                                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-400"
                                                >
                                                    ✅ সম্পন্ন
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Edit Mode for Quantity -->
                                        <div v-else-if="editingCartItem === getCartItemId(item)" class="mb-4 space-y-3">
                                            <div class="grid grid-cols-2 gap-2">
                                                <input
                                                    :value="item.quantity"
                                                    @input="
                                                        updateCartItem(item, { quantity: parseFloat(($event.target as HTMLInputElement).value) || 1 })
                                                    "
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                                    placeholder="পরিমাণ"
                                                />
                                                <select
                                                    :value="item.quantity_unit"
                                                    @change="updateCartItem(item, { quantity_unit: ($event.target as HTMLSelectElement).value })"
                                                    class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                                >
                                                    <option value="কেজি">কেজি</option>
                                                    <option value="গ্রাম">গ্রাম</option>
                                                    <option value="পিস">পিস</option>
                                                    <option value="ডজন">ডজন</option>
                                                    <option value="প্যাকেট">প্যাকেট</option>
                                                    <option value="বোতল">বোতল</option>
                                                    <option value="ব্যাগ">ব্যাগ</option>
                                                    <option value="লিটার">লিটার</option>
                                                    <option value="মিলি">মিলি</option>
                                                    <option value="কাপ">কাপ</option>
                                                    <option value="টিন">টিন</option>
                                                    <option value="বক্স">বক্স</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Quantity Display for non-edit mode -->
                                        <div v-else class="mb-4 space-y-3">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ item.quantity }} {{ item.quantity_unit }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons - Full Width -->
                                <div
                                    v-if="editingCartItem !== getCartItemId(item) && !item.is_done"
                                    class="mt-4 grid grid-cols-2 gap-2"
                                >
                                    <button
                                        @click="editingCartItem = getCartItemId(item)"
                                        class="rounded-lg bg-blue-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-600"
                                    >
                                        এডিট
                                    </button>

                                    <button
                                        @click="markCartItemAsDone(item)"
                                        :disabled="completingItem"
                                        :class="[
                                            'rounded-lg px-4 py-2 text-sm font-medium text-white transition-colors',
                                            completingItem ? 'cursor-not-allowed bg-gray-400' : 'bg-green-500 hover:bg-green-600'
                                        ]"
                                    >
                                        <span v-if="completingItem" class="flex items-center justify-center">
                                            <svg class="mr-1 h-3 w-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            সম্পন্ন করছি...
                                        </span>
                                        <span v-else>সম্পন্ন</span>
                                    </button>
                                </div>

                                <!-- Edit Mode Save/Cancel Buttons -->
                                <div v-else-if="editingCartItem === getCartItemId(item)" class="mt-4 grid grid-cols-2 gap-2">
                                    <button
                                        @click="saveEdit()"
                                        class="rounded-lg bg-green-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-green-600"
                                    >
                                        সেভ
                                    </button>
                                    <button
                                        @click="cancelEdit()"
                                        class="rounded-lg bg-gray-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-600"
                                    >
                                        বাতিল
                                    </button>
                                </div>

                                <!-- Done Item Actions -->
                                <div v-else-if="item.is_done" class="mt-4">
                                    <button
                                        @click="undoItem()"
                                        class="w-full rounded-lg bg-orange-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-orange-600"
                                    >
                                        আন্ডু
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Bar -->
        <MobileNavBar :cartCount="cartItemCount" />
    </div>
</template>

<script setup lang="ts">
import MobileNavBar from '@/components/MobileNavBar.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, onMounted, ref } from 'vue';

// Offline storage
declare global {
    interface Window {
        offlineStorage: any;
    }
}

// Interfaces
interface CartItem {
    cart_id: string;
    item_id: number;
    name: string;
    image?: string;
    quantity: number;
    quantity_unit: string;
    price: number;
    is_done: boolean;
    done_at?: string;
    month: string;
}

// Props from Laravel controller
interface Props {
    initialCartItems: CartItem[];
    user: {
        id: number;
        name: string;
        email: string;
    };
}

const props = defineProps<Props>();

// Reactive state
const cart = ref<CartItem[]>(props.initialCartItems || []);
const editingCartItem = ref<string | null>(null);
const completingCartItem = ref<string | null>(null);
const completionPrice = ref(0);
const loading = ref(false);
const isOffline = ref(!navigator.onLine);
const completingItem = ref(false);

// Computed properties
const cartItemCount = computed(() => {
    return cart.value.length;
});

const cartSubtotal = computed(() => {
    return cart.value.reduce((sum, item) => sum + Number(item.price) * Number(item.quantity), 0);
});

const cartTotal = computed(() => {
    return cartSubtotal.value;
});

// Methods
const loadCartItems = async (forceRefresh = false) => {
    // Skip loading if we already have data and it's not a forced refresh
    if (cart.value.length > 0 && !forceRefresh) {
        return;
    }

    try {
        loading.value = true;

        if (navigator.onLine) {
            // Try to load from server
            const response = await axios.get('/cart/active');
            cart.value = response.data;

            // Save to offline storage
            if (window.offlineStorage) {
                for (const item of cart.value) {
                    await window.offlineStorage.saveCartItem(item);
                }
            }
        } else {
            // Load from offline storage only if we don't have initial data
            if (window.offlineStorage && cart.value.length === 0) {
                cart.value = await window.offlineStorage.getCartItems();
            }
        }
    } catch (error) {
        console.error('Failed to load cart items:', error);

        // Fallback to offline storage
        if (window.offlineStorage) {
            try {
                cart.value = await window.offlineStorage.getCartItems();
            } catch (offlineError) {
                console.error('Failed to load from offline storage:', offlineError);
            }
        }
    } finally {
        loading.value = false;
    }
};

const getCartItemId = (item: CartItem): string => {
    return item.cart_id;
};

const updateCartItem = async (item: CartItem, updates: Partial<CartItem>) => {
    const index = cart.value.findIndex((cartItem) => cartItem.cart_id === item.cart_id);

    if (index !== -1) {
        // Update locally
        cart.value[index] = { ...cart.value[index], ...updates };

        // Save to offline storage
        if (window.offlineStorage) {
            await window.offlineStorage.updateCartItem(item.cart_id, updates);
        }

        // Update on server if online
        if (navigator.onLine) {
            try {
                await axios.put(`/cart/${item.cart_id}`, updates, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });
            } catch (error) {
                console.error('Failed to update on server:', error);

                // Add to pending actions for sync later
                if (window.offlineStorage) {
                    await window.offlineStorage.addPendingAction({
                        action_type: 'cart_update',
                        data: updates,
                        url: `/cart/${item.cart_id}`,
                        method: 'PUT',
                    });
                }
            }
        } else {
            // Add to pending actions for sync when online
            if (window.offlineStorage) {
                await window.offlineStorage.addPendingAction({
                    action_type: 'cart_update',
                    data: updates,
                    url: `/cart/${item.cart_id}`,
                    method: 'PUT',
                });
            }
        }
    }
};

const markCartItemAsDone = async (item: CartItem) => {
    // Prevent multiple simultaneous calls
    if (completingItem.value) {
        console.log('Already completing item, please wait...');
        return;
    }

    try {
        completingItem.value = true;
        console.log('Marking item as done:', item);

        // Update price if needed (set default price if not set)
        const finalPrice = item.price > 0 ? item.price : 10;

        if (finalPrice !== item.price) {
            console.log('Updating price from', item.price, 'to', finalPrice);
            await updateCartItem(item, { price: finalPrice });
        }

        if (navigator.onLine) {
            // Mark as done in database
            await axios.post(`/cart/${item.cart_id}/done`, {}, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });
        } else {
            // Add to pending actions
            if (window.offlineStorage) {
                await window.offlineStorage.addPendingAction({
                    action_type: 'cart_update',
                    data: { is_done: true, done_at: new Date().toISOString() },
                    url: `/cart/${item.cart_id}/done`,
                    method: 'POST',
                });
            }
        }

        // Remove from cart locally
        cart.value = cart.value.filter((cartItem) => cartItem.cart_id !== item.cart_id);

        // Remove from offline storage
        if (window.offlineStorage) {
            await window.offlineStorage.deleteCartItem(item.cart_id);
        }

        console.log('Item marked as done successfully');
    } catch (error) {
        console.error('Failed to mark as done:', error);
        alert('Failed to mark item as done. Please try again.');
    } finally {
        completingItem.value = false;
    }
};

const removeFromCart = async (item: CartItem) => {
    try {
        if (navigator.onLine) {
            // Remove from database
            await axios.delete(`/cart/${item.cart_id}`);
        } else {
            // Add to pending actions
            if (window.offlineStorage) {
                await window.offlineStorage.addPendingAction({
                    action_type: 'cart_delete',
                    data: null,
                    url: `/cart/${item.cart_id}`,
                    method: 'DELETE',
                });
            }
        }

        // Remove from local cart
        cart.value = cart.value.filter((cartItem) => cartItem.cart_id !== item.cart_id);

        // Remove from offline storage
        if (window.offlineStorage) {
            await window.offlineStorage.deleteCartItem(item.cart_id);
        }
    } catch (error) {
        console.error('Failed to remove from cart:', error);
    }
};

// New methods for the redesigned UI
const startCompletion = (item: CartItem) => {
    completingCartItem.value = item.cart_id;
    completionPrice.value = item.price || 0;
};

const completeItem = async (item: CartItem) => {
    // Prevent multiple simultaneous calls
    if (completingItem.value) {
        console.log('Already completing item, please wait...');
        return;
    }

    try {
        completingItem.value = true;
        console.log('Completing item:', item);

        // Update price if changed
        if (completionPrice.value !== item.price) {
            console.log('Updating price from', item.price, 'to', completionPrice.value);
            await updateCartItem(item, { price: completionPrice.value });
        }

        // Mark as done
        console.log('Marking item as done...');
        await markCartItemAsDone(item);

        // Reset completion state
        completingCartItem.value = null;
        completionPrice.value = 0;
        
        console.log('Item completed successfully');
    } catch (error) {
        console.error('Failed to complete item:', error);
        alert('Failed to complete item. Please try again.');
    } finally {
        completingItem.value = false;
    }
};

const cancelCompletion = () => {
    completingCartItem.value = null;
    completionPrice.value = 0;
};

const confirmRemoveItem = (item: CartItem) => {
    if (confirm('আপনি কি এই আইটেমটি মুছে ফেলতে চান?')) {
        removeFromCart(item);
    }
};

const saveEdit = async () => {
    editingCartItem.value = null;
    // Updates are already handled by updateCartItem calls in the inputs
};

const cancelEdit = () => {
    editingCartItem.value = null;
    // Reload to revert changes
    loadCartItems();
};

const undoItem = async () => {
    try {
        // Call undo API endpoint if available, or just reload the cart
        await loadCartItems();
    } catch (error) {
        console.error('Failed to undo item:', error);
    }
};

const checkoutCart = async () => {
    if (cart.value.length === 0) return;

    try {
        loading.value = true;

        // Mark all items as done
        for (const item of cart.value) {
            await markCartItemAsDone(item);
        }

        cart.value = [];

        // Navigate to dashboard
        router.visit('/dashboard');
    } catch (error) {
        console.error('Failed to checkout cart:', error);
    } finally {
        loading.value = false;
    }
};

const goToItems = () => {
    router.visit('/items');
};

// Load cart items on mount
onMounted(() => {
    // Only load if we don't have initial data or we're offline with fresh data
    if (cart.value.length === 0 || (!navigator.onLine && window.offlineStorage)) {
        loadCartItems();
    }

    // Listen for online/offline events
    window.addEventListener('online', () => {
        isOffline.value = false;
        loadCartItems(true); // Force refresh when back online

        // Trigger sync
        if (window.offlineStorage) {
            window.offlineStorage.syncData();
        }
    });

    window.addEventListener('offline', () => {
        isOffline.value = true;
    });
});
</script>
