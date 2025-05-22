@extends('adminlte::page')

@section('title', 'Lista de Carrera')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Carreras..</h4>
@stop
@section('content')
    <h1>lista de carreras</h1>
@stop

@section('content')
<div class="container" style="margin-top: 10%; background-color: #fff; box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1rem;">
    <h3 tyle="margin-top: 10%; " >Perfil de Usuario Autenticado</h3>
    <!-- <a href="{{ route('carreras.create') }}" class="btn btn-primary"></a>-->
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    <table class="table">
        
            <tr>
                <th>ID</th>
                <th>Codigo Carrera</th>
                <th>Nombre carrera</th>
                <th>Titulo</th>
                <th> Duracion por Titulo</th>
                <th> Descripcion</th>
            </tr>
        
        <br>
            
        <tbody>
                @foreach ($carreras as $carrera)
                    <tr>
                        <td>{{ $carrera->id }}</td>
                        <td>{{ $carrera->codigo_carrera }}</td>
                        <td>{{ $carrera->nombre_carrera }}</td>
                        <td>{{ $carrera->titulo }}</td>
                        <td>{{ $carrera->duracion_x_titulo }}</td>
                    </tr>
                @endforeach
            </tbody>
                    <a href="{{ route('carreras.edit', $carrera->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('carreras.destroy', $carrera->id) }}" method="POST" class="d-inline">
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