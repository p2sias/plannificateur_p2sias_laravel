<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use App\Models\User;

class BoardController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        return view('boards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|max:50',
            'desc' => 'required|max:255'
        ]);

        $board = new Board();
        $board->title = $validateData['title'];
        $board->description = $validateData['desc'];
        $board->user_id = $request->session()->get('user_id');
        $board->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $board = Board::where('id', $id)->first();
        if($request->user()->cannot('view', $board)) abort('403');
        $assigned = [];
        foreach($board->users as $user) array_push($assigned, $user->email);

        $users = User::all();
        $notAssigned = [];
        foreach($users as $user)
        {
            if(!in_array($user->email, $assigned)) array_push($notAssigned, $user);
        }

        return view('boards.show', ['board' => $board, 'notAssigned' => $notAssigned]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $board)
    {
        
        $validateData = $request->validate([
            'title' => 'required|max:50',
            'desc' => 'required|max:255'
        ]);

        $board = Board::where('id', $board)->first();
        if($request->user()->cannot('update', $board)) abort('403');
        $board->title = $validateData['title'];
        $board->description = $validateData['desc'];
        $board->save();

        return redirect()->route('board.show', $board);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $board = Board::where('id', $id)->first();
        if($request->user()->cannot('delete', $board)) abort('403');
        $board->delete();
        
        return redirect('/');
    }
}
