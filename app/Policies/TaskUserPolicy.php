<?php

namespace App\Policies;

use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskUserPolicy
{
    use HandlesAuthorization;

    /**
     * Seul le proprio du board peut ajouter des membres à la tache
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, TaskUser $taskuser)
    {
        return $user->id === $taskuser->task->board->owner->id;
    }


    /**
     * Seul le proprio du board peut supprimer des membres à la tache
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
