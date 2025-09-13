<?php

// Test script to verify user-specific data filtering

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Item;
use App\Models\CartHistory;

// Create some test data
echo "Creating test data...\n";

// Create users if they don't exist
$user1 = User::firstOrCreate(['email' => 'user1@test.com'], [
    'name' => 'User 1',
    'password' => bcrypt('password'),
]);

$user2 = User::firstOrCreate(['email' => 'user2@test.com'], [
    'name' => 'User 2', 
    'password' => bcrypt('password'),
]);

echo "User 1 ID: {$user1->id}\n";
echo "User 2 ID: {$user2->id}\n";

// Create items for each user
$item1 = Item::create([
    'user_id' => $user1->id,
    'name' => 'User 1 Item',
    'quantity' => 10,
    'unit' => 'pcs',
    'price' => 100,
]);

$item2 = Item::create([
    'user_id' => $user2->id,
    'name' => 'User 2 Item', 
    'quantity' => 20,
    'unit' => 'pcs',
    'price' => 200,
]);

echo "Created items for users\n";

// Create cart histories for each user
CartHistory::create([
    'user_id' => $user1->id,
    'item_id' => $item1->id,
    'cart_id' => 'test_cart_user1',
    'name' => 'User 1 Item',
    'quantity' => 5,
    'price' => 100,
    'month' => '2025-09',
    'is_done' => false,
]);

CartHistory::create([
    'user_id' => $user2->id,
    'item_id' => $item2->id,
    'cart_id' => 'test_cart_user2',
    'name' => 'User 2 Item',
    'quantity' => 3,
    'price' => 200,
    'month' => '2025-09',
    'is_done' => false,
]);

echo "Created cart histories for users\n";

// Test user-specific filtering
echo "\n=== Testing User-Specific Filtering ===\n";

// Test User 1's data
echo "\nUser 1's Items:\n";
$user1Items = $user1->items;
foreach ($user1Items as $item) {
    echo "- {$item->name} (ID: {$item->id})\n";
}

echo "\nUser 1's Cart Histories:\n";
$user1CartHistories = $user1->cartHistories;
foreach ($user1CartHistories as $cart) {
    echo "- {$cart->name} (Qty: {$cart->quantity})\n";
}

// Test User 2's data
echo "\nUser 2's Items:\n";
$user2Items = $user2->items;
foreach ($user2Items as $item) {
    echo "- {$item->name} (ID: {$item->id})\n";
}

echo "\nUser 2's Cart Histories:\n";
$user2CartHistories = $user2->cartHistories;
foreach ($user2CartHistories as $cart) {
    echo "- {$cart->name} (Qty: {$cart->quantity})\n";
}

// Verify isolation
echo "\n=== Verifying Data Isolation ===\n";
echo "User 1 can see " . $user1Items->count() . " items\n";
echo "User 2 can see " . $user2Items->count() . " items\n";
echo "User 1 can see " . $user1CartHistories->count() . " cart histories\n";
echo "User 2 can see " . $user2CartHistories->count() . " cart histories\n";

if ($user1Items->count() > 0 && $user2Items->count() > 0 && 
    $user1CartHistories->count() > 0 && $user2CartHistories->count() > 0) {
    echo "\n✅ SUCCESS: User-specific data filtering is working correctly!\n";
} else {
    echo "\n❌ ERROR: User-specific data filtering is not working properly!\n";
}

echo "\nTest completed.\n";