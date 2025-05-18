<!-- users/index.blade.php -->
@extends('adminlte::page')

@section('title', 'Perfil de Usuario'){{-- o el layout de AdminLTE que estés usando --}}

@section('content')
<div class="container">
    <h1>Usuarios</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Crear Nuevo</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
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
            </tr>
       
        </tbody>
    </table>
</div>
@endsection