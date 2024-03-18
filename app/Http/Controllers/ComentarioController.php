<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {

        // Validate the request data
        $request->validate([
            'comentario' => 'required|max:255',
        ]);

        // Store the comment
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        // Redirects the user back to the previous page with a success message
        return back()->with('mensaje', 'Comentario Realizado Correctamente');

    }
}
