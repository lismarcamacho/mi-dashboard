@extends('adminlte::page') {{-- Asumiendo que estás usando AdminLTE --}}
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Perfil de usuario...</h4>
@stop

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Utiliza el método PUT para la actualización --}}

                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                </div>

                {{-- Agrega aquí más campos para los atributos del usuario que quieras editar --}}

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Tus estilos CSS opcionales --}}
@stop

@section('js')
    {{-- Tu JavaScript opcional --}}
@stop