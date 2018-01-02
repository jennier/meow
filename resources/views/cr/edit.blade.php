@extends('layouts.master')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            Edit CrReport
            <div class="panel-nav pull-right" style="margin-top: -7px;">
                <a href="{!! route('cr_reports.index') !!}" class="btn btn-default">Back</a>
            </div>
        </div>
        <div class="panel-body">
            @include('cr_reports.form', ['model' => $cr_report])
        </div>
    </div>

@stop