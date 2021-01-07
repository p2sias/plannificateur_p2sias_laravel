<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class BoardPolicy
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
        return session()->get('user_id') === $user->id;
    }

    /**
     * Un utilisateur peut voir une board seulement si il y participe ou en est le propriétaire
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Board  $board
     * @return mixed
     */
    public function view(User $user, Board $board)
    {
        return $user->id === $board->owner->id ||   $board->users->find($user->id);
    }

    /**
     * Un utilisateur peut mettre à jour SES boards
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Board  $board
     * @return mixed
     */
    public function update(User $user, Board $board)
    {
        return $user->id == $board->owner->id;
    }

    /**
     * Un utilisateur peut supprimer SES boards
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Board  $board
     * @return mixed
     */
    public function delete(User $user, Board $board)
    {
        return $user->id == $board->owner->id;
    }
}
