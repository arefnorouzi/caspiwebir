<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TorobProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->id,
            'product_name' => $this->name,
            'product_image' => $this->thumbnail ?? $this->image,
            'product_price' => $this->active_price ?? $this->price,
            'availability' => $this->stock > 0 ? "instock" : "outofstock",
            "guarantee" => $this->guarantee,
            'url' => url("/shop/p/{$this->id}")
        ];
    }
}
