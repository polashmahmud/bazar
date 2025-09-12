<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Title -->
          <div class="flex items-center space-x-4">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
              📊 Dashboard
            </h1>
            <span class="text-sm text-gray-500 dark:text-gray-400 hidden sm:block">
              {{ monthlySummary.month_name }}
            </span>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center space-x-2 sm:space-x-4">
            <!-- Theme Toggle -->
            <AppearanceTabs />

            <!-- Items Page Button -->
            <button
              @click="goToItems"
              class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg font-medium transition-colors"
            >
              <ShoppingCartIcon class="h-5 w-5" />
              <span class="hidden sm:block">Items</span>
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

      <!-- Summary Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Expense -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                <CurrencyDollarIcon class="w-5 h-5 text-green-600 dark:text-green-400" />
              </div>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                  Total Expense
                </dt>
                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                  ${{ monthlySummary.total_amount.toFixed(2) }}
                </dd>
              </dl>
            </div>
          </div>
        </div>

        <!-- Total Items -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                <CheckIcon class="w-5 h-5 text-blue-600 dark:text-blue-400" />
              </div>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                  Items Purchased
                </dt>
                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                  {{ monthlySummary.total_items }}
                </dd>
              </dl>
            </div>
          </div>
        </div>

        <!-- Total Quantity -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                <HashtagIcon class="w-5 h-5 text-purple-600 dark:text-purple-400" />
              </div>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                  Total Quantity
                </dt>
                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                  {{ monthlySummary.total_quantity }}
                </dd>
              </dl>
            </div>
          </div>
        </div>

        <!-- Average per Item -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                <CalculatorIcon class="w-5 h-5 text-yellow-600 dark:text-yellow-400" />
              </div>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                  Avg per Item
                </dt>
                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                  ${{ monthlySummary.average_per_item.toFixed(2) }}
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- Purchased Items Table -->
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            ✅ Purchased Items - {{ monthlySummary.month_name }}
          </h2>
        </div>

        <div v-if="doneItems.length === 0" class="p-8 text-center">
          <div class="text-6xl mb-4">📝</div>
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
            No purchased items yet
          </h3>
          <p class="text-gray-500 dark:text-gray-400">
            Items you mark as done will appear here with purchase details
          </p>
        </div>

        <div v-else class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                  Item
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                  Quantity
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                  Price
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                  Total
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                  Date
                </th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              <tr
                v-for="item in doneItems"
                :key="item.id"
                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
              >
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex-shrink-0 mr-4">
                      <img
                        v-if="item.image"
                        :src="item.image"
                        :alt="item.name"
                        class="w-full h-full object-cover rounded-lg"
                      />
                      <div v-else class="w-full h-full flex items-center justify-center">
                        <div class="text-lg">📦</div>
                      </div>
                    </div>
                    <div>
                      <div class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ item.name }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                  {{ item.quantity }} {{ item.quantity_unit }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                  ${{ Number(item.price).toFixed(2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                  ${{ (Number(item.price) * Number(item.quantity)).toFixed(2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                  {{ formatDate(item.updated_at) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'
import AppearanceTabs from '@/components/AppearanceTabs.vue'

// Define icons as simple components
const CheckIcon = { template: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>' }
const ArrowRightOnRectangleIcon = { template: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>' }
const ShoppingCartIcon = { template: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13v8a2 2 0 002 2h6a2 2 0 002-2v-8m-8 0V9a2 2 0 012-2h4a2 2 0 012 2v4.01" /></svg>' }
const CurrencyDollarIcon = { template: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" /></svg>' }
const HashtagIcon = { template: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" /></svg>' }
const CalculatorIcon = { template: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>' }

// Props from Laravel controller
interface Item {
  id: number
  name: string
  quantity: number
  quantity_unit: string
  image?: string
  price: number
  month: string
  is_done: boolean
  created_at: string
  updated_at: string
}

interface MonthlySummary {
  total_amount: number
  total_items: number
  total_quantity: number
  average_per_item: number
  month: string
  month_name: string
}

interface Props {
  doneItems: Item[]
  currentMonth: string
  monthlySummary: MonthlySummary
  yearlyComparison: any[]
}

const props = defineProps<Props>()

// Reactive state
const selectedMonth = ref(props.currentMonth)

// Computed properties
const availableMonths = computed(() => {
  const months = []
  const now = new Date()
  
  for (let i = -6; i <= 6; i++) {
    const date = new Date(now.getFullYear(), now.getMonth() + i, 1)
    const value = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`
    const label = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' })
    months.push({ value, label })
  }
  
  return months
})

// Methods
const formatDate = (dateString: string) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const changeMonth = () => {
  router.get('/dashboard', { month: selectedMonth.value })
}

const goToItems = () => {
  router.get('/items')
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
</script>
