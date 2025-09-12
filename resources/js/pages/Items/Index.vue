<template>
  <Head title="Grocery List" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <!-- Header with sync status and month selector -->
      <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
          <h1 class="text-2xl font-bold text-foreground">Grocery List</h1>
          <p class="text-sm text-muted-foreground">
            Manage your monthly grocery items
          </p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
          <!-- Theme Toggle -->
          <div class="order-3 sm:order-1">
            <AppearanceTabs />
          </div>
          
          <!-- Sync Status -->
          <div class="flex items-center space-x-2 order-1 sm:order-2">
            <span class="text-xs text-muted-foreground">Status:</span>
            <div 
              :class="{
                'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400': isOnline && syncStatus.pendingCount === 0,
                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400': isOnline && syncStatus.pendingCount > 0,
                'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400': !isOnline
              }"
              class="px-2 py-1 rounded-full text-xs font-medium"
            >
              <span v-if="!isOnline">Offline</span>
              <span v-else-if="syncStatus.pendingCount > 0">
                {{ syncStatus.pendingCount }} pending sync
              </span>
              <span v-else>Synced</span>
            </div>
          </div>
          <!-- Month Selector -->
          <div class="flex items-center space-x-2 order-2 sm:order-3">
            <label for="month-select" class="text-xs text-muted-foreground">Month:</label>
            <select 
              id="month-select"
              v-model="selectedMonth" 
              @change="changeMonth"
              class="border border-input rounded-md px-3 py-2 bg-background text-foreground focus:border-ring focus:ring-ring focus:ring-2 focus:ring-offset-2 text-sm"
            >
              <option v-for="month in availableMonths" :key="month.value" :value="month.value">
                {{ month.label }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Add Item Form -->
        <div class="xl:col-span-1">
          <div class="bg-card shadow-md border border-border rounded-lg p-6">
            <h2 class="text-lg font-medium text-foreground mb-4">Add New Item</h2>
            <form @submit.prevent="addItem" class="space-y-4">
              <div>
                <label for="name" class="block text-sm font-medium text-foreground mb-1">Item Name</label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  required
                  class="w-full border border-input rounded-md px-3 py-2 bg-background text-foreground placeholder:text-muted-foreground shadow-sm focus:border-ring focus:ring-ring focus:ring-2 focus:ring-offset-2 focus:ring-offset-background transition-all"
                  placeholder="e.g., Milk, Bread, Apples"
                />
              </div>

              <div>
                <label for="category" class="block text-sm font-medium text-foreground mb-1">Category</label>
                <select
                  id="category"
                  v-model="form.category"
                  required
                  class="w-full border border-input rounded-md px-3 py-2 bg-background text-foreground shadow-sm focus:border-ring focus:ring-ring focus:ring-2 focus:ring-offset-2 focus:ring-offset-background transition-all"
                >
                  <option value="" class="text-muted-foreground">Select Category</option>
                  <option value="Dairy">🥛 Dairy</option>
                  <option value="Meat">🥩 Meat</option>
                  <option value="Vegetables">🥕 Vegetables</option>
                  <option value="Fruits">🍎 Fruits</option>
                  <option value="Grains">🌾 Grains</option>
                  <option value="Beverages">🧃 Beverages</option>
                  <option value="Snacks">🍿 Snacks</option>
                  <option value="Household">🧽 Household</option>
                  <option value="Other">📦 Other</option>
                </select>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label for="quantity" class="block text-sm font-medium text-foreground mb-1">Quantity</label>
                  <input
                    id="quantity"
                    v-model.number="form.quantity"
                    type="number"
                    step="0.01"
                    min="0"
                    required
                    class="w-full border border-input rounded-md px-3 py-2 bg-background text-foreground shadow-sm focus:border-ring focus:ring-ring focus:ring-2 focus:ring-offset-2 focus:ring-offset-background transition-all"
                  />
                </div>

                <div>
                  <label for="price" class="block text-sm font-medium text-foreground mb-1">Price ($)</label>
                  <input
                    id="price"
                    v-model.number="form.price"
                    type="number"
                    step="0.01"
                    min="0"
                    required
                    class="w-full border border-input rounded-md px-3 py-2 bg-background text-foreground shadow-sm focus:border-ring focus:ring-ring focus:ring-2 focus:ring-offset-2 focus:ring-offset-background transition-all"
                  />
                </div>
              </div>

              <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full bg-primary text-primary-foreground py-2.5 px-4 rounded-md hover:bg-primary/90 focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:ring-offset-background disabled:opacity-50 disabled:cursor-not-allowed transition-all font-medium"
              >
                <span v-if="isSubmitting">Adding...</span>
                <span v-else>Add Item</span>
              </button>
            </form>
          </div>
        </div>

        <!-- Items List -->
        <div class="xl:col-span-2">
          <div class="bg-card shadow-md border border-border rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-border bg-muted/50">
              <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                <h2 class="text-lg font-medium text-foreground">
                  Items for {{ formatMonth(selectedMonth) }}
                </h2>
                <div class="text-sm text-muted-foreground space-y-1 sm:space-y-0">
                  <div class="flex flex-wrap gap-4">
                    <span class="font-medium">Total: <span class="text-foreground">${{ totalAmount.toFixed(2) }}</span></span>
                    <span>Items: <span class="text-foreground">{{ allItems.length }}</span></span>
                    <span>Done: <span class="text-foreground">{{ doneItems.length }}</span></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="divide-y divide-border max-h-[600px] overflow-y-auto">
              <div v-if="allItems.length === 0" class="p-8 text-center">
                <div class="text-4xl mb-2">🛒</div>
                <p class="text-muted-foreground">No items for this month.</p>
                <p class="text-sm text-muted-foreground mt-1">Add your first grocery item!</p>
              </div>

              <div
                v-for="item in allItems"
                :key="('offline_id' in item ? item.offline_id : item.id)"
                :class="{
                  'opacity-60': item.is_done,
                  'bg-yellow-50 dark:bg-yellow-950/20 border-l-2 border-l-yellow-400 dark:border-l-yellow-600': 'offline_id' in item && item.needs_sync
                }"
                class="p-4 sm:p-6 hover:bg-muted/30 transition-all duration-200"
              >
                <div class="flex items-start sm:items-center justify-between gap-4">
                  <div class="flex items-start sm:items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                    <div class="flex-shrink-0 pt-1 sm:pt-0">
                      <input
                        type="checkbox"
                        :checked="item.is_done"
                        @change="toggleDone(item)"
                        class="h-4 w-4 text-primary rounded border-input focus:ring-ring focus:ring-2 focus:ring-offset-2 focus:ring-offset-background transition-all"
                      />
                    </div>
                    <div class="min-w-0 flex-1">
                      <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <h3 
                          :class="{ 'line-through': item.is_done }"
                          class="text-base sm:text-lg font-medium text-foreground break-words"
                        >
                          {{ item.name }}
                        </h3>
                        <div class="flex items-center gap-2">
                          <span 
                            v-if="'offline_id' in item && item.needs_sync"
                            class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full flex-shrink-0"
                          >
                            📱 Offline
                          </span>
                        </div>
                      </div>
                      <div class="mt-2 text-sm text-muted-foreground space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                          <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-accent text-accent-foreground font-medium">
                            {{ item.category.replace(/[^a-zA-Z]/g, '') }}
                          </span>
                          <span>Qty: <span class="font-medium text-foreground">{{ item.quantity }}</span></span>
                          <span>Price: <span class="font-medium text-foreground">${{ Number(item.price).toFixed(2) }}</span></span>
                          <span class="font-medium text-foreground">Total: ${{ (Number(item.price) * Number(item.quantity)).toFixed(2) }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <button
                    @click="deleteItem(item)"
                    class="text-destructive hover:text-destructive/80 text-sm font-medium transition-colors px-2 py-1 rounded hover:bg-destructive/10 flex-shrink-0"
                  >
                    🗑️ Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import axios from 'axios'
import AppLayout from '@/layouts/AppLayout.vue'
import AppearanceTabs from '@/components/AppearanceTabs.vue'
import { offlineSyncService, type Item, type OfflineItem } from '@/services/offlineSync'
import items from '@/routes/items'
import type { BreadcrumbItem } from '@/types'

// Props from Laravel controller
interface Props {
  items: Item[]
  currentMonth: string
}

const props = defineProps<Props>()

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Grocery List',
    href: items.index().url,
  },
]

