<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Display the registration form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created user in storage and authenticate it.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // dd($request);
        // dd($request->get('name'));

        // Modify request
        $request->request->add(
            [
                'username' => Str::slug($request->username)
            ]
        );

        // Validation
        $request->validate(
            [
                'name' => 'required|min:2|max:30',
                'username' => ['required', 'unique:users', 'min:3', 'max:20'],
                'email' => ['required', 'unique:users', 'email', 'max:60'],
                'password' => 'required|confirmed|min:6'
            ]
        );

        // Store user
        User::create(
            [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password
            ]
        );

        // Authenticate user
        // auth()->attempt(
        //     [
        //         'email' => $request->email,
        //         'password' => $request->password
        //     ]
        // );

        // Another way to authenticate user
        auth()->attempt($request->only('email', 'password'));

        // Redirect to the feed
        return redirect()->route('posts.index', [
            'user' => auth()->user()
        ]);
    }
}
