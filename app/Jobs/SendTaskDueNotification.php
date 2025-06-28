<?php

namespace App\Jobs;

use App\Mail\TaskDueMail;
use App\Models\Task;
use App\Notifications\TaskDueNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendTaskDueNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taskId;  

    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    public function handle()
    {
        $task = Task::find($this->taskId);

        if ($task && $task->user) {
            $user = $task->user;
            Mail::to($user->email)->send(new TaskDueMail($task));
        }
    }
}
