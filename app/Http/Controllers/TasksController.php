<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TasksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Task::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(15);

        return view('tasks.index')->with('items', $items);
    }

    public function create()
    {
        $projects_obj = Project::select('id', 'name')->where('user_id', Auth::user()->id)->orderBy('name')->get();
        $projects[-1] = 'other';

        foreach ($projects_obj as $project_obj) {
            $projects[$project_obj->id] = $project_obj->name;
        }

        return view('tasks.create')->with('projects', $projects);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'deadline' => 'required',
        ]);

        $req = $request->all();

        $req['user_id'] = Auth::user()->id;

        if ('' != $req['other_project']) {
            $project = Project::create(['name' => $req['other_project'], 'user_id' => Auth::user()->id]);
            $req['project_id'] = $project->id;
        }

        Task::create($req);

        Session::flash('success_msg', 'Create was successfull');

        return redirect()->action('TasksController@index');
    }

    public function edit($id)
    {
        $item = Task::findOrFail($id);
        $projects_obj = Project::select('id', 'name')->where('user_id', Auth::user()->id)->orderBy('name')->get();
        $projects[-1] = 'other';

        foreach ($projects_obj as $project_obj) {
            $projects[$project_obj->id] = $project_obj->name;
        }

        return view('tasks.edit')->with('item', $item)->with('projects', $projects);
    }

    public function update(Request $request, $id)
    {
        $item = Task::findOrFail($id);

        $req = $request->all();

        if ('' != $req['other_project']) {
            $project = Project::create(['name' => $req['other_project'], 'user_id' => Auth::user()->id]);
            $req['project_id'] = $project->id;
        }

        if ('finished' == $req['status']) {
            $req['finished_at'] = Carbon::now()->toDateString();
        } elseif ('pushed' == $req['status']) {
            if (null == $item->finished_at) {
                $req['finished_at'] = Carbon::now()->toDateString();
            }
            $req['pushed_at'] = Carbon::now()->toDateString();
        } else {
            $req['finished_at'] = null;
            $req['pushed_at'] = null;
        }

        $item->update($req);

        Session::flash('success_msg', 'Update was successfull');

        return redirect()->action('TasksController@index');
    }

    public function delete($id)
    {
        $item = Task::findOrFail($id);

        $item->delete();

        Session::flash('success_msg', 'Delete was successfull');

        return redirect()->action('TasksController@index');
    }

    public function filter()
    {
        $items = Task::query();

        if (Input::has('interval') && Input::get('interval') != '') {
            $date = explode(' / ', Input::get('interval'));
            $items = $items->where('created_at', '>=', $date[0])->where('created_at', '<=', Carbon::parse($date[1])->toDateString());
        }

        if (Input::has('project') && Input::get('project') != -1) {
            $items = $items->where('project_id', Input::get('project'))->orderBy('created_at', 'desc');
        }

        if (Input::has('status') && Input::get('status') != -1) {
            $items = $items->where('status', Input::get('status'))->orderBy('created_at', 'desc');
        }

        if (Input::has('priority') && Input::get('priority') != -1) {
            $items = $items->where('priority', Input::get('priority'))->whereIn('status', ['new', 'progress']);
        }

        $items = $items->orderBy('created_at', 'desc');

        if (Input::get('project') == -1 && Input::get('status') == -1 && Input::get('priority') == -1 && Input::get('interval') == '') {
            $items = $items->paginate(15);
        } else {
            $items = $items->get();
        }

        return view('tasks._table')->with('items', $items);
    }
}
