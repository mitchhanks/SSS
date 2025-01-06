<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Console\Command;
use Faker\Factory as Faker;

class GenerateTicket extends Command
{
    // The name and signature of the console command.
    protected $signature = 'tickets:generate';

    // The console command description.
    protected $description = 'Generate a new ticket every minute with dummy data';

    // Execute the console command.
    public function handle()
    {
        $faker = Faker::create();

        // Find or create a user (or pick a random one)
        $user = User::inRandomOrder()->first();

        // Create the ticket with dummy data
        Ticket::create([
            'subject' => $faker->sentence(),
            'content' => $faker->paragraph(),
            'user_id' => $user->id,
            'status' => false, // Default status: unprocessed
        ]);

        $this->info('Ticket created successfully!');
    }
}
