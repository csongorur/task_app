@extends('app')

@include('users._sign_in_nav_bar')

@section('content')

	<div class="col-xs-12">
		{!! Form::open(['method' => 'POST', 'action' => 'UsersController@login', 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
		    {!! Form::label('username', 'Username') !!}
		    {!! Form::text('username', null, ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('username') }}</small>
		</div>
		<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
		    {!! Form::label('password', 'Password') !!}
		    {!! Form::password('password', ['class' => 'form-control']) !!}
		    <small class="text-danger">{{ $errors->first('password') }}</small>
		</div>
		<div class="form-group">
		   {!! Form::submit(trans('Login'), ['class' => 'btn btn-default form-control']) !!}
   		</div>
		{!! Form::close() !!}
	</div>
@endsection
