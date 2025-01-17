<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Console\Command;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;


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
        if (!$user) {
            $this->error('No users found in the database.');
            return;
        }


        // Create the ticket with dummy data
        Ticket::create([
            'subject' => $faker->sentence(),
            'content' => $faker->paragraph(),
            'user_id' => $user->id,
            'status' => false, // Default status: unprocessed
        ]);

        Log::info('Success'); // Log the output for debugging
        $this->info('Ticket created successfully!');
    }
}
