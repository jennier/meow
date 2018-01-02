@extends('layouts.master')

@section('title', 'Create a User')

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
	
    {!! Form::open(['route' => 'members.store', 'id' => 'userForm']) !!}

    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>
    
        <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Password') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password_confirmation', 'Password confirmation') !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <label for="">Roles</label>
        @foreach($roles as $role)
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('role[]', $role->id) !!} {{ $role->display_name }}
                </label>
            </div>
        @endforeach
    </div>

    <div class="form-group">
        {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@endsection

@section('jquery')
<script>
$(document).ready(function() {
    // The maximum number of options
    var MAX_OPTIONS = 5;

    $('#userForm').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
		 		name: {
					validators: {
						notEmpty: {
							message: 'A name is is required'
						},
						stringLength: {
							min: 6,
							max: 30,
							message: 'The username must be more than 6 and less than 30 characters long'
						},
						regexp: {
							regexp: /^[a-zA-Z0-9_\.]+$/,
							message: 'The username can only consist of alphabetical, number, dot and underscore'
						}
					}
				},
				email: {
					validators: {
						notEmpty: {
							message: 'The email address is required'
						},
						emailAddress: {
							message: 'The input is not a valid email address'
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: 'The password is required'
						},
						different: {
							field: 'name',
							message: 'The password cannot be the same as username'
						}
					}
				},
				password_confirmation: {
					validators: {
						notEmpty: {
							message: 'Please confirm the password'
						},
						identical: {
							field: 'password',
							message: 'The passwords must match'
						}
					}
				},
				role: {
					validators: {
						notEmpty: {
							message: 'Please select at least one user role'
						}
					}
				}
            }
        })

});
</script>
@endsection