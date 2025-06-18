@extends('adminlte::page')

@section('title', 'Detalles del Programa')
@section('page_title', 'Detalle del Programa')
@section('breadcrumb_item', 'Detalle')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Detalles del Programa...</h4>
@stop

@section('content_header')
    <center>
        <h4>Detalle del Programa: {{ $programa->nombre_programa }}</h4>
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
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Código:</strong> {{ $programa->codigo_programa }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> {{ $programa->nombre_programa }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Fecha del Programa:</strong>
                                {{ \Carbon\Carbon::parse($programa->fecha_programa)->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Descripción:</strong> {{ $programa->descripcion }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Especialidades Asociadas:</h5>
                            @forelse ($programa->especialidades as $especialidad)
                                <span class="badge badge-primary mr-1">{{ $especialidad->nombre_especialidad }}</span>
                            @empty
                                <p class="text-muted">Este programa no tiene especialidades asociadas.</p>
                            @endforelse
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Creado el:</strong> {{ $programa->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Última Actualización:</strong> {{ $programa->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
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
