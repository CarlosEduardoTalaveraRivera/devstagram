<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(6);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);

        // Forma 1 de crear un registro (mi preferida si no se usa Eloquent)
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        // Forma 2 de crear un registro
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // Forma 3 de crear un registro usando relaciones de Eloquent, la más recomendada
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index', [
            'user' => auth()->user(),
        ]);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'user' => $user,
            'post' => $post,
        ]);
    }

    public function destroy(Post $post)
    {
        if (!Gate::allows('delete', $post)) {
            abort(403);
        }

        $post->delete();

        // Delete the image from the storage
        $imagen_path = public_path('uploads/' . $post->imagen);

        if (File::exists($imagen_path)) {
            unlink($imagen_path);
        }

        return redirect()->route('posts.index', [
            'user' => auth()->user()
        ]);
    }
}
