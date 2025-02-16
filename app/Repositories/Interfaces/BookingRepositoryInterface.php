<?php

namespace App\Repositories\Interfaces;

interface BookingRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function delete(int $id);
    public function getResourceBookings(int $resourceId);
}
