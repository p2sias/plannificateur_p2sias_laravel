<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    /* Relations Eloquent */

    /**
     * Renvoi la liste des boards appartenant à l'utilisateur 
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMAny
     */
    public function ownedBoards()
    {
        return $this->hasMany(Board::class);
    }

    /**
     * Renvoi la liste des boards auxquel l'utilisateur participe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function boards()
    {
        return $this->belongsToMany(Board::class)
                    ->using(BoardUser::class)
                    ->withPivot("id")
                    ->withTimestamps();
    }

    /**
     * Renvoi la liste des toutes les tâches des boards auxquel l'utilisateur participe
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function allTasks() {
        return $this->hasManyThrough(Task::class, BoardUser::class, 'user_id', 'board_id', 'id', 'board_id');
    }


    /**
     * Renvoi la liste des tâches assignées à l'utilisateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedTasks()
    {
        return $this->belongsToMany('App\Models\Task')
                    ->using("App\Models\TaskUser")
                    ->withPivot("id")
                    ->withTimestamps();
    }


    /**
     * Renvoi la liste des commentaires rédigés par l'utilisateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Renvoi la liste des pièces jointes posées par l'utilisateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany('App\Models\Attachment');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
