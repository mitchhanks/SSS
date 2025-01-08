<?php

namespace Tests\Unit\Console\Commands;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class GenerateTicketTest extends TestCase
{
    use RefreshDatabase;

    public function testGenerateTicketCreatesNewTicket()
    {
        // Create a user in the database
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'name' => "test",
        ]);

        // Run the Artisan command
        $this->artisan('tickets:generate')
            ->expectsOutput('Ticket created successfully!')  // Expect the command's output
            ->assertExitCode(0);  // Assert successful execution (exit code 0)

        // Check if the ticket was created in the database
        $this->assertDatabaseHas('tickets', [
            'user_id' => $user->id, // The ID of the user that was created
            'status' => false, // Default status
        ]);
    }
}
