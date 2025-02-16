<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{Resource, User, Booking};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ResourceControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_create_resource()
    {
        $resourceData = [
            'name' => 'Meeting Room A',
            'type' => 'room',
            'description' => 'Large meeting room'
        ];

        $response = $this->postJson('/api/resources', $resourceData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'type',
                    'description',
                    'created_at'
                ]
            ]);

        $this->assertDatabaseHas('resources', $resourceData);
    }

    public function test_can_get_all_resources()
    {
        Resource::factory()->count(3)->create();

        $response = $this->getJson('/api/resources');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_get_resource_bookings()
    {
        $resource = Resource::factory()->create();
        Booking::factory()->count(3)->create(['resource_id' => $resource->id]);

        $response = $this->getJson("/api/resources/{$resource->id}/bookings");

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }
}
