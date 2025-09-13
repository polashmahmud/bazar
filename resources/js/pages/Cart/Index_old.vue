<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 pb-16 sm:pb-0">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Back Button and Title -->
          <div class="flex items-center space-x-4">
            <button 
              @click="goBack" 
              class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white sm:flex hidden"
            >
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
            </button>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
              <span class="mr-2">🛒</span> Shopping Cart
              <span class="ml-2 text-sm bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full px-2 py-0.5">
                {{ cartItemCount }} items
              </span>
            </h1>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center space-x-2">
            <button
              v-if="cart.length > 0"
              @click="clearCart"
              class="flex items-center space-x-1 text-sm px-3 py-1.5 border border-red-500 text-red-500 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20"
            >
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              <span class="hidden sm:inline">Clear Cart</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <!-- Empty State -->
      <div v-if="cart.length === 0" class="text-center py-12">
        <div class="text-6xl mb-4">🛒</div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
          Your cart is empty
        </h3>
        <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
          Add some items to your cart to get started
        </p>
        <button
          @click="goToItems"
          class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors"
        >
          Browse Items
        </button>
      </div>

      <!-- Cart Items List -->
      <div v-else>
        <!-- Mobile Quick Actions -->
        <div class="md:hidden flex justify-between mb-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-3">
          <div class="text-sm font-medium text-gray-900 dark:text-white">
            Total: <span class="text-lg">৳{{ cartTotal.toFixed(2) }}</span>
          </div>
          <button
            @click="checkoutCart"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center text-sm"
          >
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Complete
          </button>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
          <!-- Cart Items -->
          <div class="space-y-4">
            <div
              v-for="item in cart"
              :key="item.cart_id"
              class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden"
            >
              <div class="p-4">
                <!-- Item Image -->
                <div class="w-full h-32 bg-gray-100 dark:bg-gray-700 rounded-lg mb-3">
                  <img
                    v-if="(item as any).image"
                    :src="(item as any).image"
                    :alt="item.name"
                    class="w-full h-full object-cover rounded-lg"
                  />
                  <div v-else class="w-full h-full flex items-center justify-center">
                    <div class="text-4xl">📦</div>
                  </div>
                </div>

                <!-- Product Name -->
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2 text-center">
                  {{ item.name }}
                </h4>
                
                <!-- Quantity Display/Edit -->
                <div v-if="editingCartItem !== getCartItemId(item)" class="text-center mb-4">
                  <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ item.quantity }} {{ item.quantity_unit }}
                  </p>
                  <div v-if="item.is_done" class="mt-2">
                    <span class="inline-flex items-center px-3 py-1 text-sm bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                      ✅ সম্পন্ন
                    </span>
                  </div>
                </div>
                
                <!-- Edit Mode for Quantity -->
                <div v-else class="space-y-3 mb-4">
                  <div class="grid grid-cols-2 gap-2">
                    <input
                      :value="item.quantity"
                      @input="updateCartItem(item, { quantity: parseFloat(($event.target as HTMLInputElement).value) || 1 })"
                      type="number"
                      step="0.01"
                      min="0"
                      class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                      placeholder="পরিমাণ"
                    />
                    <select
                      :value="item.quantity_unit"
                      @change="updateCartItem(item, { quantity_unit: ($event.target as HTMLSelectElement).value })"
                      class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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

                <!-- Action Buttons - Full Width -->
                <div v-if="editingCartItem !== getCartItemId(item) && !item.is_done" class="grid grid-cols-3 gap-2">
                  <button
                    @click="editingCartItem = getCartItemId(item)"
                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-medium transition-colors text-sm"
                  >
                    এডিট
                  </button>
                  
                  <button
                    @click="showDoneModal(item)"
                    class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg font-medium transition-colors text-sm"
                  >
                    সম্পন্ন
                  </button>
                  
                  <button
                    @click="confirmRemoveItem(item)"
                    class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg font-medium transition-colors text-sm"
                  >
                    মুছুন
                  </button>
                </div>

                <!-- Edit Mode Save/Cancel Buttons -->
                <div v-else-if="editingCartItem === getCartItemId(item)" class="grid grid-cols-2 gap-2">
                  <button
                    @click="saveEdit()"
                    class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg font-medium transition-colors text-sm"
                  >
                    সেভ
                  </button>
                  <button
                    @click="cancelEdit()"
                    class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg font-medium transition-colors text-sm"
                  >
                    বাতিল
                  </button>
                </div>

                <!-- Done Item Actions -->
                <div v-else-if="item.is_done" class="grid grid-cols-2 gap-2">
                  <button
                    @click="undoItem()"
                    class="bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-lg font-medium transition-colors text-sm"
                  >
                    আন্ডু
                  </button>
                  <button
                    @click="confirmRemoveItem(item)"
                    class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg font-medium transition-colors text-sm"
                  >
                    মুছুন
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
          
        <!-- Cart Summary - Hidden on mobile -->
        <div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 h-fit sticky top-24">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            Cart Summary
          </h3>
          
          <div class="space-y-3 mb-4">
            <div class="flex justify-between text-sm">
              <span class="text-gray-600 dark:text-gray-400">Items ({{ cartItemCount }})</span>
              <span class="text-gray-900 dark:text-white">৳{{ cartSubtotal.toFixed(2) }}</span>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-700 pt-3 flex justify-between font-medium">
              <span class="text-gray-900 dark:text-white">Total</span>
                <span class="text-xl text-gray-900 dark:text-white">৳{{ cartTotal.toFixed(2) }}</span>
              </div>
            </div>
            
            <div class="space-y-3">
              <button
                @click="checkoutCart"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors flex items-center justify-center"
              >
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Complete Purchase
              </button>
              
              <button
                @click="goToItems"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium transition-colors flex items-center justify-center"
              >
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add More Items
              </button>
            </div>
          </div>
        </div>
        
        <!-- Mobile Checkout Buttons -->
        <div class="fixed bottom-16 left-0 right-0 p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 md:hidden">
          <button
            @click="goToItems"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg font-medium transition-colors flex items-center justify-center"
          >
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add More Items
          </button>
        </div>
      </div>
    </div>
    
    <!-- Done Modal -->
    <div v-if="showDoneModalState" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
          আইটেম সম্পন্ন করুন
        </h3>
        
        <div v-if="selectedItemForDone" class="mb-4">
          <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
            {{ selectedItemForDone.name }}
          </p>
          <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            {{ selectedItemForDone.quantity }} {{ selectedItemForDone.quantity_unit }}
          </p>
          
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            দাম (ঐচ্ছিক)
          </label>
          <div class="flex items-center">
            <span class="text-gray-500 dark:text-gray-400 mr-2">৳</span>
            <input
              v-model="donePrice"
              type="number"
              step="0.01"
              min="0"
              class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
              placeholder="দাম লিখুন"
            />
          </div>
        </div>
        
        <div class="flex space-x-3">
          <button
            @click="closeDoneModal"
            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg font-medium transition-colors"
          >
            বাতিল
          </button>
          <button
            @click="completeDone"
            class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg font-medium transition-colors"
          >
            সম্পন্ন
          </button>
        </div>
      </div>
    </div>
    
    <!-- Mobile Navigation Bar -->
    <MobileNavBar :cartCount="cartItemCount" />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'
