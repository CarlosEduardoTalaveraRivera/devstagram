<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . '.' . $imagen->extension();

        $imagenServidor = Image::read($imagen);
        $imagenServidor->cover(1000, 1000);

        if (!File::isDirectory(public_path('uploads'))) {
            File::makeDirectory(public_path('uploads'), 0644);
        }

        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
