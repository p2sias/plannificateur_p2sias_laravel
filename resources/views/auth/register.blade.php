@extends('layouts.general')

@section('content')

    <form action="{{route('register.create')}}" method="POST">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" id="name" /><br>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" /><br>

        <label for="pass">Pass</label>
        <input type="password" name="password" id="pass" /><br>

        <label for="pass-conf">Pass conf</label>
        <input type="password" name="password-confirmation" id="pass-conf" /><br>

        <input type="submit" value="envoyer" />
    </form>

@endsection