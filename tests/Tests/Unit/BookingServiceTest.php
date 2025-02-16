<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\{BookingService, ResourceService};
use App\Repositories\{BookingRepository, ResourceRepository};
use App\Models\{Resource, Booking, User};
use App\Exceptions\{ResourceNotAvailableException, BookingValidationException};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $bookingService;
    protected $bookingRepository;
    protected $resourceService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookingRepository = Mockery::mock(BookingRepository::class);
        $this->resourceService = Mockery::mock(ResourceService::class);
        $this->bookingService = new BookingService(
            $this->bookingRepository,
            $this->resourceService
        );
    }

    public function test_creates_valid_booking()
    {
        $resource = Resource::factory()->create();
        $user = User::factory()->create();

        $bookingData = [
            'resource_id' => $resource->id,
            'user_id' => $user->id,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2)
        ];

        $this->resourceService
            ->shouldReceive('checkResourceAvailability')
            ->once()
            ->andReturn(true);

        $this->bookingRepository
            ->shouldReceive('create')
            ->once()
            ->with($bookingData)
            ->andReturn(new Booking($bookingData));

        $booking = $this->bookingService->createBooking($bookingData);

        $this->assertInstanceOf(Booking::class, $booking);
    }

    public function test_throws_exception_for_unavailable_resource()
    {
        $this->expectException(ResourceNotAvailableException::class);

        $bookingData = [
            'resource_id' => 1,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2)
        ];

        $this->resourceService
            ->shouldReceive('checkResourceAvailability')
            ->once()
            ->andReturn(false);

        $this->bookingService->createBooking($bookingData);
    }
}
