<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $fillable = ['id', 'name', 'user_id'];

	public function tasks()
	{
		return $this->hasMany('App\Task', 'project_id');
	}

	public function get_task_names()
	{
		$names = '';

		foreach ($this->tasks as $task) {
			$names .= $task->name . ', ';
		}

		$names = preg_replace('/\, $/', '', $names);

		return $names;
	}

	public function total_tasks_nr()
	{
		return count($this->tasks);
	}
}
