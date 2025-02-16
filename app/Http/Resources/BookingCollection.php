<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total_bookings' => $this->collection->count(),
                'active_bookings' => $this->collection->where('status', 'active')->count(),
                'cancelled_bookings' => $this->collection->where('status', 'cancelled')->count()
            ]
        ];
    }
}
