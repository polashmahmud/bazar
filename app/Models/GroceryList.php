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
        'purchased',
        'purchase_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(GroceryItem::class, 'grocery_item_id');
    }
}
