@extends('layouts.app')

@section('titulo', 'Página Principal')

@section('contenido')
    <x-listar-post :posts="$posts" />
@endsection
