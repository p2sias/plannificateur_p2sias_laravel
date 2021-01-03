<?php

namespace App\Policies;

use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, TaskUser $taskuser)
    {
        return $user->id === $taskuser->task->board->owner->id;
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TaskUser  $taskUser
     * @return mixed
     */
    public function delete(User $user, TaskUser $taskuser)
    {
        return $user->id === $taskuser->task->board->owner->id || $user->id === $taskuser->user->id;
    }

}
