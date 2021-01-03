<?php

namespace App\Policies;

use App\Models\BoardUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardUserPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, BoardUser $boardUser)
    {
        return $user->id === $boardUser->board->owner->id;
    }

    /**
     * Determine whether the user can delete the model.
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
