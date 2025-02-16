<?php

namespace Feature;

use App\Models\Booking;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->resource = Resource::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_create_booking()
    {
        $bookingData = [
            'resource_id' => $this->resource->id,
            'user_id' => $this->user->id,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2)
        ];

        $response = $this->postJson('/api/bookings', $bookingData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'resource_id',
                    'user_id',
                    'start_time',
                    'end_time',
                    'status'
                ]
            ]);
    }

    public function test_cannot_create_overlapping_booking()
    {
        $existingBooking = Booking::factory()->create([
            'resource_id' => $this->resource->id,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2)
        ]);

        $bookingData = [
            'resource_id' => $this->resource->id,
            'user_id' => $this->user->id,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2)
        ];

        $response = $this->postJson('/api/bookings', $bookingData);

        $response->assertStatus(422);
    }

    public function test_can_cancel_booking()
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->deleteJson("/api/bookings/{$booking->id}");

        $response->assertStatus(200);
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled'
        ]);
    }
}
