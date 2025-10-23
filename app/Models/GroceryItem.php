<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Scope a query to search grocery items.
     *
     * @param Builder $query
     * @param string|null $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name_bn', 'like', "%{$search}%")
              ->orWhere('name_bn_en', 'like', "%{$search}%")
              ->orWhere('name_en', 'like', "%{$search}%");
        });
    }
}
