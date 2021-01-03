@extends('layouts.general')

@section('content')
    <div id="home-page">
        <div id="boards">
            <div id="owned-boards">
                <h2 class="board-section-title">Boards qui vous appartiennent</h2>
                    @if (count($user->ownedBoards) > 0)
                        <div id="owned-box">
                            @foreach ($user->ownedBoards as $board)
                                <div class="home-board-vignette">
                                    <div class="board-info-box">
                                        <strong class="home board-title">{{$board->title}}</strong>
                                        <p  class="home board-desc">{{$board->description}}</p>
                                    </div>
                                    <div class="board-link-box">
                                        <a class="enter-link"  href="{{route('board.show', $board->id)}}"><span class="link-text">Entrer<span></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <strong class="no-task">Vous n'avez pas de board !</strong>
                    @endif
                
                
            </div>
            <div id="assigned-boards">
                <h2 class="board-section-title">Boards auxquelles vous participez</h2>
               
                    @if (count($user->boards) > 0)
                        <div id="assigned-box">
                            @foreach ($user->boards as $board)
                                @if ($board->owner->id != $user->id)
                                    <div class="home-board-vignette">
                                        <div class="board-info-box">
                                            <strong class="home board-title">{{$board->title}}</strong>
                                            <p  class="home board-desc">{{$board->description}}</p>
                                            <span class="home board-author">Owner: {{$board->owner->name}}</span>
                                        </div>
                                        <div class="board-link-box">
                                            <a class="enter-link"  href="{{route('board.show', $board->id)}}"><span class="link-text">Entrer<span></a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <strong class="no-task">Vous ne participez à aucun board !</strong>
                    @endif   
            </div>
        </div>

        <div id="last-tasks">
            <h2 class="board-section-title">Les dernières tâches en cours</h2>
            @if (count($user->assignedTasks) > 0)
                <ul>
                    @foreach ($user->assignedTasks as $task)
                        <li>
                            <strong><a href="{{route('task.show', [$task->board->id, $task->id])}}">{{$task->title}}</a></strong> |
                            {{$task->due_date}} | 
                            <i>{{$task->board->title}}</i>
                        </li>
                    @endforeach
                </ul>
            @else
                <strong class="no-task">Vous n'avez aucune tache en cours</strong>
            @endif
        </div>
    </div>
    
    
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
@endsection