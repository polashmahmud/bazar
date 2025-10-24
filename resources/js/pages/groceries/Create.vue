<script setup lang="ts">
import GrocerySearch from '@/components/groceries/GrocerySearch.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ChevronLeft, ShoppingBasket } from 'lucide-vue-next';
import type { GroceryItem, GroceryList } from '@/types/grocery';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

defineProps<{
    items: GroceryItem[];
    addedItems: GroceryList[];
}>();

const basketItemCount = 100;

const dialogOpen = ref(false);
const selectedItem = ref<GroceryItem | null>(null);

// Available units
const units = [
    { value: 'kg', label: 'কেজি (kg)' },
    { value: 'gm', label: 'গ্রাম (gm)' },
    { value: 'ltr', label: 'লিটার (ltr)' },
    { value: 'ml', label: 'মিলিলিটার (ml)' },
    { value: 'pcs', label: 'পিস (pcs)' },
    { value: 'dozen', label: 'ডজন (dozen)' },
    { value: 'bundle', label: 'বান্ডিল (bundle)' },
    { value: 'packet', label: 'প্যাকেট (packet)' },
];

const form = useForm({
    grocery_item_id: null as number | null,
    quantity: 1,
    unit: 'kg',
});

const handleItemSelected = (item: GroceryItem) => {
    selectedItem.value = item;
    form.grocery_item_id = item.id;
    form.quantity = 1;
    form.unit = 'kg';
    dialogOpen.value = true;
};

const submitForm = () => {
    form.post('/groceries-list', {
        onSuccess: () => {
            dialogOpen.value = false;
            form.reset();
            selectedItem.value = null;
        },
    });
};
</script>

<template>

    <Head title="Smart Bazar" />

    <div class="min-h-screen bg-white">
        <!-- Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
            <button @click="$inertia.visit('/dashboard')" class="text-green-600 p-1">
                <ChevronLeft :size="24" />
            </button>
            <h1 class="text-lg font-medium text-gray-800">Smart Bazar</h1>
            <button class="text-green-600 p-1 relative" @click="$inertia.visit('/groceries-list')">
                <ShoppingBasket :size="24" />
                <span v-if="addedItems.length > 0"
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ addedItems.length }}
                </span>
            </button>
        </div>

        <!-- Grocery Search Component -->
        <GrocerySearch @item-selected="handleItemSelected" />

        <div class="p-4">
            <div class="grid grid-cols-2 gap-3">
                <button v-for="item in items" :key="item.id" @click="handleItemSelected(item)"
                    class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-500 active:bg-green-100 cursor-pointer transition-all duration-200 text-left">
                    <span class="text-2xl flex-shrink-0">{{ item.icon }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ item.name_bn }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ item.name_bn_en }}</p>
                    </div>
                </button>
            </div>

            <!-- Added Items Display -->
            <div v-if="addedItems.length > 0" class="mt-6">
                <p class="text-xs text-gray-500">
                    লিস্টে আছে:
                    <template v-for="(addedItem, index) in addedItems" :key="addedItem.id">
                        {{ addedItem.item.name_bn }}<span v-if="index < addedItems.length - 1">, </span>
                    </template>
                </p>
            </div>
        </div>

        <!-- Add to List Dialog -->
        <Dialog v-model:open="dialogOpen">
            <DialogContent class="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>লিস্টে যুক্ত করুন</DialogTitle>
                    <DialogDescription v-if="selectedItem">
                        {{ selectedItem.name_bn }} লিস্টে যুক্ত করতে পরিমাণ ও একক নির্বাচন করুন
                    </DialogDescription>
                </DialogHeader>
                <div class="grid gap-4 py-4">
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="quantity" class="text-right">
                            পরিমাণ
                        </Label>
                        <Input id="quantity" v-model="form.quantity" type="number" step="0.01" min="0.01"
                            class="col-span-3" />
                    </div>
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="unit" class="text-right">
                            একক
                        </Label>
                        <select id="unit" v-model="form.unit"
                            class="col-span-3 flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                            <option v-for="unit in units" :key="unit.value" :value="unit.value">
                                {{ unit.label }}
                            </option>
                        </select>
                    </div>
                </div>
                <DialogFooter>
                    <Button type="submit" @click="submitForm" :disabled="form.processing">
                        {{ form.processing ? 'যুক্ত হচ্ছে...' : 'লিস্টে যুক্ত করুন' }}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </div>
</template>
