@extends('adminlte::page')

@section('title', 'Crear Carrera')


@section('content_header')
    <h1>Agregar Nueva Carrera</h1>
@stop

@section('content')
    <form action="{{ route('carreras.store') }}" method="POST">
        @csrf
            <div class="mb-3">
            <label for="nombre" class="form-label">Codigo:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
            <div class="mb-3">
            <label for="nombre" class="form-label">Titulo a obtener:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        </div>
            <div class="mb-3">
            <label for="nombre" class="form-label">Duración por ti
                tulo:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
        </div>

        
        <button type="submit" class="btn btn-primary">Guardar Carrera</button>
        <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Cancelar</a>



        
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop