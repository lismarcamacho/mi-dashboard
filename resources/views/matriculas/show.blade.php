{{-- resources/views/matriculas/show.blade.php --}}
@extends('adminlte::page') {{-- Extiende la plantilla base de AdminLTE --}}

@section('title', 'Detalles de Matrícula') {{-- Título de la página --}}

@section('content_header')
    {{-- Encabezado de la sección, típico de AdminLTE --}}
    <h1>Detalles de Matrícula</h1>
@stop

@section('content')
    {{-- Sección de Mensajes (opcional, para notificaciones de éxito/error) --}}
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
        <div class="col-md-12"> {{-- Ajustado a col-md-12 ya que la otra columna se mueve --}}
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Información General de la Matrícula</h3>
                </div>
                <div class="card-body">
                    <p><strong>ID de Matrícula:</strong> {{ $matricula->id }}</p>
                    <p><strong>Estudiante:</strong> (C.I: {{ $matricula->estudiante->cedula ?? 'N/A' }}) - {{ $matricula->estudiante->apellidos_nombres ?? 'N/A' }} </p>
                    <p><strong>Programa:</strong> {{ $matricula->programa->nombre_programa ?? 'N/A' }} ({{ $matricula->programa->codigo_programa ?? 'N/A' }}) - {{ $matricula->programa->descripcion ?? '' }}</p>
                    <p><strong>Sección:</strong> {{ $matricula->seccion->nombre ?? 'N/A' }}</p>
                    <p><strong>Trayecto:</strong> {{ $matricula->trayecto->nombre_trayecto ?? 'N/A' }}</p>
                    <p><strong>Fecha de Inscripción:</strong> {{ $matricula->fecha_inscripcion ? \Carbon\Carbon::parse($matricula->fecha_inscripcion)->format('d/m/Y') : 'N/A' }}</p>
                    <p><strong>Período Académico:</strong> {{ $matricula->periodo_academico ?? 'N/A' }}</p>
                    <p><strong>Condición de Inscripción:</strong> {{ $matricula->condicion_inscripcion ?? 'N/A' }}</p>
                    <p><strong>Condición de Cohorte:</strong> {{ $matricula->condicion_cohorte ?? 'N/A' }}</p>
                    <p><strong>Creado el:</strong> {{ $matricula->created_at ? \Carbon\Carbon::parse($matricula->created_at)->format('d/m/Y H:i') : 'N/A' }}</p>
                    <p><strong>Última Actualización:</strong> {{ $matricula->updated_at ? \Carbon\Carbon::parse($matricula->updated_at)->format('d/m/Y H:i') : 'N/A' }}</p>

                    <a href="{{ route('matriculas.edit', $matricula->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Editar Matrícula</a>
                    <a href="{{ route('matriculas.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver al Listado</a>
                </div>
            </div>
        </div>
    </div>

@stop
