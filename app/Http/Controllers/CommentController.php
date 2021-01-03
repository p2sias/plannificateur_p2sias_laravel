<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id_task)
    {
        
        $validateData = $request->validate([
            'comment' => 'required|max:70'
        ]);

        $comment = new Comment();
        $comment->text = $validateData['comment'];
        $comment->task_id = $id_task;
        $comment->user_id = $request->session()->get('user_id');
        if($request->user()->cannot('create', $comment)) abort('403');
        $comment->save();

        $task = Task::where('id', $id_task)->first();

        return redirect()->route('task.show', [$task->board->id, $task->id]);
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $comment = Comment::where('id', $id)->first();
        if($request->user()->cannot('delete', $comment)) abort('403');
        $task = $comment->task;
        $comment->delete();
        return redirect()->route('task.show', [$task->board->id, $task->id]);
    }
}
