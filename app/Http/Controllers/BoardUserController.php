<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoardUser;
use App\Models\TaskUser;

class BoardUserController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $board)
    {
        $validateData = $request->validate([
            'user' => 'required|integer'
        ]);

        $boarduser = new BoardUser();
        $boarduser->board_id = $board;
        $boarduser->user_id =$validateData['user'];
        if($request->user()->cannot('create', $boarduser)) abort('403');
        $boarduser->save();

        return redirect()->route('board.show', $board);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $board, $user, $type)
    {
        $boarduser = BoardUser::where('user_id', $user)->where('board_id', $board)->first();
        if($request->user()->cannot('delete', $boarduser)) abort('403');
        $boarduser->delete();
        $taskuser = TaskUser::all();
        foreach($taskuser as $link)
        {
            if($link->task->board->id == $board && $link->user->id == $user) $link->delete();
        }
        if($type == 1) return redirect()->route('board.show', $board);
        else return redirect('/');
        
    }
}
