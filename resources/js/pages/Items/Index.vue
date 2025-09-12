<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Title -->
          <div class="flex items-center space-x-4">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
              🛒 Grocery Items
            </h1>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center space-x-2 sm:space-x-4">
            <!-- Sync Status -->
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 rounded-full" 
                :class="isOnline && syncStatus.pendingCount === 0 ? 'bg-green-500' : isOnline && syncStatus.pendingCount > 0 ? 'bg-yellow-500' : 'bg-red-500'">
              </div>
              <span class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block">
                {{ !isOnline ? 'Offline' : syncStatus.pendingCount > 0 ? `${syncStatus.pendingCount} pending` : 'Synced' }}
              </span>
            </div>

            <!-- Theme Toggle -->
            <AppearanceTabs />

            <!-- Cart Button -->
            <button
              @click="showCartModal = true"
              class="relative flex items-center space-x-2 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg font-medium transition-colors"
            >
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13v8a2 2 0 002 2h6a2 2 0 002-2v-8m-8 0V9a2 2 0 012-2h4a2 2 0 012 2v4.01" />
              </svg>
              <span class="hidden sm:block">Cart</span>
              <span v-if="cartItemCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ cartItemCount }}
              </span>
            </button>

            <!-- Add Item Button -->
            <button
              @click="showAddModal = true"
              class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg font-medium transition-colors"
            >
              <PlusIcon class="h-5 w-5" />
              <span class="hidden sm:block">Add Item</span>
            </button>

            <!-- Dashboard Button -->
            <button
              @click="goToDashboard"
              class="flex items-center space-x-2 bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-lg font-medium transition-colors"
            >
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2V9a2 2 0 00-2-2h-2a2 2 0 00-2 2v10" />
              </svg>
              <span class="hidden sm:block">Dashboard</span>
            </button>

            <!-- Logout Button -->
            <button
              @click="logout"
              class="flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg font-medium transition-colors"
            >
              <ArrowRightOnRectangleIcon class="h-5 w-5" />
              <span class="hidden sm:block">Logout</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <!-- Items Grid -->
      <div v-if="allItems.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
        <div
          v-for="item in allItems"
          :key="('offline_id' in item ? item.offline_id : item.id)"
          class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-300"
        >
          <!-- Product Image -->
          <div class="aspect-square bg-gray-100 dark:bg-gray-700 relative">
            <img
              v-if="(item as any).image"
              :src="(item as any).image"
              :alt="item.name"
              class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
              <div class="text-6xl">📦</div>
            </div>
          </div>

          <!-- Product Info -->
          <div class="p-4">
            <h3 class="font-semibold text-gray-900 dark:text-white text-lg mb-4 text-center">
              {{ item.name }}
            </h3>
            
            <!-- Add to Cart Button -->
            <button
              @click="addToCart(item)"
              class="w-full bg-green-500 hover:bg-green-600 text-white rounded-lg py-3 px-4 transition-colors font-medium flex items-center justify-center space-x-2"
            >
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13v8a2 2 0 002 2h6a2 2 0 002-2v-8m-8 0V9a2 2 0 012-2h4a2 2 0 012 2v4.01" />
              </svg>
              <span>Add to Cart</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-12">
        <div class="text-8xl mb-4">🛒</div>
        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">
          No items in your grocery list
        </h3>
        <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
          Start by adding some items to your shopping list
        </p>
        <button
          @click="showAddModal = true"
          class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors"
        >
          Add Your First Item
        </button>
      </div>
    </div>

    <!-- Add Item Modal -->
    <div
      v-if="showAddModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
      @click.self="showAddModal = false"
    >
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Add New Item</h2>
            <button
              @click="showAddModal = false"
              class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
            >
              <XMarkIcon class="h-6 w-6" />
            </button>
          </div>

          <form @submit.prevent="addItem" class="space-y-4">
            <!-- Image Upload -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Product Image (Optional)
              </label>
              <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center">
                <div v-if="form.image" class="mb-4">
                  <img :src="form.image" alt="Preview" class="w-24 h-24 object-cover rounded-lg mx-auto" />
                </div>
                <input
                  ref="imageInput"
                  type="file"
                  accept="image/*"
                  @change="handleImageUpload"
                  class="hidden"
                />
                <button
                  type="button"
                  @click="imageInput?.click()"
                  class="text-blue-600 hover:text-blue-700 font-medium transition-colors"
                >
                  {{ form.image ? 'Change Image' : 'Upload Image' }}
                </button>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                  PNG, JPG up to 2MB
                </p>
              </div>
            </div>

            <!-- Item Name -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Item Name *
              </label>
              <input
                v-model="form.name"
                type="text"
                required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="e.g., Mushroom Sauce"
              />
            </div>

            <!-- Submit Button -->
            <div class="flex space-x-3 pt-4">
              <button
                type="button"
                @click="showAddModal = false"
                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="isSubmitting"
                class="flex-1 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white px-4 py-2 rounded-lg font-medium transition-colors"
              >
                {{ isSubmitting ? 'Adding...' : 'Add Item' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Cart Modal -->
    <div
      v-if="showCartModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
      @click.self="showCartModal = false"
    >
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <!-- Cart Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
              🛒 Shopping Cart ({{ cartItemCount }} items)
            </h2>
            <button
              @click="showCartModal = false"
              class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
            >
              <XMarkIcon class="h-6 w-6" />
            </button>
          </div>
        </div>

        <!-- Cart Items -->
        <div class="max-h-96 overflow-y-auto">
          <div v-if="cart.length === 0" class="p-8 text-center">
            <div class="text-6xl mb-4">🛒</div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
              Your cart is empty
            </h3>
            <p class="text-gray-500 dark:text-gray-400">
              Add some items to your cart to get started
            </p>
          </div>

          <div v-else class="divide-y divide-gray-200 dark:divide-gray-700">
            <div
              v-for="item in cart"
              :key="('offline_id' in item ? item.offline_id : item.id)"
              class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
            >
              <div class="flex items-start space-x-4">
                <!-- Item Image -->
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex-shrink-0">
                  <img
                    v-if="(item as any).image"
                    :src="(item as any).image"
                    :alt="item.name"
                    class="w-full h-full object-cover rounded-lg"
                  />
                  <div v-else class="w-full h-full flex items-center justify-center">
                    <div class="text-2xl">📦</div>
                  </div>
                </div>

                <!-- Item Details -->
                <div class="flex-1 min-w-0">
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate mb-2">
                    {{ item.name }}
                  </h4>
                  
                  <!-- Editable Fields -->
                  <div v-if="editingCartItem === getCartItemId(item)" class="space-y-2">
                    <!-- Quantity & Unit -->
                    <div class="grid grid-cols-2 gap-2">
                      <input
                        :value="item.quantity"
                        @input="updateCartItem(item, { quantity: parseFloat(($event.target as HTMLInputElement).value) || 1 })"
                        type="number"
                        step="0.01"
                        min="0"
                        class="px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                        placeholder="Quantity"
                      />
                      <select
                        :value="item.quantity_unit"
                        @change="updateCartItem(item, { quantity_unit: ($event.target as HTMLSelectElement).value })"
                        class="px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
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
                    
                    <!-- Price -->
                    <input
                      :value="item.price"
                      @input="updateCartItem(item, { price: parseFloat(($event.target as HTMLInputElement).value) || 0 })"
                      type="number"
                      step="0.01"
                      min="0"
                      class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                      placeholder="Price (optional)"
                    />
                    
                    <!-- Save/Cancel -->
                    <div class="flex space-x-2">
                      <button
                        @click="editingCartItem = null"
                        class="px-3 py-1 text-xs bg-green-500 hover:bg-green-600 text-white rounded transition-colors"
                      >
                        Save
                      </button>
                      <button
                        @click="editingCartItem = null"
                        class="px-3 py-1 text-xs bg-gray-500 hover:bg-gray-600 text-white rounded transition-colors"
                      >
                        Cancel
                      </button>
                    </div>
                  </div>
                  
                  <!-- Display Mode -->
                  <div v-else class="space-y-1">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                      {{ item.quantity }} {{ item.quantity_unit }}
                    </p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                      ${{ Number(item.price).toFixed(2) }}
                    </p>
                    <div v-if="item.is_done" class="inline-flex items-center px-2 py-1 text-xs bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                      ✅ Done
                    </div>
                  </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col space-y-2">
                  <!-- Edit Button -->
                  <button
                    v-if="editingCartItem !== getCartItemId(item)"
                    @click="editingCartItem = getCartItemId(item)"
                    class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors text-sm"
                    title="Edit item"
                  >
                    ✏️
                  </button>
                  
                  <!-- Mark as Done Button -->
                  <button
                    v-if="!item.is_done && editingCartItem !== getCartItemId(item)"
                    @click="markCartItemAsDone(item)"
                    class="text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors text-sm"
                    title="Mark as done"
                  >
                    ✅
                  </button>
                  
                  <!-- Remove Button -->
                  <button
                    @click="removeFromCart(item)"
                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                    title="Remove from cart"
                  >
                    <TrashIcon class="h-4 w-4" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Cart Footer -->
        <div v-if="cart.length > 0" class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
          <div class="flex justify-between items-center mb-4">
            <span class="text-lg font-semibold text-gray-900 dark:text-white">
              Total: ${{ cartTotal.toFixed(2) }}
            </span>
            <div class="flex space-x-3">
              <button
                @click="clearCart"
                class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
              >
                Clear Cart
              </button>
              <button
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors"
                @click="showCartModal = false"
              >
                Continue Shopping
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'
import AppearanceTabs from '@/components/AppearanceTabs.vue'
import { offlineSyncService, type Item, type OfflineItem } from '@/services/offlineSync'
import items from '@/routes/items'

// Define icons as simple components
const PlusIcon = { template: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>' }
const CheckIcon = { template: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>' }
const TrashIcon = { template: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>' }
const XMarkIcon = { template: '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>' }
const ArrowRightOnRectangleIcon = { template: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>' }
const CloudArrowUpIcon = { template: '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>' }

// Props from Laravel controller
interface Props {
  items: Item[]
}

const props = defineProps<Props>()

// Reactive state
const allItems = ref<(Item | OfflineItem)[]>([])
const showAddModal = ref(false)
const showCartModal = ref(false)
const isSubmitting = ref(false)
const isOnline = ref(navigator.onLine)
const syncStatus = ref({ pendingCount: 0, isOnline: true })
const imageInput = ref<HTMLInputElement>()
const cart = ref<(Item | OfflineItem)[]>([])  // Shopping cart
const editingCartItem = ref<string | null>(null) // For editing cart items

// Form data
const form = ref({
  name: '',
  image: ''
})

// Computed properties

const cartTotal = computed(() => {
  return cart.value.reduce((sum, item) => sum + Number(item.price) * Number(item.quantity), 0)
})

const cartItemCount = computed(() => {
  return cart.value.length
})

// Methods
const loadItems = async () => {
  // Load server items
  const serverItems = props.items

  // Load offline items
  const offlineItems = await offlineSyncService.getAllOffline()
  
  // Combine both, avoiding duplicates
  allItems.value = [...serverItems, ...offlineItems]
}

const updateSyncStatus = async () => {
  syncStatus.value = await offlineSyncService.getSyncStatus()
}

const handleImageUpload = (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0]
  if (file) {
    if (file.size > 2 * 1024 * 1024) {
      alert('Image size should be less than 2MB')
      return
    }
    
    const reader = new FileReader()
    reader.onload = (e) => {
      form.value.image = e.target?.result as string
    }
    reader.readAsDataURL(file)
  }
}

const addItem = async () => {
  if (isSubmitting.value) return
  
  isSubmitting.value = true
  
  try {
    const currentDate = new Date()
    const currentMonth = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}`
    
    const itemData = {
      ...form.value,
      quantity: 1, // Default quantity
      quantity_unit: 'পিস', // Default unit
      price: 0, // Default price
      month: currentMonth,
      is_done: false
    }

    if (isOnline.value) {
      // Try to save to server
      try {
        const response = await axios.post('/items', itemData)
        if (response.data.success) {
          // Add to local list
          allItems.value.unshift(response.data.item)
          resetForm()
          showAddModal.value = false
        }
      } catch (error) {
        // If server fails, save offline
        console.error('Server save failed, saving offline:', error)
        const offlineItem = await offlineSyncService.saveOffline(itemData)
        allItems.value.unshift(offlineItem)
        resetForm()
        showAddModal.value = false
        await updateSyncStatus()
      }
    } else {
      // Save offline
      const offlineItem = await offlineSyncService.saveOffline(itemData)
      allItems.value.unshift(offlineItem)
      resetForm()
      showAddModal.value = false
      await updateSyncStatus()
    }
  } catch (error) {
    console.error('Failed to add item:', error)
    alert('Failed to add item. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}

const toggleDone = async (item: Item | OfflineItem) => {
  const newStatus = !item.is_done
  
  if ('offline_id' in item) {
    // Update offline item
    await offlineSyncService.updateOffline(item.offline_id, { is_done: newStatus })
    const itemIndex = allItems.value.findIndex(i => 'offline_id' in i && i.offline_id === item.offline_id)
    if (itemIndex !== -1) {
      (allItems.value[itemIndex] as OfflineItem).is_done = newStatus
    }
    await updateSyncStatus()
  } else if (item.id) {
    // Update server item
    try {
      const response = await axios.put(`/items/${item.id}`, { is_done: newStatus })
      if (response.data.success) {
        const itemIndex = allItems.value.findIndex(i => 'id' in i && i.id === item.id)
        if (itemIndex !== -1) {
          (allItems.value[itemIndex] as Item).is_done = newStatus
        }
      }
    } catch (error) {
      console.error('Failed to update item:', error)
      alert('Failed to update item. Please try again.')
    }
  }
}

const deleteItem = async (item: Item | OfflineItem) => {
  if (!confirm('Are you sure you want to delete this item?')) return
  
  if ('offline_id' in item) {
    // Delete offline item
    await offlineSyncService.deleteOffline(item.offline_id)
    allItems.value = allItems.value.filter(i => !('offline_id' in i) || i.offline_id !== item.offline_id)
    await updateSyncStatus()
  } else if (item.id) {
    // Delete server item
    try {
      const response = await axios.delete(`/items/${item.id}`)
      if (response.data.success) {
        allItems.value = allItems.value.filter(i => !('id' in i) || i.id !== item.id)
      }
    } catch (error) {
      console.error('Failed to delete item:', error)
      alert('Failed to delete item. Please try again.')
    }
  }
}

const resetForm = () => {
  form.value = {
    name: '',
    image: ''
  }
  if (imageInput.value) {
    imageInput.value.value = ''
  }
}

const handleOnlineStatusChange = () => {
  isOnline.value = navigator.onLine
  updateSyncStatus()
}

const addToCart = (item: Item | OfflineItem) => {
  // Check if item already in cart
  const existingItem = cart.value.find(cartItem => {
    if ('offline_id' in item && 'offline_id' in cartItem) {
      return item.offline_id === cartItem.offline_id
    } else if ('id' in item && 'id' in cartItem) {
      return item.id === cartItem.id
    }
    return false
  })

  if (!existingItem) {
    cart.value.push(item)
  }
}

const removeFromCart = (item: Item | OfflineItem) => {
  cart.value = cart.value.filter(cartItem => {
    if ('offline_id' in item && 'offline_id' in cartItem) {
      return item.offline_id !== cartItem.offline_id
    } else if ('id' in item && 'id' in cartItem) {
      return item.id !== cartItem.id
    }
    return true
  })
}

const clearCart = () => {
  cart.value = []
}

const isInCart = (item: Item | OfflineItem): boolean => {
  return cart.value.some(cartItem => {
    if ('offline_id' in item && 'offline_id' in cartItem) {
      return item.offline_id === cartItem.offline_id
    } else if ('id' in item && 'id' in cartItem) {
      return item.id === cartItem.id
    }
    return false
  })
}

const updateCartItem = (item: Item | OfflineItem, updates: Partial<Item>) => {
  const index = cart.value.findIndex(cartItem => {
    if ('offline_id' in item && 'offline_id' in cartItem) {
      return item.offline_id === cartItem.offline_id
    } else if ('id' in item && 'id' in cartItem) {
      return item.id === cartItem.id
    }
    return false
  })

  if (index !== -1) {
    cart.value[index] = { ...cart.value[index], ...updates }
  }
}

const markCartItemAsDone = async (item: Item | OfflineItem, price?: number) => {
  // Update price if provided
  if (price !== undefined) {
    updateCartItem(item, { price: price })
  }
  
  // Mark as done
  updateCartItem(item, { is_done: true })
  
  // Also update in main items list
  await toggleDone(item)
  
  // Remove from cart after marking as done
  removeFromCart(item)
}

const getCartItemId = (item: Item | OfflineItem): string => {
  if ('offline_id' in item) {
    return item.offline_id
  } else if ('id' in item) {
    return item.id?.toString() || ''
  }
  return ''
}

const logout = async () => {
  if (confirm('Are you sure you want to logout?')) {
    try {
      await axios.post('/pin-logout')
      window.location.href = '/'
    } catch (error) {
      console.error('Logout failed:', error)
      // Force redirect anyway
      window.location.href = '/'
    }
  }
}

const goToDashboard = () => {
  router.get('/dashboard')
}

// Lifecycle
onMounted(async () => {
  // Setup offline sync
  offlineSyncService.setupAutoSync()
  
  // Load items
  await loadItems()
  await updateSyncStatus()
  
  // Listen for online/offline events
  window.addEventListener('online', handleOnlineStatusChange)
  window.addEventListener('offline', handleOnlineStatusChange)
  
  // Attempt sync if online
  if (isOnline.value) {
    offlineSyncService.attemptSync()
  }
})

onUnmounted(() => {
  window.removeEventListener('online', handleOnlineStatusChange)
  window.removeEventListener('offline', handleOnlineStatusChange)
})
</script>
