<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\{Task, User};
class TaskUser extends Pivot
{
    use HasFactory; 

    public $incrementing = true;

    /**
     * Renvoi l'utilisateur lié à la tâche
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Renvoi la tâche liée à l'utilisateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

   
}
