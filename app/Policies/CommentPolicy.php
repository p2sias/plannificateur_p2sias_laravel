<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
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
     * Seul un utilisateur qui fait partie de la tache ou qui est le propriétaire du board de cette tache peut voir les commentaires
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        return $comment->task->assignedUsers->find($user->id) || $comment->task->board->owner->id === $user->id;
    }

    /**
     * Seul un utilisateur qui fait partie de la tache ou qui est le propriétaire du board de cette tache peut poster commentaires
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, $comment)
    {
        return $comment->task->assignedUsers->find($user->id) || $comment->task->board->owner->id === $user->id;
    }


    /**
     * Seul le proprio du board peut supprimer des commentaires
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->task->board->owner->id;
    }


}
