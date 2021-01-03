@extends('layouts.general')

@section('css')
<link rel="stylesheet" href="{{asset('css/board_show.css')}}" />
@endsection

@section('content')
<div id="board-show">
    <div id="board-infos">
        <div id="board-details">
            <h2 id="board-title">{{$board->title}}</h2>
            <p id="board-desc">"" {{$board->description}} ""</p>
        </div>
        <div id="board-tasks">
            <p>Taches du board  
            @if (session()->get('user_id') == $board->owner->id)
                <a class="create-link" href="{{route('task.create', $board->id)}}">+</a>
            @endif
            </p>
            <ul>
                @foreach ($board->tasks as $task)
                    <li>
                        <div class="task-vignette">
                            <span class="task-title"><strong>{{$task->title}}</strong></span>
                            <span class="task-due">{{$task->due_date}}</span>
                            <span class="task-state">{{$task->state}}</span>
                            <a href="{{route('task.show', [$board->id, $task->id])}}">Voir</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div id="board-members">
            <h3>Les membres du board</h3>
            @if (session()->get('user_id') == $board->owner->id)
                <form action="{{route('boarduser.store', $board->id)}}" method="POST">
                    @csrf
                    <select name="user" id="add-user-select">
                        @foreach ($notAssigned as $user)
                            <option value="{{$user->id}}">{{$user->name}} | {{$user->email}}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Ajouter" />
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <span style="color:red;font-size:15px;">{{ $error }}</span>
                        @endforeach
                    @endif
                </form>
            @endif
            <ul>
                @foreach ($board->users as $user)
                    @if ($user->id == session()->get('user_id'))
                        <li>{{$user->name}} (vous)</li>
                    @else
                        <li>{{$user->name}} | {{$user->email}} @if(session()->get('user_id') == $board->owner->id) <a class="user-delete" href="{{route('boarduser.destroy', [$board->id, $user->id, 1])}}">Supprimer</a> @endif</li>
                    @endif
                @endforeach
            </ul>
            @if ($board->owner->id != session()->get('user_id'))
                <a href="{{route('boarduser.destroy', [$board->id, session()->get('user_id'), 0])}}">Quitter cette board</a>
            @endif
        </div>
    </div>
    
    @if (session()->get('user_id') == $board->owner->id)
        <div id="board-edit">
            <h3>Modifiez votre board !</h3>
            <form action="{{route('board.update', $board->id)}}" method="POST">
                @csrf
                <input type="text" value="{{$board->title}}" name="title" /> <br />
                <textarea name="desc" cols="30" rows="10">{{$board->description}}</textarea><br />
                <input type="submit" value="Mettre à jour" />
            </form>

            <a class="user-delete" href="{{route('board.destroy', $board->id)}}">Supprimer</a>
        </div>        
    @endif
</div>
@endsection