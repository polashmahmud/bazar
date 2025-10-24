<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroceryList extends Model
{
    /** @use HasFactory<\Database\Factories\GroceryListFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'grocery_item_id',
        'quantity',
        'unit',
        'price',
        'total_price',
        'purchased',
        'purchase_date',
    ];
}
