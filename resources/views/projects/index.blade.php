@extends('app')

@include('projects._nav_bar')

@section('content')
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Tasks</th>
				<th>Created Date</th>
				<th>Total Tasks</th>
			</tr>
		</thead>
		<tbody>
			@if (count($projects) > 0)
				@foreach ($projects as $project)
					<tr>
						<td><a href="{{ action('ProjectsController@edit', $project->id) }}">{{ $project->name }}</a></td>
						<td>{{ $project->get_task_names() }}</td>
						<td>{{ \Carbon\Carbon::parse($project->created_at)->format('Y.m.d') }}</td>
						<td>{{ $project->total_tasks_nr() }}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="13">No Project</td>
				</tr>
			@endif
		</tbody>
	</table>
	{{ $projects->links() }}
@endsection
