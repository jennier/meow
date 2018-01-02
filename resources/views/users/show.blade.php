@extends('layouts.master')

@section('title') 
View member: {{ $user->name }}
@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
   @if($user)
   <h3>This user is currently a: {{ $class }}</h3>
   <ul>
   	@foreach($user->roles as $role)
    	<li>{{ $role->display_name }}</li>
    @endforeach
    </ul>
    
   <p>This member's account was created on {{ date('F jS, Y', strtotime($user->created_at)) }}.</p>
     
   @else
   	<p>Oh shit we can't find that person.</p>
   @endif 
	
   
@endsection