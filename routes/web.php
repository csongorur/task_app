<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'UsersController@index');
Route::post('login', 'UsersController@login');
Route::get('log-out', 'UsersController@log_out');
Route::get('sign-in', 'UsersController@create');
Route::post('sign-in/save', 'UsersController@store');
Route::get('user/{id}/edit', 'UsersController@edit');
Route::post('user/{id}/update', 'UsersController@update');
Route::get('user/{id}/delete', 'UsersController@delete');

Route::get('tasks', 'TasksController@index');
Route::get('task/new', 'TasksController@create');
Route::post('task/new/save', 'TasksController@store');
Route::get('task/{id}/edit', 'TasksController@edit');
Route::post('task/{id}/update', 'TasksController@update');
Route::get('task/{id}/delete', 'TasksController@delete');
Route::get('task/list', 'TasksController@filter');

Route::get('projects', 'ProjectsController@index');
Route::get('project/{id}/edit', 'ProjectsController@edit');
Route::post('project/{id}/update', 'ProjectsController@update');
Route::get('project/{id}/delete', 'ProjectsController@delete');
