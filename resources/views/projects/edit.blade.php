@extends('app')

@include('projects._nav_bar')

@section('content')
	{!! Form::model($project, ['action' => ['ProjectsController@update', $project->id], 'method' => 'POST']) !!}
		<div class="col-xs-12">
			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			    {!! Form::label('name', 'Name') !!}
			    {!! Form::text('name', null, ['class' => 'form-control']) !!}
			    <small class="text-danger">{{ $errors->first('name') }}</small>
			</div>
		</div>
		<div class="col-xs-12 col-md-4">
			<div class="form-group marginR15">
				{!! Form::submit('Update', ['class' => 'form-control btn btn-default']) !!}
			</div>
		</div>
		<div class="col-xs-12 col-md-4">
			<div class="form-group">
				<a class="btn btn-default form-control" href="{{ action('ProjectsController@index') }}">Back</a>
			</div>
		</div>
		<div class="col-xs-12 col-md-4">
			<div class="form-group marginL15">
				<a class="btn btn-danger form-control" href="{{ action('ProjectsController@delete', $project->id) }}">Delete</a>
			</div>
		</div>

	{!! Form::close() !!}
@endsection