// Reactive state
const selectedMonth = ref(props.currentMonth)
const allItems = ref<(Item | OfflineItem)[]>([])
const isSubmitting = ref(false)
const isOnline = ref(navigator.onLine)
const syncStatus = ref({ pendingCount: 0, isOnline: true })

// Form data
const form = ref({
  name: '',
  category: '',
  quantity: 1,
  price: 0
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

const totalAmount = computed(() => {
  return allItems.value.reduce((sum, item) => sum + Number(item.price) * Number(item.quantity), 0)
})

const doneItems = computed(() => {
  return allItems.value.filter(item => item.is_done)
})

// Methods
const formatMonth = (month: string) => {
  const [year, monthNum] = month.split('-')
  const date = new Date(parseInt(year), parseInt(monthNum) - 1, 1)
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' })
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
        }
      } catch (error) {
        // If server fails, save offline
        console.error('Server save failed, saving offline:', error)
        const offlineItem = await offlineSyncService.saveOffline(itemData)
        allItems.value.unshift(offlineItem)
        resetForm()
        await updateSyncStatus()
      }
    } else {
      // Save offline
      const offlineItem = await offlineSyncService.saveOffline(itemData)
      allItems.value.unshift(offlineItem)
      resetForm()
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
    price: 0
  }
}

const handleOnlineStatusChange = () => {
  isOnline.value = navigator.onLine
  updateSyncStatus()
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
