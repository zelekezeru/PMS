<?php

namespace App\Jobs;

use App\Mail\TaskAssigned;
use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTaskAssignedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;
    protected $user;
    protected $assigningUser;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task, User $user, User $assigningUser)
    {
        $this->task = $task;
        $this->user = $user;
        $this->assigningUser = $assigningUser;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new TaskAssigned($this->task, $this->assigningUser));
    }
}
