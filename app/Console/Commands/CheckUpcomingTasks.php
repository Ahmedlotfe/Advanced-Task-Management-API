<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class CheckUpcomingTasks extends Command
{
    protected $signature = 'app:check-upcoming-tasks';
    protected $description = 'Check and display upcoming tasks within the next 24 hours';

    public function handle()
    {
        $now = now();
        $nextDay = now()->addDay();

        $tasks = Task::whereBetween('due_date', [$now, $nextDay])->get();

        if ($tasks->isEmpty()) {
            $this->info('No upcoming tasks in the next 24 hours.');
        } else {
            $this->info('Upcoming tasks in the next 24 hours:');
            foreach ($tasks as $task) {
                $this->line("- Task #{$task->id}: {$task->title} (Due: {$task->due_date})");
            }
        }
    }
}