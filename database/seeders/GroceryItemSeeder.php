<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroceryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // --- Basics & Vegetables ---
            ['icon' => '🍚', 'name_bn' => 'চাল', 'name_en' => 'Rice', 'name_bn_en' => 'chaal'],
            ['icon' => '🥔', 'name_bn' => 'আলু', 'name_en' => 'Potato', 'name_bn_en' => 'alu'],
            ['icon' => '🧅', 'name_bn' => 'পেঁয়াজ', 'name_en' => 'Onion', 'name_bn_en' => 'peyaj'],
            ['icon' => '🧄', 'name_bn' => 'রসুন', 'name_en' => 'Garlic', 'name_bn_en' => 'rosun'],
            ['icon' => '🫚', 'name_bn' => 'আদা', 'name_en' => 'Ginger', 'name_bn_en' => 'ada'],
            ['icon' => '🍅', 'name_bn' => 'টমেটো', 'name_en' => 'Tomato', 'name_bn_en' => 'tomato'],
            ['icon' => '🥒', 'name_bn' => 'শসা', 'name_en' => 'Cucumber', 'name_bn_en' => 'shosha'],
            ['icon' => '🥕', 'name_bn' => 'গাজর', 'name_en' => 'Carrot', 'name_bn_en' => 'gajor'],
            ['icon' => '🥬', 'name_bn' => 'পালং শাক', 'name_en' => 'Spinach', 'name_bn_en' => 'palong shak'],
            ['icon' => '🥬', 'name_bn' => 'লাল শাক', 'name_en' => 'Red Spinach', 'name_bn_en' => 'lal shak'],
            ['icon' => '🥦', 'name_bn' => 'ব্রকলি', 'name_en' => 'Broccoli', 'name_bn_en' => 'brokli'],
            ['icon' => '🌶️', 'name_bn' => 'লংকা', 'name_en' => 'Chili', 'name_bn_en' => 'lonka'],
            ['icon' => '🍆', 'name_bn' => 'বেগুন', 'name_en' => 'Eggplant', 'name_bn_en' => 'begun'],
            ['icon' => '🥔', 'name_bn' => 'মিষ্টি আলু', 'name_en' => 'Sweet Potato', 'name_bn_en' => 'mishti alu'],
            ['icon' => '🍠', 'name_bn' => 'শালগম', 'name_en' => 'Turnip', 'name_bn_en' => 'shalgom'],
            ['icon' => '🥒', 'name_bn' => 'লাউ', 'name_en' => 'Bottle Gourd', 'name_bn_en' => 'lau'],
            ['icon' => '🥒', 'name_bn' => 'কুমড়া', 'name_en' => 'Pumpkin', 'name_bn_en' => 'kumra'],
            ['icon' => '🌽', 'name_bn' => 'ভুট্টা', 'name_en' => 'Corn', 'name_bn_en' => 'vutta'],
            ['icon' => '🍄', 'name_bn' => 'মাশরুম', 'name_en' => 'Mushroom', 'name_bn_en' => 'mashroom'],
            ['icon' => '🌰', 'name_bn' => 'শিম', 'name_en' => 'Beans', 'name_bn_en' => 'shim'],
            ['icon' => '🌶️', 'name_bn' => 'ধনে পাতা', 'name_en' => 'Coriander Leaves', 'name_bn_en' => 'dhone pata'],
            ['icon' => '🌿', 'name_bn' => 'পুদিনা পাতা', 'name_en' => 'Mint Leaf', 'name_bn_en' => 'pudina pata'],
            ['icon' => '🥬', 'name_bn' => 'লাউ শাক', 'name_en' => 'Bottle Gourd Leaf', 'name_bn_en' => 'lau shak'],
            ['icon' => '🥒', 'name_bn' => 'ঝিঙা', 'name_en' => 'Ridge Gourd', 'name_bn_en' => 'jhiga'],
            ['icon' => '🥒', 'name_bn' => 'চিচিঙ্গা', 'name_en' => 'Snake Gourd', 'name_bn_en' => 'chichinga'],
            ['icon' => '🥒', 'name_bn' => 'পটল', 'name_en' => 'Pointed Gourd', 'name_bn_en' => 'potol'],
            ['icon' => '🥬', 'name_bn' => 'ঢেঁড়স', 'name_en' => 'Ladies Finger', 'name_bn_en' => 'dherosh'],
            ['icon' => '🍆', 'name_bn' => 'লাল বেগুন', 'name_en' => 'Red Eggplant', 'name_bn_en' => 'lal begun'],

            // --- Fruits ---
            ['icon' => '🍎', 'name_bn' => 'আপেল', 'name_en' => 'Apple', 'name_bn_en' => 'apel'],
            ['icon' => '🍌', 'name_bn' => 'কলা', 'name_en' => 'Banana', 'name_bn_en' => 'kola'],
            ['icon' => '🍇', 'name_bn' => 'আঙুর', 'name_en' => 'Grapes', 'name_bn_en' => 'angur'],
            ['icon' => '🍍', 'name_bn' => 'আনারস', 'name_en' => 'Pineapple', 'name_bn_en' => 'anaras'],
            ['icon' => '🍉', 'name_bn' => 'তরমুজ', 'name_en' => 'Watermelon', 'name_bn_en' => 'tormuj'],
            ['icon' => '🍊', 'name_bn' => 'কমলা', 'name_en' => 'Orange', 'name_bn_en' => 'komola'],
            ['icon' => '🍋', 'name_bn' => 'লেবু', 'name_en' => 'Lemon', 'name_bn_en' => 'lebu'],
            ['icon' => '🍓', 'name_bn' => 'স্ট্রবেরি', 'name_en' => 'Strawberry', 'name_bn_en' => 'strawberry'],
            ['icon' => '🥭', 'name_bn' => 'আম', 'name_en' => 'Mango', 'name_bn_en' => 'aam'],
            ['icon' => '🍒', 'name_bn' => 'চেরি', 'name_en' => 'Cherry', 'name_bn_en' => 'cheri'],
            ['icon' => '🍑', 'name_bn' => 'পিচ', 'name_en' => 'Peach', 'name_bn_en' => 'pich'],
            ['icon' => '🍐', 'name_bn' => 'নাশপাতি', 'name_en' => 'Pear', 'name_bn_en' => 'nashpati'],
            ['icon' => '🥥', 'name_bn' => 'নারকেল', 'name_en' => 'Coconut', 'name_bn_en' => 'narikel'],
            ['icon' => '🍈', 'name_bn' => 'বাঙ্গি', 'name_en' => 'Melon', 'name_bn_en' => 'bangi'],
            ['icon' => '🍅', 'name_bn' => 'জলপাই', 'name_en' => 'Olive', 'name_bn_en' => 'jolpai'],

            // --- Protein ---
            ['icon' => '🥚', 'name_bn' => 'ডিম', 'name_en' => 'Egg', 'name_bn_en' => 'dim'],
            ['icon' => '🐔', 'name_bn' => 'মুরগি', 'name_en' => 'Chicken', 'name_bn_en' => 'murgi'],
            ['icon' => '🐮', 'name_bn' => 'গরুর মাংস', 'name_en' => 'Beef', 'name_bn_en' => 'gorur mangsho'],
            ['icon' => '🐐', 'name_bn' => 'ছাগলের মাংস', 'name_en' => 'Mutton', 'name_bn_en' => 'chagoler mangsho'],
            ['icon' => '🐟', 'name_bn' => 'রুই মাছ', 'name_en' => 'Rui Fish', 'name_bn_en' => 'rui mach'],
            ['icon' => '🐟', 'name_bn' => 'ইলিশ মাছ', 'name_en' => 'Hilsa Fish', 'name_bn_en' => 'ilish mach'],
            ['icon' => '🐟', 'name_bn' => 'কাতলা মাছ', 'name_en' => 'Katla Fish', 'name_bn_en' => 'katla mach'],
            ['icon' => '🐟', 'name_bn' => 'চিংড়ি', 'name_en' => 'Shrimp', 'name_bn_en' => 'chingri'],
            ['icon' => '🐟', 'name_bn' => 'তেলাপিয়া', 'name_en' => 'Tilapia', 'name_bn_en' => 'tilapia'],
            ['icon' => '🐟', 'name_bn' => 'পাঙ্গাস', 'name_en' => 'Pangas', 'name_bn_en' => 'pangas'],
            ['icon' => '🐓', 'name_bn' => 'দেশি মুরগি', 'name_en' => 'Local Chicken', 'name_bn_en' => 'deshi murgi'],

            // --- Essentials ---
            ['icon' => '🧂', 'name_bn' => 'লবণ', 'name_en' => 'Salt', 'name_bn_en' => 'lobon'],
            ['icon' => '🍬', 'name_bn' => 'চিনি', 'name_en' => 'Sugar', 'name_bn_en' => 'chini'],
            ['icon' => '🌾', 'name_bn' => 'ডাল', 'name_en' => 'Lentil', 'name_bn_en' => 'dal'],
            ['icon' => '🛢️', 'name_bn' => 'তেল', 'name_en' => 'Cooking Oil', 'name_bn_en' => 'tel'],
            ['icon' => '🧈', 'name_bn' => 'ঘি', 'name_en' => 'Ghee', 'name_bn_en' => 'ghee'],
            ['icon' => '🍯', 'name_bn' => 'মধু', 'name_en' => 'Honey', 'name_bn_en' => 'modhu'],
            ['icon' => '🧂', 'name_bn' => 'কালো জিরা', 'name_en' => 'Black Cumin', 'name_bn_en' => 'kalo jira'],
            ['icon' => '🌿', 'name_bn' => 'তেজপাতা', 'name_en' => 'Bay Leaf', 'name_bn_en' => 'tejpata'],
            ['icon' => '🥄', 'name_bn' => 'হলুদ গুঁড়া', 'name_en' => 'Turmeric Powder', 'name_bn_en' => 'holud gura'],
            ['icon' => '🥄', 'name_bn' => 'জিরা', 'name_en' => 'Cumin', 'name_bn_en' => 'jira'],
            ['icon' => '🥄', 'name_bn' => 'গরম মসলা', 'name_en' => 'Garam Masala', 'name_bn_en' => 'garam mosla'],
            ['icon' => '🍛', 'name_bn' => 'কারি পাউডার', 'name_en' => 'Curry Powder', 'name_bn_en' => 'curry powder'],

            // --- Snacks & Drinks ---
            ['icon' => '🍞', 'name_bn' => 'পাউরুটি', 'name_en' => 'Bread', 'name_bn_en' => 'pauruti'],
            ['icon' => '🥯', 'name_bn' => 'বান', 'name_en' => 'Bun', 'name_bn_en' => 'bun'],
            ['icon' => '🍪', 'name_bn' => 'বিস্কুট', 'name_en' => 'Biscuit', 'name_bn_en' => 'biscuit'],
            ['icon' => '🍫', 'name_bn' => 'চকলেট', 'name_en' => 'Chocolate', 'name_bn_en' => 'chocolate'],
            ['icon' => '🧃', 'name_bn' => 'জুস', 'name_en' => 'Juice', 'name_bn_en' => 'juice'],
            ['icon' => '☕', 'name_bn' => 'চা পাতা', 'name_en' => 'Tea Leaf', 'name_bn_en' => 'cha pata'],
            ['icon' => '🥤', 'name_bn' => 'সফট ড্রিংক', 'name_en' => 'Soft Drink', 'name_bn_en' => 'soft drink'],
            ['icon' => '🍺', 'name_bn' => 'সোডা', 'name_en' => 'Soda', 'name_bn_en' => 'soda'],
            ['icon' => '🥛', 'name_bn' => 'দই', 'name_en' => 'Yogurt', 'name_bn_en' => 'doi'],

            // --- Others & Household ---
            ['icon' => '🧽', 'name_bn' => 'ডিটারজেন্ট', 'name_en' => 'Detergent', 'name_bn_en' => 'detergent'],
            ['icon' => '🧼', 'name_bn' => 'সাবান', 'name_en' => 'Soap', 'name_bn_en' => 'saban'],
            ['icon' => '🪥', 'name_bn' => 'টুথপেস্ট', 'name_en' => 'Toothpaste', 'name_bn_en' => 'toothpaste'],
            ['icon' => '🪒', 'name_bn' => 'রেজর', 'name_en' => 'Razor', 'name_bn_en' => 'rejor'],
            ['icon' => '🧻', 'name_bn' => 'টিস্যু', 'name_en' => 'Tissue', 'name_bn_en' => 'tissue'],
            ['icon' => '🧴', 'name_bn' => 'শ্যাম্পু', 'name_en' => 'Shampoo', 'name_bn_en' => 'shampoo'],
            ['icon' => '🧴', 'name_bn' => 'লিকুইড সাবান', 'name_en' => 'Liquid Soap', 'name_bn_en' => 'liquid saban'],
            ['icon' => '🧹', 'name_bn' => 'ঝাড়ু', 'name_en' => 'Broom', 'name_bn_en' => 'jhadu'],
            ['icon' => '🪣', 'name_bn' => 'বালতি', 'name_en' => 'Bucket', 'name_bn_en' => 'balti'],
            ['icon' => '🧺', 'name_bn' => 'কাপড় ধোয়ার সাবান', 'name_en' => 'Laundry Soap', 'name_bn_en' => 'kapor dhowa saban'],
            ['icon' => '🪑', 'name_bn' => 'প্লাস্টিক চেয়ার', 'name_en' => 'Plastic Chair', 'name_bn_en' => 'plastic chair'],
            ['icon' => '💡', 'name_bn' => 'বাল্ব', 'name_en' => 'Bulb', 'name_bn_en' => 'bulb'],
            ['icon' => '🔌', 'name_bn' => 'মাল্টিপ্লাগ', 'name_en' => 'Multiplug', 'name_bn_en' => 'multiplug'],
            ['icon' => '🪵', 'name_bn' => 'কাঠ', 'name_en' => 'Wood', 'name_bn_en' => 'kath'],
            ['icon' => '🧯', 'name_bn' => 'মশার কয়েল', 'name_en' => 'Mosquito Coil', 'name_bn_en' => 'moshar koil'],
            ['icon' => '🪶', 'name_bn' => 'ধূপ', 'name_en' => 'Incense Stick', 'name_bn_en' => 'dhup'],
        ];

        DB::table('grocery_items')->insert($items);
    }
}
