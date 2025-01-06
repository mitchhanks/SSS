<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Returns paginated list of unprocessed tickets
    public function getOpenTickets()
    {
        $tickets = Ticket::where('status', false)
                         ->with('user') // Include user information
                         ->paginate(3);  // Adjust pagination as needed

        return response()->json($tickets);
    }

    // Returns paginated list of processed tickets
    public function getClosedTickets()
    {
        $tickets = Ticket::where('status', true)
                         ->with('user') // Include user information
                         ->paginate(3);

        return response()->json($tickets);
    }

    // Returns paginated list of tickets for a specific user
    public function getUserTickets($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $tickets = $user->tickets()->paginate(3);  // Assuming a User has many Tickets

        return response()->json($tickets);
    }

    // Returns statistics about the tickets
    public function getStats()
    {
        $totalTickets = Ticket::count();
        $unprocessedTickets = Ticket::where('status', false)->count();
        $topUser = User::withCount('tickets')->orderBy('tickets_count', 'desc')->first();
        $lastProcessed = Ticket::where('status', true)->latest()->first();

        return response()->json([
            'total_tickets' => $totalTickets,
            'unprocessed_tickets' => $unprocessedTickets,
            'top_user' => $topUser ? $topUser->email : null,
            'last_processed' => $lastProcessed ? $lastProcessed->updated_at : null,
        ]);
    }
}
