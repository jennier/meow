@extends('layouts.master')

@section('title', 'View Ballot')

@section('breadcrumbs')
@endsection

@section('content')

	@if($ballot)
	<h2>{{ $ballot->name }}</h2>
    <p>Ballot was created by <a href="{{ url('members/'.$ballot->user_id) }}">{{ $ballot->owner->name }}</a> on <strong>{{ date('F d, Y', strtotime($ballot->created_at)) }}</strong>.
    <p>This ballot expires on <strong>{{ date('F d, Y', strtotime($ballot->expiration)) }}</strong>.</p>
    
    @if($ballot->support()->count() > 0)
    	<?php $count = 0 ?>
    	<p>This ballot is supported by
        @foreach($ballot->supporters as $supporter)
        	<?php $count++; ?>
        	<a href="{{ route('members.show', $supporter->id) }}">{{ $supporter->name }}</a>@if($count < $ballot->support()->count()), @endif
        @endforeach
        </p>
    @endif
    
    @if(Entrust::hasRole('admin') || $ballot->owner->id == Auth::user()->id)
    {!! Form::open(['method' => 'PATCH', 'route' => array('ballots.update', $ballot->id), 'class' => 'form', 'id' => 'expirationForm']) !!}
    <div class="form-group">
    	@if($ballot->isExpired())
        <input type="hidden" name="status" value="1">
    	<button class="btn btn-danger" type="submit">Open Ballot</button>
        @else
        <input type="hidden" name="status" value="2">
        <button class="btn btn-success" type="submit">Close Ballot</button>
        @endif
    </div>
    {!! Form::close() !!}
 	
       {!! Form::open(['method' => 'POST', 'route' => array('ballots.notify', $ballot->id), 'class' => 'form', 'id' => 'notificationForm']) !!}
    <div class="form-group">
    	<button class="btn btn-info" type="submit">Send Voting Reminder</button>
    </div>
     {!! Form::close() !!}
    @endif
    
    @foreach($ballot->content as $content)
    	<div class="jumbotron">
        	<p>{!! nl2br(e($content->text)) !!}</p>
            @if($content->link != null)
            <p>Additional informtion about this ballot can be found <a href="{{ $content->link }}">here</a>.</p>
            @endif
        </div>
    @endforeach
    
    @if($ballot->status == 0)
    	@if($ballot->checkUserSupport(Auth::user()->id))
        	<h4>You've already pledged your support for this ballot.</h4>
        @else 
        	<h4>This ballot needs more support before it can be voted on. Click <a href="{{ route('ballots.support', $ballot->id) }}">here</a> to add your support.</h4>
        @endif

    @elseif($ballot->status == 2)
   		<h4>The voting period for this ballot has ended.</h4>
    @elseif($ballot->checkUserVote(Auth::user()->id))
    	<h4>You've already voted on this ballot.</h4>
    @elseif(Entrust::hasRole('inactive'))
    	<h4>You are not currently eligible to vote on this ballot.</h4>
    @else 
  		{!! Form::open(['method' => 'POST', 'route' => array('ballots.vote.store', $ballot->id), 'class' => 'form', 'id' => 'voteForm']) !!}
        <h2>Vote</h2>
        
        @if($ballot->isBallotPrivate())
        	<h3>This is a private ballot - your vote will not be visible to any other member of the collective.</h3>
        @endif 
        
        @foreach($ballot->questions as $question)
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">{{ $question->question }}</h3>
          </div>
          <div class="panel-body">
          <!-- Determine question type -->
          @if($question->type == 0)
        	<div class="radio-inline">
  				<label>
                    {!! Form::radio('question['. $question->id .'][vote]','0') !!}
                    Widdit
        		</label>
            </div>
            <div class="radio-inline">
                <label>
                	{!! Form::radio('question['. $question->id .'][vote]','1') !!}
                    Nope
                </lable>
           </div>
           <div class="radio-inline">
           		 <label>
                	{!! Form::radio('question['. $question->id .'][vote]','2') !!}
                    Stand Aside
                </label>
          </div>
          @elseif($question->type == 1)
           <div class="form-group">
           	<div class="row">
             <div class="col-sm-4">
                   <div class="btn-group" data-toggle="buttons">
               	   <div class="btn btn-danger disabled"><span class="glyphicon glyphicon-thumbs-down"></span></div>
                    @for($i = 1; $i <= 5; $i++)
                    <label class="btn btn-default">
                        {!! Form::radio('question['. $question->id .'][vote]',$i,false,['class' => 'surveyQuestion']) !!} {{ $i }}
                     </label> 
                    @endfor
                    <div class="btn btn-success disabled"><span class="glyphicon glyphicon-heart-empty"></span></div>
                    </div>
                 </div>
              </div>
               <p class="help-block">Please rate this question on a scale from 1-5, where one is "this sucks" and five is "fuck yeah".</p>
              
            </div>
          @else
          <div class="form-group">
          	 <p class="help-block">Please choose the option you most prefer out of the choices given.</p>
          	@foreach($question->choices as $choice)
                <div class="radio">
                     <label>
                        {!! Form::radio('question['. $question->id .'][vote]',$choice->id) !!}
                        {{ $choice->name }}
                    </label>
                </div>
            @endforeach
            
          </div>
          @endif
          
          <!-- All questions have a comment area --> 
          <div class="radio-inline">
                <label>
                {!! Form::textarea('question['. $question->id .'][comments]', '', ['class' => 'form-control','placeholder' => 'Comments?', 'rows' => 2, 'cols' => 110 ]) !!}
                </label>
          </div>
          {!! Form::hidden('question['. $question->id .'][question_id]', $question->id) !!}
          </div>
      </div>
          @endforeach
          
          <div class="form-group">
          		{!! Form::submit('Vote', ['class' => 'btn btn-default']) !!}
           </div>
        {!! Form::close() !!}
    @endif

   @if($ballot->status > 0)
   <h2>Current Votes 
   		<small>
        	TOTAL <span class="badge">{!! $total = $ballot->votes->groupBy('user_id')->count() !!}</span>
            
        </small>
   </h2>
   

   
   @if($ballot->isBallotPrivate())
        	<h4>This is a private ballot, your votes are not visible to other members.</h4>
   @endif
   
   @if($ballot->votes->count() > 0)
		  @foreach($ballot->questions as $question)
      		<div class="row">
                <div class="col-md-12">
                    <h3>{{ $question->question }} 
                    
                   @if(!$ballot->isBallotPrivate() OR Auth::user()->hasRole('admin'))
                   	
                        @if($question->type == 0)
                            <a class="btn btn-success disabled" role="button">
                                Yes <span class="badge">{{ $question->votes()->where('vote',0)->count() }}</span> 
                            </a>
                             <a class="btn btn-danger disabled" role="button">
                                No <span class="badge">{{ $question->votes()->where('vote',1)->count() }}</span>
                             </a>
                             <a class="btn btn-info disabled" role="button">
                                Stand Aside <span class="badge">{{ $question->votes()->where('vote',2)->count() }}</span>
                             </a>
                        @elseif($question->type == 1)
                        	@for($i=0; $i <= 5; $i++)
                         	<a class="btn btn-info disabled" role="button">
                               {{ $i }} <span class="badge">{{ $question->votes()->where('vote',$i)->count() }}</span>
                            </a>
                            @endfor
                     	@else 
                        	@foreach($question->choices as $choice)
                            <a class="btn btn-info disabled" role="button">
                               {{ $choice->name }} <span class="badge">{{ $question->votes()->where('vote',$choice->id)->count() }}</span>
                            </a>
                            @endforeach
                        @endif
                 
                    @endif
    					@if(true == false)
                		@if($ballot->isExpired() && $question->passed($total) == true)
                        	<span class="text-uppercase text-success">Passed <span class="glyphicon glyphicon-ok"></span></span>
                        @elseif($ballot->isExpired() && $question->passed($total) == false ) 
                        	<span class="text-uppercase text-danger">Failed <span class="glyphicon glyphicon-remove"></span></span>
                        @endif
                        @endif
                    </h3>
                </div>
            </div>
           
           <!-- If the ballot is public, or if the ballot is private and the user has voted -->
           @if(!$ballot->isBallotPrivate() || $ballot->isBallotPrivate() && $ballot->checkUserVote(Auth::user()->id) || Auth::user()->hasRole('hr'))
           <br><br>
            <table class="table table-striped ballot-table">
                <tr>
                    <td>Member 
                    	@if(!$ballot->isBallotPrivate()) Name @else Class @endif </td>
                    <td></td>
                    <td>Comment</td>
                </tr>
                	
                    
                     @foreach($ballot->votes as $vote)
           
                        @if($vote->question_id == $question->id && !$ballot->isBallotPrivate() 
                        	|| $vote->question_id == $question->id && $ballot->isBallotPrivate() && $vote->user_id == Auth::user()->id 
                            || $vote->question_id == $question->id && Auth::user()->hasRole('hr'))
                            <tr>
                                <td>
                                @if(!$ballot->isBallotPrivate())
                                	<a href="{{ url('members/'.$vote->user_id) }}">{{ $vote->user->name }}</a>
                                @endif
                                
                              	@if(Auth::user()->hasRole('hr'))
                                    @foreach($vote->user->roles as $role)
                                        <span class="label label-info">{{ $role->name }}</span>
                                    @endforeach
                                @endif
                    			</td>
                            
                                	<td>{{ $question->showVote($vote->vote) }}</td>
                           
                                <td>{{ $vote->comments }}</td>
                            </tr>
                        @endif
                     @endforeach 
                   </table>
               @endif
               @endforeach
   @else
   	<p>No one has voted on this ballot.</p>
   @endif
   @endif
    
        @if(Entrust::hasRole('admin'))
        <h2>Members who still need to vote</h2>
            <!-- List of users who haven't voted yet - we can use this to vote for users, or check who needs to vote. -->
            <table class="table table-striped ballot-table">
                        <tr>
                            <td>Member Name</td>
                           <!-- <td>Vote</td> -->
                        </tr>
                    
             </table>
        @endif
    
    @endif <!-- end if the ballot is live or expired --> 
    
<!-- 
  <div id="dialog-form" title="Vote for member">
  <p class="validateTips">All form fields are required.</p>
 
  <form>
    <fieldset>
      <label for="name">Name</label>
      <input type="text" name="name" id="name">
      <label for="email">Email</label>
      <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
 
       Allow form submission with keyboard without duplicating the dialog button
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
-->
@endsection

@section('script')

@endsection

