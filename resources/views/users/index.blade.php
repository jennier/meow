@extends('layouts.master')

@section('title', 'Member List')

@section('content')

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th colspan="2"><a href="{{ URL::route('members.create') }}" class="btn btn-primary btn-block">Create</a></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span class="label label-info">{{ $role->name }}</span>
                    @endforeach
                </td>
                 @if(Entrust::hasRole('admin'))
                <td width="80"><a class="btn btn-primary" href="{{ URL::route('members.edit', $user->id) }}">Edit</a></td>
                <td width="80">{!! Form::open(['route' => ['members.destroy', $user->id], 'method' => 'DELETE']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?");']) !!}
                    {!!  Form::close() !!}</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>

	

@endsection