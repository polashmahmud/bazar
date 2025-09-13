<template>
    <div class="min-h-screen bg-gray-50 pb-16 transition-colors duration-300 sm:pb-0 dark:bg-gray-900">
        <!-- Header -->
        <div class="sticky top-0 z-10 border-b border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <h1 class="flex items-center text-xl font-bold text-gray-900 dark:text-white">
                        <span class="mr-2">🛒</span> Shopping Cart
                        <span class="ml-2 rounded-full bg-blue-100 px-2 py-0.5 text-sm text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            {{ cartItemCount }} items
                        </span>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <!-- Empty State -->
            <div v-if="cart.length === 0" class="py-12 text-center">
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
                            class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800"
                        >
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

                                        <!-- Done Mode - Price Input -->
                                        <div v-else-if="completingCartItem === getCartItemId(item)" class="mb-4 space-y-3">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ item.quantity }} {{ item.quantity_unit }}</p>
                                            <div class="flex items-center space-x-2">
                                                <span class="text-gray-500 dark:text-gray-400">৳</span>
                                                <input
                                                    v-model="completionPrice"
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    class="flex-1 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                                    placeholder="দাম লিখুন (ঐচ্ছিক)"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons - Full Width -->
                                <div
                                    v-if="editingCartItem !== getCartItemId(item) && completingCartItem !== getCartItemId(item) && !item.is_done"
                                    class="mt-4 grid grid-cols-3 gap-2"
                                >
                                    <button
                                        @click="editingCartItem = getCartItemId(item)"
                                        class="rounded-lg bg-blue-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-600"
                                    >
                                        এডিট
                                    </button>

                                    <button
                                        @click="startCompletion(item)"
                                        class="rounded-lg bg-green-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-green-600"
                                    >
                                        সম্পন্ন
                                    </button>

                                    <button
                                        @click="confirmRemoveItem(item)"
                                        class="rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-600"
                                    >
                                        মুছুন
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

                                <!-- Completion Mode Save/Cancel Buttons -->
                                <div v-else-if="completingCartItem === getCartItemId(item)" class="mt-4 grid grid-cols-2 gap-2">
                                    <button
                                        @click="completeItem(item)"
                                        class="rounded-lg bg-green-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-green-600"
                                    >
                                        সম্পন্ন করুন
                                    </button>
                                    <button
                                        @click="cancelCompletion()"
                                        class="rounded-lg bg-gray-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-600"
                                    >
                                        বাতিল
                                    </button>
                                </div>

                                <!-- Done Item Actions -->
                                <div v-else-if="item.is_done" class="grid grid-cols-2 gap-2">
                                    <button
                                        @click="undoItem()"
                                        class="rounded-lg bg-orange-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-orange-600"
                                    >
                                        আন্ডু
                                    </button>
                                    <button
                                        @click="confirmRemoveItem(item)"
                                        class="rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-600"
                                    >
                                        মুছুন
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

// Reactive state
const cart = ref<CartItem[]>([]);
const editingCartItem = ref<string | null>(null);
const completingCartItem = ref<string | null>(null);
const completionPrice = ref(0);
const loading = ref(false);

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
const loadCartItems = async () => {
    try {
        loading.value = true;
        const response = await axios.get('/cart/active');
        cart.value = response.data;
    } catch (error) {
        console.error('Failed to load cart items:', error);
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

        // Update on server
        try {
            await axios.put(`/cart/${item.cart_id}`, updates);
        } catch (error) {
            console.error('Failed to update on server:', error);
        }
    }
};

const markCartItemAsDone = async (item: CartItem) => {
    try {
        // Update price if needed
        const finalPrice = item.price > 0 ? item.price : 10;

        if (finalPrice !== item.price) {
            await updateCartItem(item, { price: finalPrice });
        }

        // Mark as done in database
        await axios.post(`/cart/${item.cart_id}/done`);

        // Remove from cart
        cart.value = cart.value.filter((cartItem) => cartItem.cart_id !== item.cart_id);
    } catch (error) {
        console.error('Failed to mark as done:', error);
    }
};

const removeFromCart = async (item: CartItem) => {
    try {
        // Remove from database
        await axios.delete(`/cart/${item.cart_id}`);

        // Remove from local cart
        cart.value = cart.value.filter((cartItem) => cartItem.cart_id !== item.cart_id);
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
    try {
        // Update price if changed
        if (completionPrice.value !== item.price) {
            await updateCartItem(item, { price: completionPrice.value });
        }

        // Mark as done
        await markCartItemAsDone(item);

        // Reset completion state
        completingCartItem.value = null;
        completionPrice.value = 0;
    } catch (error) {
        console.error('Failed to complete item:', error);
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
    loadCartItems();
});
</script>
