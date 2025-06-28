<?php

namespace App\Console\Commands;

use App\Jobs\SendTaskDueNotification;
use App\Models\Task;
use Illuminate\Console\Command;

class SendTaskDueNotifications extends Command
{
    protected $signature = 'tasks:send-due-notifications'; 
    protected $description = 'Send email notifications for tasks that are due in 24 hours';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tasks = Task::where('due_date', '=', now()->addDay()->toDateString())->get();

        if ($tasks->isEmpty()) {
            $this->info('No tasks are due tomorrow.');
        } else {
            foreach ($tasks as $task) {
                SendTaskDueNotification::dispatch($task->id)->onQueue('emails');
            }

            $this->info('Notifications sent for ' . $tasks->count() . ' tasks.');
        }
    }
}