import MobileNavBar from '@/components/MobileNavBar.vue'

// Interfaces
interface CartItem {
  cart_id: string
  item_id: number
  name: string
  image?: string
  quantity: number
  quantity_unit: string
  price: number
  is_done: boolean
  done_at?: string
  month: string
}

// Reactive state
const cart = ref<CartItem[]>([])
const editingCartItem = ref<string | null>(null)
const loading = ref(false)
const showDoneModalState = ref(false)
const selectedItemForDone = ref<CartItem | null>(null)
const donePrice = ref(0)

// Computed properties
const cartItemCount = computed(() => {
  return cart.value.length
})

const cartSubtotal = computed(() => {
  return cart.value.reduce((sum, item) => sum + Number(item.price) * Number(item.quantity), 0)
})

const cartTotal = computed(() => {
  return cartSubtotal.value
})

// Methods
const loadCartItems = async () => {
  try {
    loading.value = true
    const response = await axios.get('/cart/active')
    cart.value = response.data
  } catch (error) {
    console.error('Failed to load cart items:', error)
  } finally {
    loading.value = false
  }
}

const getCartItemId = (item: CartItem): string => {
  return item.cart_id
}

const updateCartItem = async (item: CartItem, updates: Partial<CartItem>) => {
  const index = cart.value.findIndex(cartItem => cartItem.cart_id === item.cart_id)

  if (index !== -1) {
    // Update locally
    cart.value[index] = { ...cart.value[index], ...updates }
    
    // Update on server
    try {
      await axios.put(`/cart/${item.cart_id}`, updates)
    } catch (error) {
      console.error('Failed to update on server:', error)
    }
  }
}

