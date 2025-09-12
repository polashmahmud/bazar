<template>
  <Head title="Grocery App - PIN Login" />
  
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center px-4">
    <div class="max-w-md w-full">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 shadow-lg">
          <div class="text-4xl">🛒</div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
          Grocery List
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
          Enter your 4-digit PIN to continue
        </p>
      </div>

      <!-- PIN Form -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
        <form @submit.prevent="verifyPin" class="space-y-6">
          <!-- PIN Input Display -->
          <div class="flex justify-center space-x-3 mb-8">
            <div
              v-for="(digit, index) in 4"
              :key="index"
              class="w-14 h-14 border-2 rounded-lg flex items-center justify-center text-2xl font-bold bg-gray-50 dark:bg-gray-700 transition-all duration-200"
              :class="{
                'border-blue-500 bg-blue-50 dark:bg-blue-900/20': pin.length >= index + 1,
                'border-gray-300 dark:border-gray-600': pin.length < index + 1,
                'animate-pulse': isSubmitting && pin.length >= index + 1
              }"
            >
              <span 
                v-if="pin.length > index" 
                class="text-gray-900 dark:text-white"
              >
                {{ showPin ? pin[index] : '•' }}
              </span>
            </div>
          </div>

          <!-- Hidden Input -->
          <input
            ref="pinInput"
            v-model="pin"
            type="tel"
            maxlength="4"
            class="sr-only"
            :disabled="isSubmitting"
            @input="handlePinInput"
            @keydown="handleKeydown"
            autocomplete="off"
            inputmode="numeric"
          />

          <!-- Toggle PIN visibility -->
          <div class="flex justify-center">
            <button
              type="button"
              @click="togglePinVisibility"
              class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
            >
              {{ showPin ? '🙈 Hide PIN' : '👁️ Show PIN' }}
            </button>
          </div>

          <!-- Error Message -->
          <div 
            v-if="errorMessage" 
            class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 text-center"
          >
            <p class="text-red-600 dark:text-red-400 text-sm font-medium">
              {{ errorMessage }}
            </p>
          </div>

          <!-- Success Message -->
          <div 
            v-if="successMessage" 
            class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3 text-center"
          >
            <p class="text-green-600 dark:text-green-400 text-sm font-medium">
              {{ successMessage }}
            </p>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="pin.length !== 4 || isSubmitting"
            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
            :class="{
              'animate-pulse': isSubmitting
            }"
          >
            <span v-if="isSubmitting" class="flex items-center justify-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Verifying...
            </span>
            <span v-else>
              Enter Grocery App
            </span>
          </button>
        </form>
      </div>

      <!-- Virtual Keypad -->
      <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-3 gap-3">
          <button
            v-for="num in [1, 2, 3, 4, 5, 6, 7, 8, 9]"
            :key="num"
            @click="addDigit(num.toString())"
            :disabled="pin.length >= 4 || isSubmitting"
            class="h-14 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg font-bold text-lg text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ num }}
          </button>
          
          <!-- Empty space for layout -->
          <div></div>
          
          <!-- Zero button -->
          <button
            @click="addDigit('0')"
            :disabled="pin.length >= 4 || isSubmitting"
            class="h-14 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg font-bold text-lg text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            0
          </button>
          
          <!-- Backspace button -->
          <button
            @click="removeDigit"
            :disabled="pin.length === 0 || isSubmitting"
            class="h-14 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Footer -->
      <div class="text-center mt-6">
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Need help? Contact your family member for the PIN.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'

// Reactive data
const pin = ref('')
const showPin = ref(false)
const isSubmitting = ref(false)
const errorMessage = ref('')
const successMessage = ref('')
const pinInput = ref<HTMLInputElement>()

// Methods
const handlePinInput = () => {
  // Ensure only digits and max 4 characters
  pin.value = pin.value.replace(/[^0-9]/g, '').slice(0, 4)
  
  // Auto-submit when 4 digits are entered
  if (pin.value.length === 4) {
    verifyPin()
  }
}

const handleKeydown = (event: KeyboardEvent) => {
  // Allow backspace, delete, tab, escape, enter
  if ([8, 9, 27, 13, 46].includes(event.keyCode) ||
      // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
      (event.keyCode === 65 && event.ctrlKey === true) ||
      (event.keyCode === 67 && event.ctrlKey === true) ||
      (event.keyCode === 86 && event.ctrlKey === true) ||
      (event.keyCode === 88 && event.ctrlKey === true)) {
    return
  }
  
  // Ensure that it is a number and stop the keypress
  if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105)) {
    event.preventDefault()
  }
}

const addDigit = (digit: string) => {
  if (pin.value.length < 4) {
    pin.value += digit
    
    // Auto-submit when 4 digits are entered
    if (pin.value.length === 4) {
      verifyPin()
    }
  }
}

const removeDigit = () => {
  pin.value = pin.value.slice(0, -1)
  clearMessages()
}

const togglePinVisibility = () => {
  showPin.value = !showPin.value
}

const clearMessages = () => {
  errorMessage.value = ''
  successMessage.value = ''
}

const verifyPin = async () => {
  if (pin.value.length !== 4 || isSubmitting.value) return
  
  isSubmitting.value = true
  clearMessages()
  
  try {
    const response = await axios.post('/pin-verify', { pin: pin.value })
    
    if (response.data.success) {
      successMessage.value = 'PIN verified! Redirecting...'
      
      // Redirect after a short delay
      setTimeout(() => {
        window.location.href = response.data.redirect
      }, 1000)
    }
  } catch (error: any) {
    if (error.response?.status === 422) {
      errorMessage.value = error.response.data.message || 'Incorrect PIN. Please try again.'
    } else {
      errorMessage.value = 'An error occurred. Please try again.'
    }
    
    // Reset PIN on error
    pin.value = ''
    
    // Focus input for next attempt
    nextTick(() => {
      pinInput.value?.focus()
    })
  } finally {
    isSubmitting.value = false
  }
}

// Lifecycle
onMounted(() => {
  // Auto-focus the PIN input
  nextTick(() => {
    pinInput.value?.focus()
  })
})
</script>

<style scoped>
/* Hide number input spinners */
input[type="tel"]::-webkit-outer-spin-button,
input[type="tel"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="tel"] {
  appearance: textfield;
  -moz-appearance: textfield;
}
</style>
