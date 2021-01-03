<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Category;
use App\Models\Task;
use App\Models\TaskUser;

class TaskController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $board)
    {
        
        $board = Board::where('id', $board)->first();
        //if($request->user()->cannot('create', $board)) abort('403');
        $categories = Category::all();
        return view('tasks.create', ['board' => $board, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $board)
    {
        $validateData = $request->validate([
            'title' => 'required|max:50|string',
            'desc' => 'required|max:255|string',
            'date'=> 'required',
            'state' => 'required|in:todo,ongoing,done',
            'assignSelf' => 'required|in:true,false',
            'category' => 'integer'
        ]);

        $task = new Task();
        $task->title = $validateData['title'];
        $task->description = $validateData['desc'];
        $task->due_date = $validateData['date'];
        $task->state = $validateData['state'];
        $task->board_id = $board;
        if(isset($validateData['category'])) $task->category_id = $validateData['category'];
        $task->save();

        if($validateData['assignSelf'] == 'true')
        {
            $taskuser = new TaskUser();
            $taskuser->user_id = $request->session()->get('user_id');
            $taskuser->task_id = $task->id;
            $taskuser->save();
        }
       return redirect()->route('task.show', [$board, $task->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $board, $taskId)
    {
        $task = Task::where('id', $taskId)->first();
        if($request->user()->cannot('view', $task)) abort('403');
        $board = Board::where('id', $board)->first();
        $isAssigned = false;
        $isOwner = false;
        $assigned = [];
        foreach($task->assignedUsers as $user) array_push($assigned, $user->id);

        $notAssigned = [];
        foreach($task->participants as $user)
        {
            if(!in_array($user->id, $assigned)) array_push($notAssigned, $user);
        }

        if(in_array($request->session()->get('user_id'), $assigned)) $isAssigned = true;
        if($request->session()->get('user_id') == $board->owner->id) $isOwner = true;

        $categories = Category::all();

        return view('tasks.show', ['notAssigned' => $notAssigned,
                                   'task' => $task,
                                   'board' => $board,
                                   'assigned' => $isAssigned,
                                   'isOwner'=>$isOwner,
                                   'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $board, $task)
    {
        
        $validateData = $request->validate([
            'title' => 'max:50|string',
            'desc' => 'max:255|string',
            'date'=> 'date',
            'state' => 'in:todo,ongoing,done',
            'category' => 'integer'
        ]);

        $task = Task::where('id', $task)->first();
        if($request->user()->cannot('update', $task)) abort('403');
        if(isset($validateData['title'])) $task->title = $validateData['title'];
        if(isset($validateData['desc'])) $task->description = $validateData['desc'];
        if(isset($validateData['category'])) $task->category_id = $validateData['category'];
        if(isset($validateData['state'])) $task->state = $validateData['state'];
        if(isset($validateData['date'])) $task->due_date = $validateData['date'];
        $task->save();

       return redirect()->route('task.show', [$board, $task]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $board, $taskId)
    {
        
        $task = Task::where('id', $taskId)->first();
        if($request->user()->cannot('delete', $task)) abort('403');
        $task->delete();
        return redirect()->route('board.show', $task->board->id);
    }
}
