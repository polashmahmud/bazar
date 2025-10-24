<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroceryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'grocery_item_id' => $this->grocery_item_id,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'price' => $this->price,
            'total_price' => $this->total_price,
            'purchased' => $this->purchased,
            'item' => GroceryItemResource::make($this->whenLoaded('item')),
        ];
    }
}
