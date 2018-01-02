<p>CR Report submitted by {{ $report['owner'] }}</p>

<p>Type: {{ $report['type'] }} </p>

<p>Client: {{ $report['client'] }}</p>

<p>{{ $report['content'] }}</p>

<p><a href="{{ url('cr/reports', $report['id']) }}">View Report</a></p>