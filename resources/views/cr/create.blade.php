@extends('layouts.master')

@section('title', 'Submit CR Report')

@section('content')

{!! Form::open(['method' => 'POST', 'route' => array('cr.reports.store'), 'class' => 'form', 'id' => 'surveyForm']) !!}
   <form class="form-horizontal">
  		<div class="form-group">
            {!! Form::label('client','Client name', ['class' => 'control-label']) !!}
         	{!! Form::text('client','', ['class' => 'form-control', 'placeholder' => 'Big n Littles']) !!}
         </div>
        <h5>Type of submission:</h5>
        <div class="radio">
          <label>
            <input type="radio" name="type" value="0">
            Current client complaint
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="type" value="0">
            Current client compliment
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="type" value="0">
            New client information
          </label>
        </div>
        <div class="form group">
        	{!! Form::label('content','Sup?', ['class' => 'control-label']) !!}
        	<textarea class="form-control" name="content" rows="10" cols="50"></textarea>
        </div>
            <p></p>
               <button type="submit" class="btn btn-primary">Submit Report</button>
            
            {!! Form::close() !!}
 
@stop