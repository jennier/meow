@extends('layouts.master')

@section('title', 'Edit Roles')

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

    {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PATCH']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('display_name', 'Display name') !!}
        {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <label for="">Permissions</label>
        @foreach($permissions as $permission)
        <?php 
   			if($rolePermissions->contains($permission->id)) :
            	$checked = TRUE;
            else :
				$checked = FALSE;
			endif;
         ?>
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('perms[]', $permission->id,$checked) !!} {{ $permission->display_name }}
                    </label>
                </div>
        @endforeach
    </div>

    <div class="form-group">
        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
    
@endsection