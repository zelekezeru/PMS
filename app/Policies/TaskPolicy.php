<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function manageTask(User $user, Task $task): bool
    {
        return $user->hasAnyRole(['SUPER_ADMIN', 'ADMIN']) || $user->id === $task->created_by;
    }
}
