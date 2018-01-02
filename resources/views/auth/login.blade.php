<!-- resources/views/auth/login.blade.php -->

@extends('layouts.master')

@section('title', 'Login to MEOW')

@section('content')
<div class="row">
	<div class="col-md-4 col-xs-12 center-block">
        <form method="POST" action="/auth/login">
            {!! csrf_field() !!}
        	<div class="form-group">
                <label for="email" class="sr-only">Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email address">
        	</div>
            <div class="form-group">
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        	</div>
             <div class="checkbox">
                  <label>
                    <input type="checkbox" value="remember"> Remember Me
                  </label>
             </div>
        
             <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
            <p class="help-block">Forgot your password? <a href="{{ url('password/email') }}">Reset it</a>.</p>
        </form>
    </div>
</div>
@endsection