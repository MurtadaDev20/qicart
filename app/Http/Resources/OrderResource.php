<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
            [
                'id' => $this->id,
                'user_id' => $this->user->name,
                'shipping_address' => $this->shipping_address,
                'total_amount' => $this->total_amount,
                'orderItem' => OrderItemResource::collection($this->orderItems),
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}