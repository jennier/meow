@extends('layouts.master')

@section('title', 'Edit Member')

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

    {!! Form::model($user, ['route' => ['members.update', $user->id], 'method' => 'PATCH']) !!}

    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('password', 'New password') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password_confirmation', 'New password confirmation') !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
    </div>
   
	@role('admin')
    <div class="form-group">
        Roles
        @foreach($roles as $role)
                <div class="checkbox">
                    <label>
                    @if($user->hasRole($role->name))
                        {!! Form::checkbox('role[]', $role->id,true) !!} {{ $role->display_name }}
                    @else  
                        {!! Form::checkbox('role[]', $role->id) !!} {{ $role->display_name }}
                    @endif
                    </label>
                </div>
        @endforeach
    </div>
	@endrole
     
    <div class="form-group">
        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@stop