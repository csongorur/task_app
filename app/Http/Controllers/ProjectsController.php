<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Project;

class ProjectsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$projects = Project::where('user_id', Auth::user()->id)->paginate(15);

		return view('projects.index')->with('projects', $projects);
	}

	public function edit($id)
	{
		$project = Project::findOrFail($id);

		return view('projects.edit')->with('project', $project);
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, ['name' => 'required']);

		$req = $request->all();

		$project = Project::findOrFail($id);
		$project->update($req);

		Session::flash('success_msg', 'Update was successfull');

		return redirect()->action('ProjectsController@index');
	}

	public function delete($id)
	{
		$project = Project::findOrFail($id);
		$project->delete();

		Session::flash('success_msg', 'Delete was successfull');

		return redirect()->action('ProjectsController@index');
	}
}
