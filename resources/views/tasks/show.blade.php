@extends('layouts.general')

@section('css')
    <link rel="stylesheet" href="{{asset('css/task_show.css')}}" />
@endsection

@section('content')
<div id="task-box">
    <div id="task-details">
        <h2>{{$task->title}}</h2>
        <p>"<i style="font-weight: bold;">{{$task->description}}"</i></p>
        <p>Date de fin : {{$task->due_date}}</p>
        @if ($task->category != null)
            <p>Catégorie : {{$task->category->name}}</p>
        @endif
        <p>Status : {{$task->state}}</p> 
        <h3>Les membres de la tache</h3>
        @if (session()->get('user_id') == $board->owner->id)
            <form action="{{route('taskuser.store', $task->id)}}" method="POST">
                @csrf
                <select name="users" id="add-user-select">
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
            @foreach ($task->assignedUsers as $user)
                @if ($user->id == session()->get('user_id'))
                    <li>{{$user->name}} (vous)</li>
                @else
                    <li>{{$user->name}} | {{$user->email}} @if(session()->get('user_id') == $board->owner->id) <a href="{{route('taskuser.destroy', [$task->id, $user->id])}}">Supprimer</a> @endif</li>
                @endif
            @endforeach
        </ul>

        @if ($assigned)
            <a class="action-btn" href="{{route('taskuser.destroy', [$task->id, session()->get('user_id')])}}">Quitter cette tache</a>
        @else
            <strong>Vous ne faites pas partie de cette tache !</strong>
        @endif

        <a  class="action-btn" href="{{route('board.show', $board->id)}}">Retour au board</a> 
    </div> <br />

    @if ($assigned || $isOwner)
        <div id="task-edit">
            <h3>Modifier cette tache</h3>
            <form action="{{route('task.update', [$board->id, $task->id])}}" method="POST">
                @csrf
                @if ($isOwner)
                    <input type="text" name="title" value="{{$task->title}}" /> <br />
                    <textarea name="desc" cols="30" rows="10">{{$task->description}}</textarea> <br />
                    <input type="date" value="{{$task->due_date}}" name="date" /> <br />
                    <select name="category">
                        @foreach ($categories as $category)
                            @if ($category->id == $task->category->id)
                                <option value="{{$category->id}}" selected>{{$category->name}}</option>
                            @else
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endif
                        @endforeach
                    </select> <br />
                    <a href="{{route('task.destroy', [$board->id, $task->id])}}">Supprimer</a> <br />
                @endif
                @if ($assigned)
                    <select name="state">
                        <option value="todo">À faire</option>
                        <option value="ongoing">En cours</option>
                        <option value="done">Terminé</option>
                    </select>
                @endif
                <input type="submit" value="Mettre à jour" />
            </form>
        </div>
    @endif
</div>
    

    @if($assigned || $isOwner)
        <div id="task-comments">
            <fieldset>
                <legend>Commentaires</legend>
                <ul>
                    @foreach ($task->comments as $comment)
                        <li>{{$comment->user->name}} : {{$comment->text}} @if ($isOwner) <a href="{{route('comment.destroy', [$comment->id])}}">Supprimer</a> @endif</li>
                    @endforeach
                </ul>
            </fieldset>
            <form action="{{route('comment.store', [$task->id])}}" method="POST">
                @csrf
                <input type="text" name="comment" /> <input type="submit" value="Envoyer" /> 
            </form>
        </div>
       
    @endif
@endsection