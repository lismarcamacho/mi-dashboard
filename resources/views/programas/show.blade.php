@extends('adminlte::page')

@section('title', 'Detalles del Programa')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Detalles del Programa...</h4>
@stop

@section('content_header')
    <center>
        <h1>Detalles del Programa</h1>
    </center>
@stop

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de programas</h3>
            <div class="card-tools">
                {{-- Botones de acción, por ejemplo, Editar o Volver --}}
                <a href="{{ route('programas.edit', $programa->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('programas.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Volver a la Lista
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Columna Izquierda (Datos Personales Básicos) --}}
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Codigo</dt>
                        <dd class="col-sm-8">{{ $programa->codigo_programa }}</dd>

                        <dt class="col-sm-4"> Nombre:</dt>
                        <dd class="col-sm-8">{{ $programa->nombre_programa }}</dd>

                       


                        <dt class="col-sm-4">Fecha del Programa:</dt>
                        <dd class="col-sm-8">
                            {{ $programa->fecha_programa ? \Carbon\Carbon::parse($programa->fecha_programa)->format('d/m/Y') : 'N/A' }}
                        </dd>
                         <dt class="col-sm-4">Descripcion</dt>
                     
                        <dd class="col-sm-8">{{ $programa->descripcion }}</dd>
                        





                    </dl>
                </div>

                {{-- Columna Derecha (Datos de Ubicación e Institucionales) --}}
         
            </div> {{-- Fin de la fila de detalles --}}
        </div> {{-- Fin card-body --}}
    </div> {{-- Fin card --}}

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    {{-- Agrega cualquier CSS adicional si es necesario --}}
@stop

@section('js')
    <script>
        console.log('Vista de detalles del estudiante cargada!');
    </script>
@stop
