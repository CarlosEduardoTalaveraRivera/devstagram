<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        // Modify request
        $request->request->add(
            [
                'username' => Str::slug($request->username)
            ]
        );

        // Validation
        $request->validate(
            [
                'username' => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20', 'not_in:twitter,editar-perfil']
            ]
        );

        // Check if the user has uploaded a new avatar
        if ($request->imagen) {
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . '.' . $imagen->extension();

            $imagenServidor = Image::read($imagen);
            $imagenServidor->cover(1000, 1000);

            if (!File::isDirectory(public_path('perfiles'))) {
                File::makeDirectory(public_path('perfiles'), 0644);
            }

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        // Save changes
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? $usuario->imagen ?? null;
        $usuario->save();

        // Redirect
        return redirect()->route('posts.index', [
            'user' => $usuario
        ]);

    }
}
