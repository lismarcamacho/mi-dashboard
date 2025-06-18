@extends('adminlte::page')

@section('title', 'Detalles de Sección: ' . $seccion->nombre)

@section('content_header')
    <h1 class="m-0 text-dark">Detalles de Sección: {{ $seccion->nombre }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Información General de la Sección</h3>
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $seccion->id }}</p>
                    <p><strong>Nombre de Sección:</strong> {{ $seccion->nombre }}</p>
                    <p><strong>Capacidad Máxima:</strong> {{ $seccion->capacidad_maxima }}</p>
                {{--    <p><strong>Fecha de Creación:</strong> {{ $seccion->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Última Actualización:</strong> {{ $seccion->updated_at->format('d/m/Y H:i') }}</p> --}}
                </div>
                <div class="card-footer">
                    <a href="{{ route('secciones.edit', $seccion) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Sección
                    </a>
                    <a href="{{ route('secciones.index') }}" class="btn btn-default float-right">
                        <i class="fas fa-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">Estudiantes Matriculados en esta Sección (Estado Activo)</h3>
                </div>
                <div class="card-body">
                    @if ($seccion->matriculas->where('estado', 'Activo')->count() > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Cédula</th>
                                    <th>Estudiante</th>
                                    <th>Programa</th>
                                    <th>Periodo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($seccion->matriculas->where('estado', 'Activo') as $matricula)
                                    <tr>
                                        <td>{{ $matricula->estudiante->cedula ?? 'N/A' }}</td>
                                        <td>{{ $matricula->estudiante->apellidos_nombres ?? 'N/A' }}</td>
                                        <td>{{ $matricula->programa->nombre_programa ?? 'N/A' }}</td>
                                        <td>{{ $matricula->periodo_academico }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No hay estudiantes activos matriculados en esta sección.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop