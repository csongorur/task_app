@section('nav-bar-items')
	<span><h4><a href="{{ action('UsersController@edit', \Auth::user()->id) }}">{{ \Auth::user()->username }}</a></h4></span>
	<a class="btn btn-default marginR15" href="{{ action('TasksController@index') }}">Tasks</a>
	<a class="btn btn-default marginR15" href="{{ action('TasksController@create') }}">New Task</a>
	<a class="btn btn-default" href="{{ action('UsersController@log_out') }}">Log out</a>
@endsection
