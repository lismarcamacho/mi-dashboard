@extends('adminlte::page')
{{-- ESTA VISTA ES PARA EDITAR LOS ROLES Y PERMISOS --}}
@section('title', 'Roles y Permisos')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Roles y Permisos..</h4>
@stop

@section('content_header')
    <h1>Roles y Permisos</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <p> Editar los permisos del Rol: {{ $role->name }}</p>
            
            @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        </div>
        <div class="card-body">

            {{-- {{$permisos}}  --}} {{-- Verificamos que podemos acceder a la tabla de los permisos --}}
            <form action="{{ route('roles.update', $role->id) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->


                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->


                {{-- With prepend slot --}}
                <div>
                    <label class="block font-medium text-sm text-gray-700"><h2>Permisos:</h2></label>
                    <div class="mt-2 space-y-2">
                           {{--{{ dd($role) }}  --}}
                           {{--{{ {{dd($role->permissions)}}  --}}
                        @foreach ($permisos as $permission)
                            <div class="flex items-center">
                                <input id="permission_{{ $permission->id }}" name="permissions[]" type="checkbox"
                                    value="{{ $permission->id }}"
                                    class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out"
                                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                <label for="permission_{{ $permission->id }}" class="ml-2 block text-sm text-gray-900">
                                    {{ $permission->name }}
                                </label>

                            </div>
                        @endforeach
                    </div>
                </div>


                <button type="submit" class="btn btn-primary" id="Edit">Actualizar permisos</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
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
