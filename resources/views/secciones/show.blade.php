{{-- resources/views/secciones/show.blade.php --}}
@extends('adminlte::page')

@section('title', 'Detalles de Sección')

@section('content_header')
    <h1>Detalles de Sección: {{ $seccion->nombre ?? 'N/A' }}</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Información de la Sección</h3>
                </div>
                <div class="card-body">
                    <p><strong>ID de Sección:</strong> {{ $seccion->id }}</p>
                    <p><strong>Nombre de Sección:</strong> {{ $seccion->nombre ?? 'N/A' }}</p>
                    {{-- Puedes añadir más detalles de la sección aquí si los tienes --}}

                    <a href="{{ route('secciones.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver al Listado de Secciones</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">Estudiantes Matriculados en esta Sección (Estado Activo)</h3>
                </div>
                <div class="card-body">
                    @php
                        $estudiantesActivosEnSeccion = collect(); // Inicializa como colección vacía

                        if (isset($seccion) && $seccion && $seccion->matriculas) {
                            $estudiantesActivosEnSeccion = $seccion->matriculas->filter(function ($matriculaSeccion) {
                                // CAMBIO CLAVE 1:
                                // 'estatus_activo' se casteó a booleano en el modelo, así que compara con 'true'.
                                // Se usa 'STATUS_ACTIVO' si ese es el nombre real de la columna en la BD.
                                return $matriculaSeccion->estudiante && $matriculaSeccion->estudiante->estatus_activo === true;
                            });
                        }
                    @endphp

                    @if ($estudiantesActivosEnSeccion->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>C.I.</th>
                                    <th>Apellidos y Nombres</th> {{-- El encabezado está bien --}}
                                    <th>Condición de Inscripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estudiantesActivosEnSeccion as $matriculaSeccion)
                                    <tr>
                                        <td>{{ $matriculaSeccion->estudiante->cedula ?? 'N/A' }}</td>
                                        {{-- CAMBIO CLAVE 2: --}}
                                        {{-- Usa la columna 'apellidos_nombres' tal como está en el modelo Estudiante --}}
                                        <td>{{ $matriculaSeccion->estudiante->apellidos_nombres ?? 'N/A' }}</td>
                                        <td>{{ $matriculaSeccion->condicion_inscripcion ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay estudiantes activos matriculados en esta sección.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    {{-- JS específico para esta vista --}}
@stop