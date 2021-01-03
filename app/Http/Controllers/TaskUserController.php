<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskUser;

class TaskUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $task)
    {
        $validateData = $request->validate([
            'users' => 'required|integer'
        ]);

        $taskuser = new TaskUser();
        $taskuser->task_id = $task;
        $taskuser->user_id = $validateData['users'];
        if($request->user()->cannot('create', $taskuser)) abort('403');
        $taskuser->save();

        $board = $taskuser->task->board->id;

        return redirect()->route('task.show', [$board, $task]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $task, $user)
    {
        $taskuser = TaskUser::where('user_id', $user)->where('task_id', $task)->first();
        $board = $taskuser->task->board->id;
        if($request->user()->cannot('delete', $taskuser)) abort('403');
        $taskuser->delete();
        return redirect()->route('task.show', [$board, $task]);
    }
}
