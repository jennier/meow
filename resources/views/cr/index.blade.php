@extends('layouts.master')

@section('title', 'CR Reports')

@section('content')
  <div class="panel panel-default">
	<div class="panel-heading">
		All CR Reports
	</div>
       <div class="panel-body">
       @if($cr_reports->count() > 0)
		<table class="table table-stripped table">
		<thead>
			<th>Member</th>
			<th>Client</th>
			<th>Type</th>
			<th>Content</th>

			<th>Created At</th>
			<th class="text-center">Action</th>
		</thead>
        
		<tbody>
			@foreach ($cr_reports as $cr_report)
				<tr>
					<td><a href="{{ route('members.show', ['member' => $cr_report->owner->name]) }}">{{ $cr_report->owner->name }}</a></td>
					<td>{!! $cr_report->client !!}</td>
					<td>{!! $cr_report->reportType() !!}</td>
					<td>{!! $cr_report->content !!}</td>
		
					<td>{!! $cr_report->created_at !!}</td>
                     
					<td class="text-center">
						<div class="btn-group">
							{!! Form::open(['method' => 'DELETE', 'route' => ['cr.reports.destroy', $cr_report->id]]) !!}
							<a href="{!! route('cr.reports.show', $cr_report->id) !!}" class="btn btn-sm btn-default" title="View" data-toggle="tooltip"><i class="glyphicon glyphicon-eye-open"></i></a>
                            @if(Entrust::hasRole('admin'))
							<button type="submit" class="btn btn-sm btn-default" title="Delete" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></button>
							{!! Form::close() !!}
						</div>
					</td>
                    @endif
				</tr>
				<?php $no++; ?>
			@endforeach
		</tbody>
	</table>
	@else 
    
    <p>There are currently no reports</p>
    @endif
</div>
@stop