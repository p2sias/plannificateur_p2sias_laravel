@extends('layouts.general')

@section('css')
    <link rel="stylesheet" href="{{asset('css/board_create.css')}}" />
@endsection

@section('content')
    <h2 id="board_create-title">Créez votre board !</h2>
    <div id="board-create">
        <form action="{{route('board.store')}}" method="POST">
            @csrf
            <input class="in" type="text" name="title" placeholder="Titre"/>
            <textarea class="in" name="desc" id="" cols="30" rows="10" placeholder="Description"></textarea>
            <input class="submit" type="submit" value="Créer" />
        </form>
    </div>
@endsection