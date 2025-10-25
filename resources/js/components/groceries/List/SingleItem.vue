<script setup lang="ts">
import { type GroceryList } from '@/types/grocery';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
    item: GroceryList;
}>();

const toggleItem = () => {
    router.post(`/groceries/${props.item.id}/purchase`, {}, {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <div class="group hover:bg-gray-50 transition-colors rounded-lg">
        <div class="flex items-center justify-between py-4 px-3 border-b border-gray-100">
            <button @click="toggleItem" class="flex items-center gap-4 flex-1">
                <!-- Checkbox/Status Indicator -->
                <div class="flex-shrink-0">
                    <div class="w-7 h-7 rounded-lg border-2 flex items-center justify-center transition-all shadow-sm"
                        :class="item.purchased ? 'bg-green-500 border-green-500' : 'bg-white border-gray-300 group-hover:border-gray-400'">
                        <svg v-if="item.purchased" class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <!-- Item Info -->
                <div class="flex items-center gap-3 flex-1">
                    <!-- Icon -->
                    <span class="text-2xl flex-shrink-0">{{ item.item.icon }}</span>

                    <!-- Name -->
                    <div class="flex flex-col">
                        <span class="text-base font-semibold transition-all"
                            :class="item.purchased ? 'text-green-600 line-through' : 'text-gray-800'">
                            {{ item.item.name_bn }}
                        </span>
                        <span class="text-xs text-gray-500">{{ item.item.name_en }}</span>
                    </div>
                </div>
            </button>

            <!-- Quantity & Price -->
            <div class="flex items-center gap-6 ml-4">
                <!-- Quantity -->
                <div class="text-right">
                    <div class="text-sm font-medium text-gray-700">
                        {{ item.quantity }} {{ item.unit }}
                    </div>
                </div>

                <!-- Price (if available) -->
                <div v-if="item.price || item.total_price" class="text-right min-w-[80px]">
                    <div v-if="item.total_price" class="text-base font-bold text-gray-900">
                        ৳{{ Number(item.total_price).toFixed(2) }}
                    </div>
                    <div v-else-if="item.price" class="text-sm text-gray-600">
                        ৳{{ Number(item.price).toFixed(2) }}/{{ item.unit }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>