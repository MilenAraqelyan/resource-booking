<?php

namespace App\Repositories;

use App\Models\Resource;
use App\Repositories\Interfaces\ResourceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ResourceRepository implements ResourceRepositoryInterface
{
    public function all(): Collection
    {
        return Resource::all();
    }

    public function find(int $id)
    {
        return Resource::findOrFail($id);
    }

    public function create(array $data)
    {
        return Resource::create($data);
    }

    public function update(int $id, array $data)
    {
        $resource = $this->find($id);
        $resource->update($data);
        return $resource;
    }

    public function delete(int $id): bool
    {
        return Resource::destroy($id) > 0;
    }
}
