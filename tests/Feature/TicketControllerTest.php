<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_open_tickets()
    {
        // Arrange: Create some open and closed tickets
        Ticket::factory()->create(['status' => 0]); // Open ticket
        Ticket::factory()->create(['status' => 1]); // Closed ticket

        // Act: Call the /tickets/open route
        $response = $this->getJson('/api/tickets/open');

        // Assert: Ensure only open tickets are returned
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 1 open ticket
        $this->assertEquals(0, $response->json('data')[0]['status']);
    }

    public function test_get_closed_tickets()
    {
        // Arrange: Create some open and closed tickets
        Ticket::factory()->create(['status' => 0]); // Open ticket
        Ticket::factory()->create(['status' => 1]); // Closed ticket

        // Act: Call the /tickets/closed route
        $response = $this->getJson('/api/tickets/closed');

        // Assert: Ensure only closed tickets are returned
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 1 closed ticket
        $this->assertEquals(1, $response->json('data')[0]['status']);
    }

    public function test_get_user_tickets()
    {
        // Arrange: Create a user and tickets
        $user = User::factory()->create(['email' => 'test@example.com']);
        Ticket::factory()->create(['user_id' => $user->id, 'status' => 0]); // User's ticket
        Ticket::factory()->create(); // Another user's ticket

        // Act: Call the /users/{email}/tickets route
        $response = $this->getJson("/api/users/{$user->email}/tickets");

        // Assert: Ensure only the user's tickets are returned
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 1 ticket for the user
        $this->assertEquals($user->id, $response->json('data')[0]['user_id']);
    }

    public function test_get_stats()
    {
        // Arrange: Create tickets and users
        $user = User::factory()->create();
        Ticket::factory()->count(3)->create(['user_id' => $user->id, 'status' => 0]); // Open tickets
        Ticket::factory()->create(['user_id' => $user->id, 'status' => 1]); // Closed ticket

        // Act: Call the /stats route
        $response = $this->getJson('/api/stats');

        // Assert: Check stats are correctly calculated
        $response->assertStatus(200);
        $response->assertJson([
            'total_tickets' => 4,
            'unprocessed_tickets' => 3,
            'top_user' => $user->email,
        ]);
    }


}
