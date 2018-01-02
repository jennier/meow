<!-- resources/views/auth/register.blade.php -->
@extends('layouts.master')

@section('title', 'Register')

@section('content')
<form method="POST" action="/auth/register">
    {!! csrf_field() !!}

    <div>
        Name
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Password
        <input type="password" name="password" value="catscatscats">
    </div>

    <div>
        Confirm Password
        <input type="password" name="password_confirmation" value="catscatscats">
    </div>

    <div>
        <button type="submit">Register</button>
    </div>
</form>
@endsection