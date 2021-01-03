@extends('layouts.general')

@section('css')
    <link rel="stylesheet" href="{{asset('css/task_create.css')}}" />
@endsection

@section('content')
    <h2>Ajout d'une tache à <i style="text-decoration: underline;">{{$board->title}}</i></h2>
    <div id="task-create">
        <form action="{{route('task.store', $board->id)}}" method="POST">
            @csrf
            <input type="text" name="title" placeholder="Titre" /> <br />
            <textarea name="desc"  cols="30" rows="10" placeholder="Description"></textarea> <br />
            <input type="date" name="date" /> <br />
            <select name="state">
                <option value="todo">À faire</option>
                <option value="ongoing">En cours</option>
                <option value="done">Terminé</option>
            </select> <br />
            <select name="category">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select> <br />
            <p>Voulez vous participer à cette tache ?</p>
            <div id="labels">
                <div><label for="yes">Oui</label><input id="yes" type="radio" name="assignSelf" value="true" /><br/></div>
                <div><label for="no">Non</label><input id="no" type="radio" name="assignSelf" value="false" /></div>
            </div>
            <input type="submit" value="Créer" />
        </form>

        @if ($errors->any())
            <div class="alert alert-danger" style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

   
@endsection