@extends('app')

@include('tasks._nav_bar')

@section('content')
	{!! Form::model($item, ['method' => 'POST', 'action' => ['TasksController@update', $item->id], 'class' => 'form-horizontal']) !!}
		<div class="col-xs-12">
			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			    {!! Form::label('name', 'Name') !!}
			    {!! Form::text('name', null, ['class' => 'form-control']) !!}
			    <small class="text-danger">{{ $errors->first('name') }}</small>
			</div>
			<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
			    {!! Form::label('description', 'Description') !!}
			    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
			    <small class="text-danger">{{ $errors->first('description') }}</small>
			</div>
			<div class="form-group{{ $errors->has('created_at') ? ' has-error' : '' }}">
			    {!! Form::label('created_at', 'Created At') !!}
			    {!! Form::text('created_at', null, ['class' => 'form-control', 'disabled']) !!}
			    <small class="text-danger">{{ $errors->first('created_at') }}</small>
			</div>
			<div class="form-group{{ $errors->has('finished_at') ? ' has-error' : '' }}">
			    {!! Form::label('finished_at', 'Finished At') !!}
			    {!! Form::text('finished_at', null, ['class' => 'form-control', 'disabled']) !!}
			    <small class="text-danger">{{ $errors->first('finished_at') }}</small>
			</div>
			<div class="form-group{{ $errors->has('pushed_at') ? ' has-error' : '' }}">
			    {!! Form::label('pushed_at', 'Pushed At') !!}
			    {!! Form::text('pushed_at', null, ['class' => 'form-control', 'disabled']) !!}
			    <small class="text-danger">{{ $errors->first('pushed_at') }}</small>
			</div>
			<div class="form-group{{ $errors->has('project_id') ? ' has-error' : '' }}">
			    {!! Form::label('project_id', 'Project') !!}
			    {!! Form::select('project_id', $projects, null, ['class' => 'form-control', 'id' => 'project']) !!}
			    <small class="text-danger">{{ $errors->first('project_id') }}</small>
			</div>
			<div class="form-group hidden other-project-container{{ $errors->has('other_project') ? ' has-error' : '' }}">
			    {!! Form::label('other_project', 'Other Project') !!}
			    {!! Form::text('other_project', null, ['class' => 'form-control', 'id' => 'other-project']) !!}
			    <small class="text-danger">{{ $errors->first('other_project') }}</small>
			</div>
			<div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
			    {!! Form::label('priority', 'Priority') !!}
			    {!! Form::select('priority', Config::get('tasks.priority'), null, ['class' => 'form-control']) !!}
			    <small class="text-danger">{{ $errors->first('priority') }}</small>
			</div>
			<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
			    {!! Form::label('status', 'Status') !!}
			    {!! Form::select('status', Config::get('tasks.status'), null, ['class' => 'form-control']) !!}
			    <small class="text-danger">{{ $errors->first('status') }}</small>
			</div>
			<div class="form-group{{ $errors->has('deadline') ? ' has-error' : '' }}">
			    {!! Form::label('deadline', 'Dead line') !!}
			    {!! Form::date('deadline', null, ['class' => 'form-control']) !!}
			    <small class="text-danger">{{ $errors->first('deadline') }}</small>
			</div>
		</div>
		<div class="col-xs-12 col-md-4">
			<div class="form-group marginR15">
				{!! Form::submit('Update', ['class' => 'form-control btn btn-default']) !!}
			</div>
		</div>
		<div class="col-xs-12 col-md-4">
			<div class="form-group">
				<a class="btn btn-default form-control" href="{{ action('TasksController@index') }}">Back</a>
			</div>
		</div>
		<div class="col-xs-12 col-md-4">
			<div class="form-group marginL15">
				<a class="btn btn-danger form-control" href="{{ action('TasksController@delete', $item->id) }}">Delete</a>
			</div>
		</div>
	{!! Form::close() !!}
@endsection

@section('content-scripts')
	<script type="text/javascript">
		$(function() {
			otherProject();
			$('#project').change(function() { otherProject(); });

			function otherProject() {
				if ($('#project').val() == '-1') {
					$('.other-project-container').removeClass('hidden');
				}
				else {
					$('.other-project-container').addClass('hidden');
					$('#other-project').val('');
				}
			}
		});
	</script>
@endsection
