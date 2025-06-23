@extends('adminlte::page')

@section('title', 'Detalles de matricula: ' . $matricula->id)

@section('content_header')
    <h1 class="m-0 text-dark">Detalles de matricula: {{ $matricula->id }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Información General de la matricula</h3>
                </div>
                <div class="card-body">
           <dl class="row">
                <dt class="col-sm-4">ID de Matrícula:</dt>
                <dd class="col-sm-8">{{ $matricula->id }}</dd>

                <dt class="col-sm-4">Estudiante:</dt>
                <dd class="col-sm-8">
                    @if ($matricula->estudiante) {{-- Usamos la relación singular 'estudiante' --}}
                        {{ $matricula->estudiante->nombre }} {{ $matricula->estudiante->apellido }} (C.I: {{ $matricula->estudiante->cedula }})
                    @else
                        N/A
                    @endif
                </dd>

                <dt class="col-sm-4">Programa:</dt>
                <dd class="col-sm-8">
                    @if ($matricula->programa) {{-- Usamos la relación singular 'programa' --}}
                        {{ $matricula->programa->nombre_pr }} ({{ $matricula->programa->codigo_pr }})
                    @else
                        N/A
                    @endif
                </dd>

                <dt class="col-sm-4">Sección:</dt>
                <dd class="col-sm-8">
                    @if ($matricula->seccion) {{-- Usamos la relación singular 'seccion' --}}
                        {{ $matricula->seccion->codigo_sec }} {{-- Ajusta el campo real de tu sección --}}
                    @else
                        N/A
                    @endif
                </dd>

                <dt class="col-sm-4">Trayecto:</dt>
                <dd class="col-sm-8">
                    @if ($matricula->trayecto) {{-- Usamos la relación singular 'trayecto' --}}
                        {{ $matricula->trayecto->nombre_trayecto }} {{-- Ajusta el campo real de tu trayecto --}}
                    @else
                        N/A
                    @endif
                </dd>

                <dt class="col-sm-4">Fecha de Inscripción:</dt>
                <dd class="col-sm-8">
                    {{-- Accedemos directamente a la propiedad de la matrícula y la formateamos --}}
                    @if ($matricula->fecha_inscripcion)
                        {{ $matricula->fecha_inscripcion->format('d/m/Y') }}
                    @else
                        N/A
                    @endif
                </dd>

                <dt class="col-sm-4">Período Académico:</dt>
                <dd class="col-sm-8">{{ $matricula->periodo_academico }}</dd>

                <dt class="col-sm-4">Condición de Inscripción:</dt>
                <dd class="col-sm-8">{{ $matricula->condicion_inscripcion }}</dd>

                <dt class="col-sm-4">Condición de Cohorte:</dt>
                <dd class="col-sm-8">{{ $matricula->condicion_cohorte }}</dd>

                <dt class="col-sm-4">Creado el:</dt>
                <dd class="col-sm-8">{{ $matricula->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-4">Última Actualización:</dt>
                <dd class="col-sm-8">{{ $matricula->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('matriculas.edit', $matricula) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Sección
                    </a>
                    <a href="{{ route('matriculas.index') }}" class="btn btn-default float-right">
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