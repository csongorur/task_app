<?php

namespace App\Http\Controllers;

use App\Migration;
use App\Task;
use App\Version;
use Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class VersionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update_version()
    {
        // If no task redirect with error message
        if (Task::count() <= 0) {
            Session::flash('error_msg', 'No task!');

            return redirect()->action('TasksController@index');
        }

        $version = Version::orderBy('version', 'DESC')->first();

        if (is_null($version)) {
            $version_nr = 1;
        } else {
            $version_nr = $version->version + 1;
        }

        $new_table_name = 'tasks_' . $version_nr;

        // Rename tasks table
        Schema::rename('tasks', $new_table_name);

        // Regenerate foreign keys
        Schema::table($new_table_name, function ($table) {
            $table->dropForeign('tasks_user_id_foreign');
            $table->dropForeign('tasks_project_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        $new_version = Version::create(['version' => $version_nr, 'table_name' => $new_table_name]);

        // Update batch nr for migration rollback
        $batch_nr = Migration::max('batch');
        $migration = Migration::where('migration', '2017_07_04_053640_create_tasks_table')->first();
        $migration->batch = $batch_nr + 1;
        $migration->update();

        // Recreate tasks table
        Artisan::call('migrate:rollback');
        Artisan::call('migrate');

        Session::flash('success_msg', 'New version was successful created');

        return redirect()->action('TasksController@index');
    }
}
