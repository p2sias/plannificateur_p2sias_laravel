<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return Auth::user()->id === $user->id;
    }

    /**
     * Seuls ceux qui participe au board peuvent voir une tache
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function view(User $user, Task $task)
    {
        return $task->board->users->find($user->id);
    }

    /**
     * Un utilisateur peut créer une tache seulement si il participe au board
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Board $board)
    {
        return $board->users->find($user->id);
    }

    /**
     * Un utilisateur proprio du board ou qui participe a la tache peuvent mettre à jour la tache
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        return $task->assignedUsers->find($user->id) || $user->id === $task->board->owner->id;
    }

    /**
     * Seul le proprio du board peut suprimer la tache
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        return $user->id === $task->board->owner->id;
    }
}
