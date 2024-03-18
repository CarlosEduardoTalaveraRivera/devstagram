<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display the login form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user and redirect to the intended page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if the user exists and the password is correct
        if (!auth()->attempt($credentials, $request->remember)) {
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        return redirect()->route('posts.index', [
            'user' => auth()->user(),
        ]);
    }
}
