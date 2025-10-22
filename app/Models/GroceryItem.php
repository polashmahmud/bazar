<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroceryItem extends Model
{
    /** @use HasFactory<\Database\Factories\GroceryItemFactory> */
    use HasFactory;

    protected $fillable = [
        'icon',
        'name_bn',
        'name_bn_en',
        'name_en',
    ];
}
