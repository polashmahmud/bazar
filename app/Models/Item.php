<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $fillable = [
        'name',
        'category',
        'image',
        'quantity',
        'price',
        'month',
        'is_done',
        'synced_at',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price' => 'decimal:2',
        'is_done' => 'boolean',
        'synced_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForMonth($query, string $month)
    {
        return $query->where('month', $month);
    }

    public function scopeNotDone($query)
    {
        return $query->where('is_done', false);
    }

    public function scopeDone($query)
    {
        return $query->where('is_done', true);
    }
}
