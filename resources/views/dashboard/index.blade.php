@extends('layouts.master')

@section('title')
Welcome to Meow, {{ Auth::user()->name }}!
@endsection


@section('content')

<!--
 <ul>
<li>Active/supported ballots</li>
<li>Recently closed ballots</li>
<li>Your recent activity (which ballots you've voted on etc.)</li>
<li>Updates from HR</li>
<li>Meeting minutes/next scheduled meeting</li>
</ul>
-->

<div class="row">
<div class="panel panel-default">
            <div class="panel-heading">
                <h4>Active &amp; Pending Ballots</h4>
            </div>
           
            <div class="panel-body">
             @if(count($ballots) > 0)
                <table class="table table-striped ballot-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Ballot Name</th>
                        <th>Created On</th>
                        <th>Created By</th>
                        <th>Expires</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                  
                        @foreach ($ballots as $ballot)
                            <tr>
                                <td class="table-text">
                                    <div><a href="{{ url('ballots/'.$ballot->id) }}">{{ $ballot->name }}</a></div>
                                </td>
                                <td>
                                    <div>{{ date('F d, Y', strtotime($ballot->created_at)) }}</div>
                                </td>
                                <td>
                                    <div><a href="{{ route('members.show', ['member' => $ballot->owner->name]) }}">{{ $ballot->owner->name }}</a></div>
                                </td>
                                <td>
                                    <div>{{ date('F d, Y', strtotime($ballot->expiration)) }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h4>There are no active ballots right meow.</h4>
                @endif
            </div>
        </div>
 
 <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Closed Ballots</h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped ballot-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Ballot Name</th>
                        <th>Created On</th>
                        <th>Created By</th>
                        <th>Expires</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($ended as $ballot)
                            <tr>
                                <td class="table-text">
                                    <div><a href="{{ url('ballots/'.$ballot->id) }}">{{ $ballot->name }}</a></div>
                                </td>
                                <td>
                                    <div>{{ date('F d, Y', strtotime($ballot->created_at)) }}</div>
                                </td>
                                <td>
                                    <div><a href="{{ route('members.show', ['member' => $ballot->owner->name]) }}">{{ $ballot->owner->name }}</a></div>
                                </td>
                                <td>
                                    <div>{{ date('F d, Y', strtotime($ballot->expiration)) }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection 
