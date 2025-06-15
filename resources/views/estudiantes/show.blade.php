@extends('adminlte::page')

@section('title', 'Detalles del Estudiante')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Detalles del Estudiante...</h4>
@stop

@section('content_header')
    <center>
        <h1>Detalles del Estudiante</h1>
    </center>
@stop

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información Personal y de Contacto</h3>
            <div class="card-tools">
                {{-- Botones de acción, por ejemplo, Editar o Volver --}}
                <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Volver a la Lista
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Columna Izquierda (Datos Personales Básicos) --}}
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Cédula:</dt>
                        <dd class="col-sm-8">{{ $estudiante->cedula }}</dd>

                        <dt class="col-sm-4">Apellidos y Nombres:</dt>
                        <dd class="col-sm-8">{{ $estudiante->apellidos_nombres }}</dd>

                        <dt class="col-sm-4">Teléfono:</dt>
                        <dd class="col-sm-8">{{ $estudiante->telefono ?? 'N/A' }}</dd> {{-- Uso ?? 'N/A' para campos nullable --}}

                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $estudiante->email ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Fecha de Nacimiento:</dt>
                        <dd class="col-sm-8">
                            {{ $estudiante->fecha_nacimiento ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                        </dd>





                    </dl>
                </div>

                {{-- Columna Derecha (Datos de Ubicación e Institucionales) --}}
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Sede:</dt>
                        <dd class="col-sm-8">{{ $estudiante->sede ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Municipio:</dt>
                        <dd class="col-sm-8">{{ $estudiante->municipio ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Parroquia:</dt>
                        <dd class="col-sm-8">{{ $estudiante->parroquia ?? 'N/A' }}</dd>



                        <dt class="col-sm-4">Estatus Activo:</dt>
                        <dd class="col-sm-8">
                            @if ($estudiante->estatus_activo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Creado el:</dt>
                        <dd class="col-sm-8">
                            {{ $estudiante->created_at ? $estudiante->created_at->format('d/m/Y H:i') : 'N/A' }}</dd>

                        <dt class="col-sm-4">Última Actualización:</dt>
                        <dd class="col-sm-8">
                            {{ $estudiante->updated_at ? $estudiante->updated_at->format('d/m/Y H:i') : 'N/A' }}</dd>
                    </dl>
                </div>
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
