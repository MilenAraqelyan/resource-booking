<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\{BookingService, ResourceService};
use App\Repositories\{BookingRepository, ResourceRepository};
use App\Models\{Resource, Booking, User};
use App\Exceptions\{ResourceNotAvailableException, BookingValidationException};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class ResourceServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $resourceService;
    protected $resourceRepository;
    protected $bookingRepository;


    protected function setUp(): void
    {
        parent::setUp();
        $this->resourceRepository = Mockery::mock(ResourceRepository::class);
        $this->bookingRepository = Mockery::mock(BookingRepository::class);

        $this->resourceService = new ResourceService($this->resourceRepository, $this->bookingRepository);
    }

    public function test_can_get_all_resources()
    {
        $resources = Resource::factory()->count(3)->make();

        $this->resourceRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($resources);

        $result = $this->resourceService->getAllResources();

        $this->assertCount(3, $result);
    }

    public function test_can_check_resource_availability()
    {
        $resource = Resource::factory()->create();
        $startTime = now()->addHour();
        $endTime = now()->addHours(2);

        $this->resourceRepository
            ->shouldReceive('find')
            ->with($resource->id)
            ->andReturn($resource);

        $isAvailable = $this->resourceService->checkResourceAvailability(
            $resource->id,
            $startTime,
            $endTime
        );

        $this->assertTrue($isAvailable);
    }
}
