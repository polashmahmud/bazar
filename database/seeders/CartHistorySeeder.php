<?php

namespace Database\Seeders;

use App\Models\CartHistory;
use App\Models\Item;
use Illuminate\Database\Seeder;

class CartHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get current month
        $currentMonth = now()->format('Y-m');
        
        // Create some test items first if none exist
        $items = Item::all();
        if ($items->isEmpty()) {
            $items = collect([
                Item::create([
                    'name' => 'Apple',
                    'image' => null,
                    'quantity' => 1,
                    'quantity_unit' => 'কেজি',
                    'price' => 0,
                    'month' => $currentMonth,
                ]),
                Item::create([
                    'name' => 'Banana', 
                    'image' => null,
                    'quantity' => 1,
                    'quantity_unit' => 'ডজন',
                    'price' => 0,
                    'month' => $currentMonth,
                ]),
                Item::create([
                    'name' => 'Rice',
                    'image' => null,
                    'quantity' => 1,
                    'quantity_unit' => 'কেজি',
                    'price' => 0,
                    'month' => $currentMonth,
                ])
            ]);
        }
        
        // Create some done cart history entries
        foreach ($items->take(3) as $index => $item) {
            CartHistory::create([
                'item_id' => $item->id,
                'cart_id' => 'test_cart_' . ($index + 1),
                'name' => $item->name,
                'image' => $item->image,
                'quantity' => rand(1, 3),
                'quantity_unit' => $item->quantity_unit,
                'price' => rand(50, 200), // Random price between 50-200
                'month' => $currentMonth,
                'is_done' => true,
                'done_at' => now()->subHours(rand(1, 24))
            ]);
        }
        
        // Create some active cart entries (not done)
        foreach ($items->take(2) as $index => $item) {
            CartHistory::create([
                'item_id' => $item->id,
                'cart_id' => 'active_cart_' . ($index + 1),
                'name' => $item->name,
                'image' => $item->image,
                'quantity' => 1,
                'quantity_unit' => $item->quantity_unit,
                'price' => 0,
                'month' => $currentMonth,
                'is_done' => false,
                'done_at' => null
            ]);
        }
    }
}
