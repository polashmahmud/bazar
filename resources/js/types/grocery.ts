export interface GroceryItem {
    id: number;
    icon: string;
    name_bn: string;
    name_bn_en: string;
    name_en: string;
}

export interface GroceryList {
    id: number;
    user_id: number;
    grocery_item_id: number;
    quantity: number;
    unit: string;
    price: number;
    total_price: number;
    purchased: boolean;
    item: GroceryItem;
}