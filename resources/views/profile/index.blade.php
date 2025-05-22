<!-- users/index.blade.php -->
@extends('adminlte::page')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Perfil de usuario...</h4>
@stop
@section('title', 'Perfil de Usuario'){{-- o el layout de AdminLTE que estés usando --}}

@section('content_header')

@stop

@section('content')
<div class="container" style="margin-top: 10%; background-color: #fff; box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1rem;">
    <h3 tyle="margin-top: 10%; " >Lista de Carreras Creadas</h3>
    <!-- <a href="{{ route('users.create') }}" class="btn btn-primary"></a>-->
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    <table class="table">
        
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        
        <br>
        <tbody>
      
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
                <td>
                    
                </td>
            </tr>
       
        </tbody>
    </table>
</div>



<div class="container" style="background-color: #fff; box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1rem;">
    <h3>Lista de Usuarios Registrados</h3>
    <a href="{{ route('users.create') }}" class="btn btn-primary" >Crear Nuevo</a>
   
            <!--<div class="alert alert-success"></div>-->

    <table class="table">
        <thead>
              <!--@ foreach ($users as $user)-->
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
              <!--@ endforeach-->

        </thead>
        <br>
        <tbody>
      
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
                <td>
                    
                </td>
            </tr>
       
        </tbody>
    </table>
    
</div>
@endsection

<!--<div class="max-w-7xlw mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            @ include('profile.update-profile-information-form')

        </div>
    </div>



    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            @ include('profile.delete-user-form')

        </div>
    </div>



</div>
-->

@section('css')
    {{-- Tus estilos CSS opcionales --}}
        <style>
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            margin-left: 65%;
            margin-top:-5%;

        }
        </style>
@stop

@section('js')
    {{-- Tu JavaScript opcional --}}
@stop