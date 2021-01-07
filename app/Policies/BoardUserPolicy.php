<?php

namespace App\Policies;

use App\Models\BoardUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardUserPolicy
{
    use HandlesAuthorization;


    /**
     * Seul le propriétaire du board peut ajouter des membres
     *
     * @param  \App\Models\User  $user
     * @param \App\Models\BoardUser $boardUser
     * @return mixed
     */
    public function create(User $user, BoardUser $boardUser)
    {
        return $user->id === $boardUser->board->owner->id;
    }

    /**
     *  Seul le propriétaire du board peut supprimer des membres
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BoardUser  $boardUser
     * @return mixed
     */
    public function delete(User $user, BoardUser $boardUser)
    {
         return $user->id === $boardUser->board->owner->id || $user->id === $boardUser->user->id;
    }

}
