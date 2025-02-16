<?php

namespace Tests\Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\{ResourceRepository, BookingRepository};
use App\Models\{Resource, Booking};
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new BookingRepository();
    }

    public function test_can_create_booking()
    {
        $resource = Resource::factory()->create();
        $bookingData = [
            'resource_id' => $resource->id,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2)
        ];

        $booking = $this->repository->create($bookingData);

        $this->assertInstanceOf(Booking::class, $booking);
        $this->assertEquals($bookingData['resource_id'], $booking->resource_id);
    }

    public function test_can_get_resource_bookings()
    {
        $resource = Resource::factory()->create();
        Booking::factory()->count(3)->create(['resource_id' => $resource->id]);

        $bookings = $this->repository->getResourceBookings($resource->id);

        $this->assertCount(3, $bookings);
        $this->assertTrue($bookings->every(fn($booking) => $booking->resource_id === $resource->id));
    }
}
