@extends('layouts.general')

@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('css/forms.css')}}" />
@endsection
@section('content')
    <h1>Bonjour ! Veuillez vous connecter</h1>
    <div id="form-box">
        <form action="{{route('login.login')}}" method="POST">
            @csrf
            <input type="email" name="email" id="email" placeholder="Adresse email" /><br>
    
            <input type="password" name="password" id="pass" placeholder="Mot de passe" /><br>

            <a href="{{route('register.show')}}" style="text-decoration:none;volor:black;font-weight:bold;">Inscription</a>
    
            <input type="submit" id="sendBtn" value="envoyer" />
        </form>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    </div>
@endsection