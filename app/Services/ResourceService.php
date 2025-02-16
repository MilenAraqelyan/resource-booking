<?php

namespace App\Services;

use App\Exceptions\ResourceNotAvailableException;
use App\Repositories\Interfaces\ResourceRepositoryInterface;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ResourceService
{
    public function __construct(
        private readonly ResourceRepositoryInterface $resourceRepository,
        private readonly BookingRepositoryInterface $bookingRepository
    ) {
    }

    public function getAllResources(): Collection
    {
        return $this->resourceRepository->all();
    }

    public function getResource(int $id)
    {
        return $this->resourceRepository->find($id);
    }

    public function createResource(array $data)
    {
        return $this->resourceRepository->create($data);
    }

    public function updateResource(int $id, array $data)
    {
        return $this->resourceRepository->update($id, $data);
    }

    public function deleteResource(int $id): bool
    {
        return $this->resourceRepository->delete($id);
    }

    public function getResourceBookings(int $id): Collection
    {
        return $this->bookingRepository->getResourceBookings($id);
    }

    public function checkResourceAvailability(int $id, string $startTime, string $endTime): bool
    {
        $resource = $this->getResource($id);
        return $resource->isAvailable($startTime, $endTime);
    }
}
