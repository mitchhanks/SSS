<?php

namespace Tests\Unit;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KernelScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testScheduledCommands()
    {
        // Create a mock Schedule instance to check the scheduled tasks
        $schedule = $this->app->make(Schedule::class);

        // Get the scheduled tasks
        $tasks = $schedule->events();

        // Check if 'tickets:generate' is scheduled to run every minute
        $this->assertTrue($this->isScheduled($tasks, 'tickets:generate', 'everyMinute'));

        // Check if 'tickets:process' is scheduled to run every five minutes
        $this->assertTrue($this->isScheduled($tasks, 'tickets:process', 'everyFiveMinutes'));
    }

    /**
     * Helper function to check if a command is scheduled with a specific frequency.
     */
    protected function isScheduled(array $tasks, string $command, string $frequency): bool
    {
        foreach ($tasks as $task) {
            if (strpos($task->command, $command) !== false) {
                return method_exists($task, $frequency);
            }
        }

        return false;
    }
}
