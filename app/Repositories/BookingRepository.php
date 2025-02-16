<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BookingRepository implements BookingRepositoryInterface
{
    public function all(): Collection
    {
        return Booking::with(['resource', 'user'])->get();
    }

    public function find(int $id)
    {
        return Booking::with(['resource', 'user'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Booking::create($data);
    }

    public function delete(int $id): bool
    {
        return Booking::destroy($id) > 0;
    }

    public function getResourceBookings(int $resourceId): Collection
    {
        return Booking::where('resource_id', $resourceId)
            ->with(['user'])
            ->orderBy('start_time')
            ->get();
    }

    public function getOverlappingBookings(int $resourceId, string $startTime, string $endTime): Collection
    {
        return Booking::where('resource_id', $resourceId)
            ->where('status', 'active')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->get();
    }
}
