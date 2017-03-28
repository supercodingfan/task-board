<?php

namespace Taskr\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('registration.create');
    }

    public function store()
    {
        // Validate the form
        $this->validate(request(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        // Create and save the user
        $isCreated = DB::insert('insert into users (first_name, last_name, email, password, is_admin) values (?, ?, ?, ?, ?)',
            [request('first_name'), request('last_name'), request('email'), Hash::make(request('password')), false]);

        if ($isCreated) {
            $results = DB::select('SELECT * FROM users WHERE email = ?', [request('email')]);

            // Create new user object and store information into it
            $user = new \Taskr\User;
            $user->id = $results[0]->id;
            $user->first_name = request('first_name');
            $user->last_name = request('last_name');
            $user->email = request('email');
            $user->is_admin = request('is_admin');

            // Login the user into laravel authentication and redirect to home
            auth()->login($user);
            return redirect()->home();
        } else {
            // throw some error that insertion has failed. violate unique constraints?
            request()->flash();
            return back()->withErrors([
                'message' => 'There is something wrong with your registration. Try again later.'
            ]);
        }
    }
}
