<script setup lang="ts">
import { type GroceryList } from '@/types/grocery';
import { router } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    item: GroceryList;
}>();

const isDeleting = ref(false);

const toggleItem = () => {
    router.post(`/groceries/${props.item.id}/purchase`, {}, {
        preserveScroll: true,
        preserveState: true,
    });
};

const deleteItem = () => {
    if (confirm(`আপনি কি "${props.item.item.name_bn}" মুছে ফেলতে চান?`)) {
        isDeleting.value = true;
        router.delete(`/groceries-list/${props.item.id}`, {
            preserveScroll: true,
            onFinish: () => {
                isDeleting.value = false;
            },
        });
    }
};
</script>

<template>
    <!-- Mobile View -->
    <div class="sm:hidden group hover:bg-gray-50 transition-all duration-150">
        <div class="flex items-start gap-3 px-4 py-4">
            <!-- Checkbox -->
            <button @click="toggleItem" class="flex-shrink-0 mt-0.5">
                <div class="w-5 h-5 rounded border-2 flex items-center justify-center transition-all duration-200"
                    :class="item.purchased 
                        ? 'bg-gray-900 border-gray-900' 
                        : 'bg-white border-gray-300 group-hover:border-gray-400'">
                    <svg v-if="item.purchased" class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </button>

            <!-- Item Info -->
            <div class="flex-1 min-w-0">
                <div class="flex items-start gap-2">
                    <span class="text-2xl flex-shrink-0">{{ item.item.icon }}</span>

                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold transition-all duration-200"
                            :class="item.purchased ? 'text-gray-400 line-through' : 'text-gray-900'">
                            {{ item.item.name_bn }}
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">{{ item.item.name_en }}</p>
                        
                        <div v-if="item.price && item.total_price" class="mt-2">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <span class="font-medium">{{ item.quantity }} {{ item.unit }}</span>
                                <span>×</span>
                                <span>৳{{ Number(item.price).toFixed(2) }}</span>
                                <span>=</span>
                                <span class="font-bold text-gray-900">৳{{ Number(item.total_price).toFixed(2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button @click="deleteItem" :disabled="isDeleting"
                class="flex-shrink-0 p-2 text-gray-300 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-all duration-150 disabled:opacity-30"
                title="মুছে ফেলুন">
                <Trash2 class="w-4 h-4" />
            </button>
        </div>
    </div>

    <!-- Desktop View -->
    <div class="hidden sm:block group hover:bg-gray-50 transition-all duration-150">
        <div class="flex items-center px-6 py-4">
            <!-- Checkbox + Icon + Name (40%) -->
            <div class="flex items-center gap-4 flex-1 min-w-0" style="flex: 0 0 40%;">
                <button @click="toggleItem" class="flex-shrink-0">
                    <div class="w-5 h-5 rounded border-2 flex items-center justify-center transition-all duration-200"
                        :class="item.purchased 
                            ? 'bg-gray-900 border-gray-900' 
                            : 'bg-white border-gray-300 group-hover:border-gray-400'">
                        <svg v-if="item.purchased" class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </button>

                <span class="text-3xl flex-shrink-0">{{ item.item.icon }}</span>

                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-semibold transition-all duration-200 truncate"
                        :class="item.purchased ? 'text-gray-400 line-through' : 'text-gray-900'">
                        {{ item.item.name_bn }}
                    </h3>
                    <p class="text-xs text-gray-400 truncate">{{ item.item.name_en }}</p>
                </div>
            </div>

            <!-- Quantity (15%) -->
            <div class="text-center" style="flex: 0 0 15%;">
                <div class="text-sm font-medium text-gray-900">{{ item.quantity }} {{ item.unit }}</div>
            </div>

            <!-- Unit Price (15%) -->
            <div class="text-center" style="flex: 0 0 15%;">
                <div v-if="item.price" class="text-sm text-gray-600">
                    × ৳{{ Number(item.price).toFixed(2) }}
                </div>
                <div v-else class="text-sm text-gray-400">-</div>
            </div>

            <!-- Total Price (20%) -->
            <div class="text-right" style="flex: 0 0 20%;">
                <div v-if="item.total_price" class="text-base font-bold text-gray-900">
                    = ৳{{ Number(item.total_price).toFixed(2) }}
                </div>
                <div v-else class="text-sm text-gray-400">-</div>
            </div>

            <!-- Delete Button (10%) -->
            <div class="flex justify-end" style="flex: 0 0 10%;">
                <button @click="deleteItem" :disabled="isDeleting"
                    class="p-2 text-gray-300 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-all duration-150 disabled:opacity-30"
                    title="মুছে ফেলুন">
                    <Trash2 class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
</template>
