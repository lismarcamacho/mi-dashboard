@extends('adminlte::page')

@section('title', 'Lista de Especialiadades')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Especialidades..</h4>
@stop


@section('content_header')
    <center><h1>Lista de Especialidades</h1></center>
@stop

@section('content')
<div class="container" style="margin-top: 3%; background-color: #fff; box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1rem;">
    <center><h3 tyle="margin-top: 10%; " ></h3></center>

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    <table class="table">
        
            <tr>
                <th>ID</th>
                <th>Codigo Especialidad</th>
                <th>Nombre Especialidad</th>
                <th>Titulo</th>
                <th>Duracion por Titulo</th>
                <th>Descripcion</th>
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
                        <td>{{ $carrera->descripcion }}</td>

                    </tr>
                @endforeach
            </tbody>
                    <div class="botones">
                    <a href="{{ route('carreras.create') }}" class="btn btn-primary ml-2"> Agregar</a>
                    <a href="{{ route('carreras.edit', $carrera->id) }}" class="btn btn-warning ml-2">Editar</a>
                    <form action="{{ route('carreras.destroy', $carrera->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger ml-2">Eliminar</button>


                    </div>
                        <div id="buscar" style="display: flex; align-items: center; margin-top:-7%" class=" ml-4">
                        <x-adminlte-input name="iSearch" label="Busqueda por codigo o Nombre de Especialidad" placeholder="busqueda" igroup-size="md-8">
                            <x-slot name="appendSlot">
                                <x-adminlte-button theme="outline-danger" label="buscar"/>
                            </x-slot>
                            <x-slot name="prependSlot">
                                <div class="input-group-text text-danger">
                                    <i class="fas fa-search"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>

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


/* Estilos para el tema oscuro */
        body.dark-theme .element.style,
        [data-theme="dark"] .element.style {
            color: white;
            background-color: #333; /* Un gris oscuro */
            border-color: #555;
        }


        .botones {

            margin-left: 70%;
            margin-top:1%;
            margin-block-end: inherit;

            
        }

        .form-group {

        }

        .buscar{
            margin-top:-5%;
        }
    

        </style>
@stop

@section('js')
    {{-- Tu JavaScript opcional --}}
@stop