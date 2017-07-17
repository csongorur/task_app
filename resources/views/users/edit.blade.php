@extends('app')

@include('tasks._nav_bar')

@section('content')
	{!! Form::model($user ,['method' => 'POST', 'action' => ['UsersController@update', $user->id], 'class' => 'form-horizontal', 'id' => 'saveForm']) !!}
		<div class="col-xs-12">
			<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
			    {!! Form::label('username', 'Username') !!}
			    {!! Form::text('username', null, ['class' => 'form-control']) !!}
			    <small class="text-danger">{{ $errors->first('username') }}</small>
			</div>
			<div class="form-group{{ $errors->has('password1') ? ' has-error' : '' }}">
			    {!! Form::label('password1', 'Password') !!}
			    {!! Form::password('password1', ['class' => 'form-control', 'id' => 'password2']) !!}
			    <small class="text-danger">{{ $errors->first('password1') }}</small>
			</div>
			<div class="form-group{{ $errors->has('password2') ? ' has-error' : '' }}">
			    {!! Form::label('password2', 'Password') !!}
			    {!! Form::password('password2', ['class' => 'form-control', 'id' => 'password1']) !!}
			    <small class="text-danger">{{ $errors->first('password2') }}</small>
			</div>
		</div>
		<div class="col-xs-12 col-md-4">
			<div class="form-group marginR15">
				{!! Form::submit("Update", ['class' => 'btn btn-default form-control']) !!}
			</div>
		</div>
		<div class="col-xs-12 col-md-4">
			<div class="form-group marginL15">
				<a class="btn btn-default form-control" href="{{ action('TasksController@index') }}">Cancel</a>
			</div>
		</div>
		<div class="col-xs-12 col-md-4">
			<div class="form-group marginL15">
				<a class="btn btn-danger form-control" href="{{ action('UsersController@delete', $user->id) }}">Delete</a>
			</div>
		</div>
	{!! Form::close() !!}
@endsection

@section('content-scripts')
	<script type="text/javascript">
		$(function() {

			$('#saveForm').submit(function() {
				if ($('#password1').val() != $('#password2').val()) {
					$('#password1').parent('.form-group').addClass('has-error');
					$('#password2').parent('.form-group').addClass('has-error');
					$('#password1').parent('.form-group').find('.text-danger').append('Password does not match');
					$('#password2').parent('.form-group').find('.text-danger').append('Password does not match');

					return false;
				}
				else {
					return true;
				}
			});
		});
	</script>
@endsection
