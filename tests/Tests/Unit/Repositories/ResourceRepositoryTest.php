<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\{ResourceRepository, BookingRepository};
use App\Models\{Resource, Booking};
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResourceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ResourceRepository();
    }

    public function test_can_create_resource()
    {
        $resourceData = [
            'name' => 'Test Room',
            'type' => 'room',
            'description' => 'Test Description'
        ];

        $resource = $this->repository->create($resourceData);

        $this->assertInstanceOf(Resource::class, $resource);
        $this->assertEquals($resourceData['name'], $resource->name);
    }

    public function test_can_find_resource()
    {
        $resource = Resource::factory()->create();

        $found = $this->repository->find($resource->id);

        $this->assertEquals($resource->id, $found->id);
    }
}
