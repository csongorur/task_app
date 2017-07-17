<table class="table">
	<thead>
		<tr>
			<th>NR</th>
			<th>New</th>
			<th>Progess</th>
			<th>Finished</th>
			<th>Pushed</th>
		</tr>
	</thead>
	<tbody>
		@php
			$nr = 1;
		@endphp
		@if (count($items) > 0)
			@foreach ($items as $item)
				<tr>
					<td>{{ $nr++ }}</td>
					<td>
						@if ($item->status == 'new')
							<a href="{{ action('TasksController@edit', $item->id) }}">
								<div class="{{ $item->priority }}">
									{{ $item->name . ' | ' . $item->remaining_day() . ' days' }}
									@if ($item->remaining_day() < 2)
										<i class="fa fa-exclamation-triangle marginL5" aria-hidden="true"></i>
									@endif
								</div>
							</a>
						@endif
					</td>
					<td>
						@if ($item->status == 'progress')
							<a href="{{ action('TasksController@edit', $item->id) }}">
								<div class="{{ $item->priority }}">
									{{ $item->name . ' | ' . $item->remaining_day() . ' days' }}
									@if ($item->remaining_day() < 2)
										<i class="fa fa-exclamation-triangle marginL5" aria-hidden="true"></i>
									@endif
								</div>
							</a>
						@endif
					</td>
					<td>@if ($item->status == 'finished') <a href="{{ action('TasksController@edit', $item->id) }}"> <div>{{ $item->name }}</div> </a> @endif</td>
					<td>@if ($item->status == 'pushed') <a href="{{ action('TasksController@edit', $item->id) }}"> <div>{{ $item->name }}</div> </a> @endif</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="13">No Task</td>
			</tr>
		@endif
	</tbody>
</table>
