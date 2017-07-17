<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\User;

class UsersController extends Controller
{
    public function index()
	{
		return view('users.index');
	}

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user != null && Hash::check($request->password, $user->password)) {
            Auth::login($user);
        }
        else {
            Session::flash('error_msg', 'Username or Password not valid');

            return redirect()->action('UsersController@index')->withError('no');
        }

        return redirect()->action('TasksController@index');
    }

    public function log_out()
    {
        Auth::logout();

        return redirect()->action('UsersController@index');
    }

    public function create()
    {
        return view('users.sign_in');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password1' => 'required',
            'password2' => 'required'
        ]);

        $password = Hash::make($request->password1);

        $user = User::create(['username' => $request->username, 'password' => $password]);

        return redirect()->action('UsersController@index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required'
        ]);

        $req = $request->all();

        $user = User::findOrFail($id);
        if ($req['password1'] == '') {
            $req['password'] = $user->password;
        }
        else {
            $req['password'] = Hash::make($req['password1']);
        }

        $user->update($req);

        Session::flash('success_msg', 'Update was successfull');

        return redirect()->action('TasksController@index');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        Session::flash('success_msg', 'Delete was successfull');

        Auth::logout();

        return redirect()->action('UsersController@index');
    }
}
