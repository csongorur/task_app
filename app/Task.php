<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'status', 'priority', 'deadline', 'user_id', 'project_id', 'finished_at', 'pushed_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function remaining_day()
    {
        $deadline = Carbon::parse($this->deadline);
        return $deadline->diffInDays(Carbon::now()) + 1;
    }
}
