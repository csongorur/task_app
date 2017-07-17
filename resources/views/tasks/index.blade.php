@extends('app')

@include('tasks._nav_bar')

@section('content')
	<div class="filter-container">
		<div class="form-group inline">
			<label for="project-filter">Projects</label>
			<select class="form-control select-box" id="project-filter">
				<option value="-1">All</option>
				@foreach (\App\Project::where('user_id', \Auth::user()->id)->orderBy('name')->get() as $project)
					<option value="{{ $project->id }}">{{ $project->name }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group inline marginL15">
			<label for="status-filter">Status</label>
			<select class="form-control select-box" id="status-filter">
				<option value="-1">All</option>
				@foreach (Config::get('tasks.status') as $status)
					<option value="{{ $status }}">{{ $status }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group inline marginL15">
			<label for="priority-filter">Priorities</label>
			<select class="form-control select-box" id="priority-filter">
				<option value="-1">All</option>
				@foreach (Config::get('tasks.priority') as $priority)
					<option value="{{ $priority }}">{{ $priority }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="table-container">
		@include('tasks._table')
	</div>
	{{ $items->links() }}
@endsection

@section('content-scripts')
	<script type="text/javascript">
		$(function() {

			$('#project-filter, #status-filter, #priority-filter').change(function() {
				hidePagination();
				$.ajax({
					'url': '{{ action('TasksController@filter') }}',
					'data': {'project': $('#project-filter').val(), 'status': $('#status-filter').val(), 'priority': $('#priority-filter').val()}
				}).done(function(res) {
					$('.table').remove();
					$('.table-container').html(res);
				});
			});

			function hidePagination() {
				if ($('#project-filter').val() != -1 || $('#status-filter').val() != -1 || $('#priority-filter').val() != -1) {
					$('.pagination').addClass('hide');
				}
				else {
					$('.pagination').removeClass('hide');
				}
			}
		});
	</script>
@endsection
