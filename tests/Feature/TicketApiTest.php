<?php

namespace Tests\Feature;

use Tests\TestCase;

class TicketApiTest extends TestCase
{

    public function test_fetch_open_tickets()
    {
        $response = $this->get('/api/tickets/open');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => ['id', 'subject', 'content', 'status', 'created_at', 'updated_at']
            ]
        ]);
    }
}
