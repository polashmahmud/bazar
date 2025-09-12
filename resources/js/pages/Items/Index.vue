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
            <span class="text-sm text-gray-500 dark:text-gray-400 hidden sm:block">
              {{ formatMonth(selectedMonth) }}
            </span>
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

            <!-- Add Item Button -->
            <button
              @click="showAddModal = true"
              class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg font-medium transition-colors"
            >
              <PlusIcon class="h-5 w-5" />
              <span class="hidden sm:block">Add Item</span>
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
      <!-- Month Selector -->
      <div class="mb-6">
        <select 
          v-model="selectedMonth" 
          @change="changeMonth"
          class="border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        >
          <option v-for="month in availableMonths" :key="month.value" :value="month.value">
            {{ month.label }}
          </option>
        </select>
      </div>

      <!-- Items Grid -->
      <div v-if="allItems.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
        <div
          v-for="item in allItems"
          :key="('offline_id' in item ? item.offline_id : item.id)"
          class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-300"
          :class="{ 'opacity-60': item.is_done, 'ring-2 ring-yellow-400 dark:ring-yellow-600': 'offline_id' in item && item.needs_sync }"
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
              <div class="text-6xl">{{ getCategoryEmoji(item.category) }}</div>
            </div>
            
            <!-- Status Indicators -->
            <div class="absolute top-3 right-3 flex space-x-2">
              <!-- Done Status -->
              <div
                v-if="item.is_done"
                class="bg-green-500 text-white rounded-full p-2"
              >
                <CheckIcon class="h-4 w-4" />
              </div>
              
              <!-- Offline Status -->
              <div
                v-if="'offline_id' in item && item.needs_sync"
                class="bg-yellow-500 text-white rounded-full p-2"
                title="Pending sync"
              >
                <CloudArrowUpIcon class="h-4 w-4" />
              </div>
            </div>
          </div>

          <!-- Product Info -->
          <div class="p-4">
            <h3 class="font-semibold text-gray-900 dark:text-white text-lg mb-1" :class="{ 'line-through': item.is_done }">
              {{ item.name }}
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
              {{ item.quantity }} {{ item.category }}
            </p>
            <div class="flex items-center justify-between">
              <span class="text-xl font-bold text-gray-900 dark:text-white">
                ${{ Number(item.price).toFixed(2) }}
              </span>
              <div class="flex space-x-2">
                <!-- Toggle Done Button -->
                <button
                  @click="toggleDone(item)"
                  class="rounded-full p-2 transition-colors"
                  :class="item.is_done 
                    ? 'bg-green-500 hover:bg-green-600 text-white' 
                    : 'bg-gray-800 dark:bg-gray-600 hover:bg-gray-700 dark:hover:bg-gray-500 text-white'"
                >
                  <CheckIcon v-if="item.is_done" class="h-5 w-5" />
                  <PlusIcon v-else class="h-5 w-5" />
                </button>
                
                <!-- Delete Button -->
                <button
                  @click="deleteItem(item)"
                  class="bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-colors"
                  title="Delete item"
                >
                  <TrashIcon class="h-4 w-4" />
                </button>
              </div>
            </div>
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
          Start by adding some items to your shopping list for {{ formatMonth(selectedMonth) }}
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

            <!-- Category -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Category *
              </label>
              <select
                v-model="form.category"
                required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
              >
                <option value="">Select Category</option>
                <option value="Dairy">🥛 Dairy</option>
                <option value="Meat">🥩 Meat</option>
                <option value="Vegetables">🥕 Vegetables</option>
                <option value="Fruits">🍎 Fruits</option>
                <option value="Grains">🌾 Grains</option>
                <option value="Beverages">🧃 Beverages</option>
                <option value="Snacks">🍿 Snacks</option>
                <option value="Household">🧽 Household</option>
                <option value="Kg">Kg</option>
                <option value="Pieces">Pieces</option>
                <option value="Bottles">Bottles</option>
                <option value="Other">📦 Other</option>
              </select>
            </div>

            <!-- Quantity -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Quantity *
              </label>
              <input
                v-model.number="form.quantity"
                type="number"
                step="0.01"
                min="0"
                required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="e.g., 1, 0.5, 24"
              />
            </div>

            <!-- Price -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Price ($) *
              </label>
              <input
                v-model.number="form.price"
                type="number"
                step="0.01"
                min="0"
                required
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="e.g., 8.92"
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
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'
import AppearanceTabs from '@/components/AppearanceTabs.vue'
import { offlineSyncService, type Item, type OfflineItem } from '@/services/offlineSync'
import items from '@/routes/items'
import { 
  PlusIcon, 
  CheckIcon, 
  TrashIcon, 
  XMarkIcon, 
  ArrowRightOnRectangleIcon,
  CloudArrowUpIcon 
} from '@heroicons/vue/24/outline'

// Props from Laravel controller
interface Props {
  items: Item[]
  currentMonth: string
}

const props = defineProps<Props>()

// Reactive state
const selectedMonth = ref(props.currentMonth)
const allItems = ref<(Item | OfflineItem)[]>([])
const showAddModal = ref(false)
const isSubmitting = ref(false)
const isOnline = ref(navigator.onLine)
const syncStatus = ref({ pendingCount: 0, isOnline: true })
const imageInput = ref<HTMLInputElement>()

// Form data
const form = ref({
  name: '',
  category: '',
  quantity: 1,
  price: 0,
  image: ''
})

// Computed properties
const availableMonths = computed(() => {
  const months = []
  const now = new Date()
  
  for (let i = -2; i <= 6; i++) {
    const date = new Date(now.getFullYear(), now.getMonth() + i, 1)
    const value = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`
    const label = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' })
    months.push({ value, label })
  }
  
  return months
})

// Methods
const formatMonth = (month: string) => {
  const [year, monthNum] = month.split('-')
  const date = new Date(parseInt(year), parseInt(monthNum) - 1, 1)
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' })
}

const getCategoryEmoji = (category: string) => {
  const emojiMap: Record<string, string> = {
    'Dairy': '🥛',
    'Meat': '🥩',
    'Vegetables': '🥕',
    'Fruits': '🍎',
    'Grains': '🌾',
    'Beverages': '🧃',
    'Snacks': '🍿',
    'Household': '🧽',
    'Kg': '⚖️',
    'Pieces': '🔢',
    'Bottles': '🍶',
    'Other': '📦'
  }
  return emojiMap[category] || '📦'
}

const loadItems = async () => {
  // Load server items
  const serverItems = props.items

  // Load offline items
  const offlineItems = await offlineSyncService.getItemsForMonth(selectedMonth.value)
  
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
    const itemData = {
      ...form.value,
      month: selectedMonth.value,
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

const changeMonth = () => {
  router.get(items.index().url, { month: selectedMonth.value })
}

const resetForm = () => {
  form.value = {
    name: '',
    category: '',
    quantity: 1,
    price: 0,
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
