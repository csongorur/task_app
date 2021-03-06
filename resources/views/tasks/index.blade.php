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
		<div class="form-group inline marginL15">
			<div class="daterange-container">
				<label for="daterange">Interval</label>
				<input id="daterange" class="form-control" type="text" name="daterange" />
			</div>
		</div>
		<div class="inline floatRight status-container">
			<h3>Total active tasks: {{ App\Task::total_active_tasks() }}</h3>
			<h3>Total finished tasks: {{ App\Task::total_finished_tasks() }}</h3>
			<h3>Total tasks: {{ App\Task::total_tasks() }}</h3>
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

			$('input[name="daterange"]').daterangepicker({
				autoUpdateInput: false,
				locale: {
					format: 'Y-M-D'
				}
			});

			$('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));

				hidePagination();

				$.ajax({
					'url': '{{ action('TasksController@filter') }}',
					'data': {'project': $('#project-filter').val(), 'status': $('#status-filter').val(), 'priority': $('#priority-filter').val(), 'interval': $('input[name="daterange"]').val()}
				}).done(function(res) {
					$('.table').remove();
					$('.table-container').html(res);
				});
			});

			$('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val('');

				hidePagination();

				$.ajax({
					'url': '{{ action('TasksController@filter') }}',
					'data': {'project': $('#project-filter').val(), 'status': $('#status-filter').val(), 'priority': $('#priority-filter').val(), 'interval': $('input[name="daterange"]').val()}
				}).done(function(res) {
					$('.table').remove();
					$('.table-container').html(res);
				});
			});

			$('#project-filter, #status-filter, #priority-filter').change(function() {
				hidePagination();
				$.ajax({
					'url': '{{ action('TasksController@filter') }}',
					'data': {'project': $('#project-filter').val(), 'status': $('#status-filter').val(), 'priority': $('#priority-filter').val(), 'interval': $('input[name="daterange"]').val()}
				}).done(function(res) {
					$('.table').remove();
					$('.table-container').html(res);
				});
			});

			function hidePagination() {
				if ($('#project-filter').val() != -1 || $('#status-filter').val() != -1 || $('#priority-filter').val() != -1 || $('input[name="daterange"]').val() != '') {
					$('.pagination').addClass('hide');
				}
				else {
					$('.pagination').removeClass('hide');
				}
			}
		});
	</script>
@endsection
