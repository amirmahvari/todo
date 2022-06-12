<?php
namespace App\Policies;

use App\Task;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given post can be updated by the user.
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function update(User $user , Task $task)
    {
        return $user->id === $task->user_id;
    }

    /**
     * Determine if the given post can be updated by the user.
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function delete(User $user , Task $task)
    {
        return $user->id === $task->user_id;
    }
}
