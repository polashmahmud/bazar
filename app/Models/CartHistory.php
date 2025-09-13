<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CartHistory extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'cart_id',
        'name',
        'image',
        'quantity',
        'quantity_unit',
        'price',
        'is_done',
        'done_at',
        'month'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price' => 'decimal:2',
        'is_done' => 'boolean',
        'done_at' => 'datetime'
    ];

    /**
     * Get the related user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related item
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Scope for specific month
     */
    public function scopeForMonth($query, $month)
    {
        return $query->where('month', $month);
    }

    /**
     * Scope for done items
     */
    public function scopeDone($query)
    {
        return $query->where('is_done', true);
    }

    /**
     * Mark as done
     */
    public function markAsDone()
    {
        $this->update([
            'is_done' => true,
            'done_at' => now()
        ]);
    }
}
