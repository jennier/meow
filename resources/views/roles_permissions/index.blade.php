@extends('layouts.master')

@section('title', 'Roles &amp; Permissions')

@section('content')
    {!! Form::open(['url' => '/role_permission']) !!}
    <table class="table table-striped">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Route</th>
            @foreach($roles as $role)
                <th class="text-center">{{ $role->display_name }}</th>
            @endforeach
        </tr>
        <tr>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th colspan="{{ count($roles) }}">&nbsp;</th>
        </tr>
        </thead>
        <tbody>

        @foreach($permissions as $permission)
            <tr>
                <td width="150">{{ $permission->display_name }}</td>
                <td><small class="label label-info">{{ $permission->route }}</small></td>
                @foreach ($roles as $role)
                    <td width="150" class="text-center">
                   
                    @if($role->hasPermission($permission->name) && $role->name == 'admin')
                            <input type="checkbox" checked="checked" name="roles[{{ $role->id}}][permissions][]" value="{{ $permission->id }}" disabled="disabled">
                            <input type="hidden" name="roles[{{ $role->id}}][permissions][]" value="{{ $permission->id }}">
                        @elseif($role->hasPermission($permission->name))
                            <input type="checkbox" checked="checked" name="roles[{{ $role->id}}][permissions][]" value="{{ $permission->id }}">
                        @else
                            <input type="checkbox" name="roles[{{ $role->id }}][permissions][]" value="{{ $permission->id }}">
                        @endif
                    
                     
                    </td>
                @endforeach
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

@stop