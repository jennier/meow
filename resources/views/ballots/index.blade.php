@extends('layouts.master')

@section('title', 'Ballots')

@section('content')
	
	<!-- Current Tasks -->
    @if (count($ballots) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Ballots
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
                        @foreach ($ballots as $ballot)
                    
                            <tr class="{{ $ballot->ballotRowColor() }}">
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
    
         <?php echo $ballots->render() ?>

    @else 
    <p>There are no ballots yet!</p>
    @endif
	
@endsection