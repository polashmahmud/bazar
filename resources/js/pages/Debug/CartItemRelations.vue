<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 p-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Cart Item Relationship Debugger</h1>

      <!-- Control Panel -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Cart ID Section -->
          <div>
            <h2 class="text-lg font-semibold mb-3">Check by Cart ID</h2>
            <div class="flex space-x-3">
              <input
                v-model="cartId"
                type="text"
                placeholder="Enter cart_id"
                class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
              />
              <button
                @click="checkCartItem"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors"
              >
                Check
              </button>
            </div>
          </div>

          <!-- Item ID Section -->
          <div>
            <h2 class="text-lg font-semibold mb-3">Check by Item ID</h2>
            <div class="flex space-x-3">
              <input
                v-model="itemId"
                type="text"
                placeholder="Enter item_id"
                class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
              />
              <button
                @click="checkItem"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors"
              >
                Check
              </button>
            </div>
          </div>
        </div>

        <div class="mt-6">
          <h2 class="text-lg font-semibold mb-3">Test Actions</h2>
          <div class="flex flex-wrap gap-3">
            <button
              @click="getStatistics"
              class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors"
            >
              Get Statistics
            </button>
            <button
              @click="testMarkItemAsDone"
              :disabled="!itemId"
              class="px-4 py-2 bg-green-600 hover:bg-green-700 disabled:bg-green-400 text-white rounded-lg font-medium transition-colors"
            >
              Test Mark Item As Done
            </button>
            <button
              @click="testMarkCartItemAsDone"
              :disabled="!cartId"
              class="px-4 py-2 bg-green-600 hover:bg-green-700 disabled:bg-green-400 text-white rounded-lg font-medium transition-colors"
            >
              Test Mark Cart Item As Done
            </button>
          </div>
        </div>
      </div>

      <!-- Results Section -->
      <div v-if="results" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4">Results</h2>
        
        <div class="overflow-x-auto">
          <pre class="text-sm bg-gray-100 dark:bg-gray-900 p-4 rounded-lg overflow-auto max-h-96">{{ JSON.stringify(results, null, 2) }}</pre>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'

const cartId = ref('')
const itemId = ref('')
const results = ref<any>(null)

const checkCartItem = async () => {
  if (!cartId.value) return
  
  try {
    const response = await axios.get('/debug/cart-item-relationship', {
      params: { cart_id: cartId.value }
    })
    results.value = response.data
  } catch (error) {
    console.error('Error checking cart item:', error)
    results.value = { error: 'Failed to check cart item' }
  }
}

const checkItem = async () => {
  if (!itemId.value) return
  
  try {
    const response = await axios.get('/debug/cart-item-relationship', {
      params: { item_id: itemId.value }
    })
    results.value = response.data
  } catch (error) {
    console.error('Error checking item:', error)
    results.value = { error: 'Failed to check item' }
  }
}

const getStatistics = async () => {
  try {
    const response = await axios.get('/debug/cart-item-relationship')
    results.value = response.data
  } catch (error) {
    console.error('Error getting statistics:', error)
    results.value = { error: 'Failed to get statistics' }
  }
}

const testMarkItemAsDone = async () => {
  if (!itemId.value) return
  
  try {
    const response = await axios.post('/debug/test-mark-item-done', {
      item_id: itemId.value,
      price: 15.99 // Test with a sample price
    })
    results.value = response.data
  } catch (error) {
    console.error('Error testing mark item as done:', error)
    results.value = { error: 'Failed to test mark item as done' }
  }
}

const testMarkCartItemAsDone = async () => {
  if (!cartId.value) return
  
  try {
    const response = await axios.post('/debug/test-mark-cart-item-done', {
      cart_id: cartId.value
    })
    results.value = response.data
  } catch (error) {
    console.error('Error testing mark cart item as done:', error)
    results.value = { error: 'Failed to test mark cart item as done' }
  }
}
</script>
