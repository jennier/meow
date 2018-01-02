@extends('layouts.master')

@section('title')
Report from {!! $report->owner->name !!}
@endsection

@section('content')

<div class="panel panel-default">
        <div class="panel-heading"><strong>Report submitted by {!! $report->owner->name !!} on {!! $report->created_at !!}</strong></div>
          <table class="table table-striped">
                	<tr>
                    	<td><strong>Client</strong></td>
                        <td>{!! $report->client !!}</td>
                    </tr>
                    <tr>
                    	<td><strong>Type</strong></td>
                        <td>{!! $report->reportType() !!}</td>
                   </tr>
                   <tr>
                   		<td><strong>Report</strong></td>
                        <td>{!! $report->content !!}</td>
                   </tr>
            </table>
           </div>
@stop