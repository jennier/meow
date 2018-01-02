@extends('layouts.master')

@section('title', 'View Survey')

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
    
    	<div class="jumbotron">
        	<p>{!! nl2br(e($survey->description)) !!}</p>  
        </div>
    
    @if($survey->status == 2)
   		<h4>The response period for this survey has ended.</h4>
    @elseif($survey->checkUserResponse(Auth::user()->id))
    	<h4>You've already responded on this survey.</h4>
    @elseif(Entrust::hasRole('inactive'))
    	<h4>You are not currently eligible to respond on this survey.</h4>
    @else 
  		{!! Form::open(['method' => 'POST', 'route' => array('surveys.response.store', $survey->id), 'class' => 'form', 'id' => 'responseForm']) !!}
        
        <!-- Start the groups -->
        @foreach($survey->groups as $group)
        	<h3>{{ $group->name }}</h3>
      
            <!-- Start the questions -->
            @foreach($group->questions as $question)
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">{{ $question->question }}</h3>
              </div>
              
              <!--Select an appripriate response format for each question type -->
              <div class="panel-body">
              @if($question->type == 0 || $question->type > 4)
              <div class="form-group">
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('question['. $question->id .'][response]','0',false,array('class' => 'surveyQuestion')) !!}
                            Yeah
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('question['. $question->id .'][response]','1',false,['class' => 'surveyQuestion']) !!}
                            Nope
                        </lable>
                   </div>
               </div>
                @elseif($question->type == 1)
                    <div class="form-group">
                        <div class="col-sm-9">
                            <div class="btn-group" data-toggle="buttons">
               	
                    @for($i = 1; $i <= 5; $i++)
                    <label class="btn btn-default">
                        {!! Form::radio('question['. $question->id .'][response]',$i,false,['class' => 'surveyQuestion']) !!} {{ $i }}
                     </label> 
                    @endfor
                             </div>
                             <div class="row">
                                 <div class="col-xs-1 small text-center">Not Gucci</div>
                                 <div class="col-xs-1 col-xs-offset-1 small text-center">Gucci</div>
                             </div>
                        </div>
                    </div>
                @elseif($question->type == 2)
                    <div class="form-group">
                        <div class="col-sm-9">
                    @foreach($question->options as $value => $option)
                    <div class="radio">
                        <label>
                        {!! Form::radio('question['. $question->id .'][response]',$value,false,['class' => 'surveyQuestion']) !!} {{ $option->name }}
                       </label> 
                    </div>
                    @endforeach
                        </div>
                    </div>
                    
                @elseif($question->type == 3)
                <div class="form-group">
                    <label>
                    {!! Form::textarea('question['. $question->id .'][response]', '', ['class' => 'form-control surveyQuestion','placeholder' => 'Tell us what you think!', 'rows' => 4, 'cols' => 110 ]) !!}
                    </label>
                </div>
                @elseif($question->type == 4)
                <div class="form-group">
                    <label>
                    {!! Form::input('number','question['. $question->id .'][response]', '', ['class' => 'form-control surveyQuestion' ]) !!}
                    </label>
                </div>
                @endif
                
               <!--  {!! Form::hidden('question['. $question->id .'][question_id]', $question->id) !!} -->
           </div>
          </div>
              @endforeach
    
         @endforeach
          
          <div class="row">
          		{!! Form::submit('Submit Response', ['class' => 'btn btn-default']) !!}
           </div>
        {!! Form::close() !!}
    @endif

   <h2>{!! $total = $survey->responses->groupBy('user_id')->count() !!} people have responded to this survey.
   </h2>
    
    @if(Entrust::hasRole('admin'))
    <h2>Members who haven't filled out the survey yet.</h2>
    <!-- List of users who haven't voted yet - we can use this to vote for users, or check who needs to vote. -->
    <table class="table table-striped survey-table">
                <tr>
                    <td>Member Name</td>
                   <!-- <td>Vote</td> -->
                </tr>
                @foreach($no_response as $response)
             	<tr>
                    <td><a href="{{ url('members/'.$response->user_id) }}">{{ $response->name }}</a></td>
                </tr>
             	@endforeach
           </table>
                
    </table>
    @endif
    
   @endif

@endsection

@section('jquery')
<script>
$(document).ready(function() {
		
		    $('#responseForm')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			fields: {
                surveyQuestion: {
					selector: '.surveyQuestion',
					validators: {
						notEmpty: {
                        message: 'Pretty please respond to all the questions!'
                    	}
					}
				}
			}
        });
		
	});
</script>
@endsection

