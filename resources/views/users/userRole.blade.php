@extends('adminlte::page')
{{-- ESTA VISTA ES PARA EDITAR LOS ROLES Y PERMISOS --}}
@section('title', 'Administracion de Usuarios y Roles')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Usuarios y Roles..</h4>
@stop

@section('content_header')
    <h1>Administracion de Usuarios y Roles</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <p> Editar los roles del Usuario: {{ $user->name }}</p>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        </div>
        <div class="card-body">

            {{-- {{$permisos}}  --}} {{-- Verificamos que podemos acceder a la tabla de los permisos --}}
            <form action="{{ route('asignar.update', $user->id) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->


                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->


                {{-- With prepend slot --}}
                <div>
                    <label class="block font-medium text-sm text-gray-700">
                        <h2>Roles:</h2>
                    </label>
                    <div class="mt-2 space-y-2">
                        {{-- {{ dd($role) }}  --}}
                        {{--  {{ dd($user->roles) }}  --}}
                      {{--  @foreach ($roles as $role)
                            <div class="flex items-center">
                                <input id="role_{{ $role->id }}" name="roles[]" type="checkbox"
                                    value="{{ $role->id }}"
                                    class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out"
                                    {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                <label for="role_{{ $role->id }}" class="ml-2 block text-sm text-gray-900">
                                    {{ $role->name }}
                                </label>

                            </div>
                        @endforeach --}}

                        @foreach ($roles as $role)
                            <div>
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                <label for="{{ $role->name }}">{{ ucfirst($role->name) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>


                <button type="submit" class="btn btn-primary" id="Edit">Asignar Roles</button>
                <a href="{{ route('asignar.index') }}" class="btn btn-secondary">Atrás</a>
            </form>




        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hola! ");
    </script>
@stop
