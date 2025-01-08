<?php

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\ProcessTicket;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;

class ProcessTicketTest extends TestCase
{
    use RefreshDatabase;

    public function testProcessTicketProcessesUnprocessedTicket()
    {
        // Create a user in the database
        $user = User::create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
            'name' => "test",
        ]);

        // Create an unprocessed ticket
        $ticket = Ticket::create([
            'subject' => 'Test Ticket',
            'content' => 'This is a test ticket.',
            'user_id' => $user->id, // Use the dynamic user ID
            'status' => false,
        ]);

        // Run the command and assert the expected output and exit code
        $this->artisan('tickets:process')
            ->expectsOutput("Ticket {$ticket->id} processed successfully!")
            ->assertExitCode(0);  // Assert successful execution (exit code 0)

        // Refresh the ticket to get the updated status
        $ticket->refresh();

        // Assert that the ticket's status was updated to true
        $this->assertEquals(1, $ticket->status);  // Check if status is 1

    }



    public function testProcessTicketWhenNoUnprocessedTickets()
    {
        // Run the command with no tickets in the database
        Artisan::call('tickets:process');

        // Check that the output mentions no unprocessed tickets
        $this->assertStringContainsString('No unprocessed tickets found.', Artisan::output());
    }

}
