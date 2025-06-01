@extends('adminlte::page') {{-- Asumiendo que estás usando AdminLTE --}}
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Editar Perfil de Usuario...</h4>
@stop

@section('title', 'Editar Perfil de Usuario')

@section('content_header')
    <h1 style="text-align: center;">Editar Perfil de Usuario</h1>
@stop

@section('content')
    <div class="card">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!--<p> Modificando Tu Perfil: <b> {{ Auth::User()->name }} </b></p> -->
        <div class="card-body">
            <form action="{{ route('profile.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Utiliza el método PUT para la actualización --}}

                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::User()->name }} ">
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ Auth::User()->email }} ">
                </div>    

                

                {{-- Agrega aquí más campos para los atributos del usuario que quieras editar --}}

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('profile.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Tus estilos CSS opcionales --}}
        <style>
        .card{
                margin-right: 60%;
                margin: auto; /* Añade margen arriba y abajo, y centra horizontalmente */
                max-width: 600px; /* O el ancho máximo que desees para el contenedor */
                width: 90%; /* O un porcentaje del ancho para hacerlo responsivo */
                
        }

        .card-body {
            width: 400px ; /* Se ajusta al contenido */
            /* O puedes usar un ancho específico basado en el input más ancho */
            /* width: 400px;  */
            margin: 0em; /* Para centrar el formulario si es necesario */
            margin-bottom: 0px;
            margin-left: 20%;
            margin-right: 20%;
        }

        .form-group {
            margin-bottom: 18px; /* Reduce el margen inferior del grupo */
        }

        .form-group label {
            display: block;
            margin-bottom: 2px; /* Reduce el margen inferior de la etiqueta */
        }


        
        .form-label {
            width: auto;
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-control {
            width: 300px; /* Ajusta este valor para el ancho deseado */
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .btn-primary, .btn-secondary {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .mb-3 {
            margin-bottom: 1rem;
        }
    </style>
@stop

@section('js')
    {{-- Tu JavaScript opcional --}}
@stop