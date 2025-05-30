<!-- users/index.blade.php -->
@extends('adminlte::page')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Perfil de usuario...</h4>
@stop



@section('content')

@section('content_header')
  
    <h1 style="text-align: center;">Cambiar Clave de Usuario</h1>

@stop

@section('title', 'Cambiar Clave de Usuario'){{-- o el layout de AdminLTE que estés usando --}}
    <div class="container">
        <div class="card">
            <div class="card-body">
                    <!--<h3>Cambiar Clave de usuario</h3> -->

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                <form method="POST" action="{{ route('profile.cambiarClave') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Clave Actual</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirmation')">Mostrar</button>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Clave</label>
                        <input type="password" class="form-control" id="password" name="password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirmation')">Mostrar</button>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Nueva Clave</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirmation')">Mostrar</button>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Clave</button>
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
                            <div class="mt-2">
                <button type="button" class="btn btn-info" onclick="toggleAllPasswords()">Mostrar Todas las Claves</button>
            </div>
            </div>
        </div>
    </div>
@endsection


@push('css')
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

        button.btn.btn-outline-secondary {
            margin-left: 85%;
            margin-top: -18%;
        }
    </style>
@endpush


@push('js')
    <script>
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleButton = passwordInput.nextElementSibling;

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.textContent = "Ocultar";
            } else {
                passwordInput.type = "password";
                toggleButton.textContent = "Mostrar";
            }
        }

        function toggleAllPasswords() {
            const passwordInputs = document.querySelectorAll('input[type="password"]');
            const toggleButtons = document.querySelectorAll('.btn-outline-secondary');
            let show = false;
            if (passwordInputs.length > 0 && passwordInputs[0].type === "password") {
                show = true;
            }

            passwordInputs.forEach(input => {
                input.type = show ? "text" : "password";
            });

            toggleButtons.forEach(button => {
                button.textContent = show ? "Ocultar" : "Mostrar";
            });
        }
    </script>
@endpush