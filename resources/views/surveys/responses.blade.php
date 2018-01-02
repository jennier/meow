@extends('layouts.master')

@section('title', 'View Survey Responses')

@section('breadcrumbs')
@endsection

@section('content')

	@if($survey)
	<h2>{{ $survey->name }}</h2>
    <p>survey was created by <a href="{{ url('members/'.$survey->user_id) }}">{{ $survey->owner->name }}</a> on <strong>{{ date('F d, Y', strtotime($survey->created_at)) }}</strong>.
    <p>This survey expires on <strong>{{ date('F d, Y', strtotime($survey->expiration)) }}</strong>.</p>
    
    @if(Entrust::hasRole('admin'))
    {!! Form::open(['method' => 'PATCH', 'route' => array('surveys.update', $survey->id), 'class' => 'form', 'id' => 'expirationForm']) !!}
    <div class="form-group">
    	@if($survey->status > 0)
        <input type="hidden" name="status" value="0">
    	<button class="btn btn-danger" type="submit">Open Survey</button>
        @else
        <input type="hidden" name="status" value="1">
        <button class="btn btn-success" type="submit">Close Survey</button>
        @endif
    </div>
    {!! Form::close() !!}
 	
       {!! Form::open(['method' => 'POST', 'route' => array('surveys.notify', $survey->id), 'class' => 'form', 'id' => 'notificationForm']) !!}
    <div class="form-group">
    	<button class="btn btn-info" type="submit">Send Reminder</button>
    </div>
     {!! Form::close() !!}
    @endif

   <h3>{!! $total = $survey->responses->groupBy('user_id')->count() !!} people have responded to this survey.</h3>
   
   @if($total > 0) 

       			
                @foreach($survey->questions as $question)
               <table class="table table-striped survey-table">
                <tr>
               	 <td colspan="2"><h4>{{ $question->question }} ({{ $question->responses->count() }} Responses)</h4></td>
                 	 @foreach($question->responses as $response)
                	<tr>
              
                        	<td>{{ $question->responseType($response->response) }}</td>
                            @if(Entrust::hasRole('admin'))
                            <td>{{ $response->user['name'] }}</td>
                            @endif
               
                    </tr>
                @endforeach
                </tr>
                </table>
                @endforeach
             
               
              
             
    @endif
   @endif

@endsection
