@section('nav-bar-items')
	<span><h4><a href="{{ action('UsersController@edit', \Auth::user()->id) }}">{{ \Auth::user()->username }}</a></h4></span>
	<a class="btn btn-default marginR15" href="{{ action('ProjectsController@index') }}">Projects</a>
	<a class="btn btn-default marginR15" href="{{ action('TasksController@create') }}">New Task</a>
    <a class="btn btn-default marginR15" href="{{ action('VersionsController@update_version') }}">New Version</a>
	<a class="btn btn-default" href="{{ action('UsersController@log_out') }}">Log out</a>
@endsection
