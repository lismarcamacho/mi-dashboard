<!-- users/index.blade.php -->
@extends('adminlte::page')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Perfil de usuario...</h4>
@stop
@section('content')


@section('title', 'Perfil de Usuario'){{-- o el layout de AdminLTE que estés usando --}}
    <div class="container">
        <h1>Cambiar Clave de usuario</h1>

                    <!--@ if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @ foreach ($errors->all() as $error)
                                    <li>{ { $error }}</li>
                                @ endforeach
                            </ul>
                        </div>
                    @ endif-->

        <form method="POST" action="{{ route('profile.cambiarClave') }}">
            @csrf

            <div class="mb-3">
                <label for="current_password" class="form-label">Contraseña Actual</label>
                <input type="password" class="form-control" id="current_password" name="current_password">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
            <a href="{{ route('profile.index') }}" class="btn btn-secondary">Cancelar</a>

            @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
        </form>
    </div>
@endsection