const markCartItemAsDone = async (item: CartItem) => {
  try {
    // Update price if needed
    const finalPrice = item.price > 0 ? item.price : 10
    
    if (finalPrice !== item.price) {
      await updateCartItem(item, { price: finalPrice })
    }
    
    // Mark as done in database
    await axios.post(`/cart/${item.cart_id}/done`)
    
    // Remove from cart
    cart.value = cart.value.filter(cartItem => cartItem.cart_id !== item.cart_id)
  } catch (error) {
    console.error('Failed to mark as done:', error)
  }
}

const removeFromCart = async (item: CartItem) => {
  try {
    // Remove from database
    await axios.delete(`/cart/${item.cart_id}`)
    
    // Remove from local cart
    cart.value = cart.value.filter(cartItem => cartItem.cart_id !== item.cart_id)
  } catch (error) {
    console.error('Failed to remove from cart:', error)
  }
}

// New methods for the redesigned UI
const showDoneModal = (item: CartItem) => {
  selectedItemForDone.value = item
  donePrice.value = item.price || 0
  showDoneModalState.value = true
}

const confirmRemoveItem = (item: CartItem) => {
  if (confirm('আপনি কি এই আইটেমটি মুছে ফেলতে চান?')) {
    removeFromCart(item)
  }
}

const saveEdit = async () => {
  editingCartItem.value = null
  // Updates are already handled by updateCartItem calls in the inputs
}

const cancelEdit = () => {
  editingCartItem.value = null
  // Reload to revert changes
  loadCartItems()
}

const undoItem = async () => {
  try {
    // Call undo API endpoint if available, or just reload the cart
    await loadCartItems()
  } catch (error) {
    console.error('Failed to undo item:', error)
  }
}

const completeDone = async () => {
  if (!selectedItemForDone.value) return
  
  try {
    // Update price if changed
    if (donePrice.value !== selectedItemForDone.value.price) {
      await updateCartItem(selectedItemForDone.value, { price: donePrice.value })
    }
    
    // Mark as done
    await markCartItemAsDone(selectedItemForDone.value)
    
    // Close modal
    closeDoneModal()
  } catch (error) {
    console.error('Failed to complete done:', error)
  }
}

const closeDoneModal = () => {
  showDoneModalState.value = false
  selectedItemForDone.value = null
  donePrice.value = 0
}

const clearCart = async () => {
  if (!confirm('Are you sure you want to clear your cart?')) return
  
  // Remove all items one by one
  try {
    loading.value = true
    
    for (const item of cart.value) {
      await axios.delete(`/cart/${item.cart_id}`)
    }
    
    cart.value = []
  } catch (error) {
    console.error('Failed to clear cart:', error)
  } finally {
    loading.value = false
  }
}

const checkoutCart = async () => {
  if (cart.value.length === 0) return
  
  try {
    loading.value = true
    
    // Mark all items as done
    for (const item of [...cart.value]) {
      await markCartItemAsDone(item)
    }
    
    // Show success message
    alert('Purchase completed successfully!')
  } catch (error) {
    console.error('Checkout failed:', error)
  } finally {
    loading.value = false
  }
}

const goBack = () => {
  router.get('/items')
}

const goToItems = () => {
  router.get('/items')
}

// Lifecycle
onMounted(async () => {
  await loadCartItems()
})
</script>
