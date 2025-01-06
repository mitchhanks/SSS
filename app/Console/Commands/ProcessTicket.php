<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\User;

class ProcessTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes tickets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find the next unprocessed ticket
        $ticket = Ticket::where('status', false)->oldest()->first();

        if ($ticket) {
            // Update the ticket's status to true (processed)
            $ticket->update([
                'status' => true,
            ]);

            $this->info("Ticket {$ticket->id} processed successfully!");
        } else {
            $this->info('No unprocessed tickets found.');
        }
    }
}
