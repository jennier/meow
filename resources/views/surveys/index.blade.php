@extends('layouts.master')

@section('title', 'Surveys')

@section('content')
	
	<!-- Current Tasks -->
    @if (count($surveys) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Active Surveys
            </div>

            <div class="panel-body">
                <table class="table table-striped survey-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Survey Name</th>
                        <th>Created On</th>
                        <th>Created By</th>
                        <th>Expires</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($surveys as $survey)
                    
                            <tr>
                                <td class="table-text">
                                    <div>
                                    	<a href="{{ url('surveys/'.$survey->id) }}">{{ $survey->name }}</a>
                                      @if($survey->status == 1)
                                      <span class="label label-default">
                                    	<a href="{{ url('surveys/'.$survey->id.'/responses') }}">View Responses</a>
                                      </span>
                                    @endif
                                    </div>
                                </td>
                                <td>
                                    <div>{{ date('F d, Y', strtotime($survey->created_at)) }}</div>
                                </td>
                                <td>
                                    <div><a href="{{ route('members.show', ['member' => $survey->owner->name]) }}">{{ $survey->owner->name }}</a></div>
                                </td>
                                <td>
                                    <div>{{ date('F d, Y', strtotime($survey->expiration)) }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    @else 
    <p>There are no surveys yet!</p>
    @endif
	
@endsection