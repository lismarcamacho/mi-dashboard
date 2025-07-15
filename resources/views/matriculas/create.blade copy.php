{{-- resources/views/matriculas/create.blade.php --}}
@extends('adminlte::page')

@section('title', 'Crear Matrícula Simplificada')
{{-- Preloader personalizado de AdminLTE --}}
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nueva Matrícula ...</h4>
@stop
@section('content_header')
    <h1>Crear Nueva Matrícula (Versión Simplificada)</h1>
@stop

@section('content')


    {{-- Notificación de éxito si viene de la sesión --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- AÑADIR ESTE BLOQUE PARA MOSTRAR MENSAJES DE ERROR DE SESIÓN --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    {{-- FIN DEL BLOQUE AÑADIDO --}}

    {{-- Mensajes de error de validación globales (opcional, si no usas @error en cada campo) --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Datos de la Matrícula</h3>
        </div>
        <form action="{{ route('matriculas.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row"> {{-- Abre una nueva fila para las dos columnas --}}

                    <div class="col-md-6"> {{-- Columna izquierda (para datos personales, etc.) --}
                            {{-- Campo de búsqueda de Estudiante por Cédula (Input de texto) --}}
                        {{-- Campo Estudiante con búsqueda remota (Select2 AJAX) --}}
               {{-- Campo Estudiante con búsqueda remota (Select2 AJAX) --}}
                <div class="form-group col-md-6">
                    <x-adminlte-select2 name="estudiante_id" label="Estudiante" label-class="text-lightblue"
                        data-placeholder="Busque por Cédula o Nombre..." enable-old-support="true"
                        {{-- Configuración para búsqueda AJAX con Select2 --}}
                        data-ajax--url="{{ route('api.estudiantes.search') }}"
                        data-ajax--cache="true"
                        data-ajax--delay="250"
                        data-ajax--dataType="json"
                        {{-- Atributos de precarga Select2 --}}
                        data-selected="{{ $selectedEstudianteId }}"
                        data-selected-text="{{ $selectedEstudianteText }}"
                        >
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-user-graduate text-darkblue"></i>
                            </div>
                        </x-slot>
                        {{-- Opción inicial vacía. Select2 AJAX gestionará el resto de opciones y la precarga basada en data-selected. --}}
                        <option value="">Seleccione un estudiante</option>
                    </x-adminlte-select2>
                    @error('estudiante_id')
                        <span class="text-danger d-block">{{ $message }}</span>
                    @enderror
                </div>

                        {{-- Select para Estudiante (Selección Única) --}}
                        <div class="form-group">
                            <x-adminlte-select2 name="estudiante_id" label="Estudiante" label-class="text-lightblue"
                                igroup-size="md">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-blue">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                </x-slot>
                                <option value="">Seleccione un estudiante</option>
                                @foreach ($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}"
                                        {{ old('estudiante_id') == $estudiante->id ? 'selected' : '' }}>
                                        {{ $estudiante->apellidos_nombres }} (C.I: {{ $estudiante->cedula }})
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                            @error('estudiante_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Select para Programa (Selección Única) --}}
                        <div class="form-group">
                            <x-adminlte-select2 name="programa_id" label="Programa" label-class="text-lightblue"
                                igroup-size="md">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-purple">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </x-slot>
                                <option value="">Seleccione un programa</option>
                                @foreach ($programas as $programa)
                                    <option value="{{ $programa->id }}"
                                        {{ old('programa_id') == $programa->id ? 'selected' : '' }}>
                                        {{ $programa->nombre_programa }} ({{ $programa->codigo_programa }})
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                            @error('programa_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Select para Sección (Selección Única) --}}
                        <div class="form-group">
                            <x-adminlte-select2 name="seccion_id" label="Sección" label-class="text-lightblue"
                                igroup-size="md">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-teal">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </x-slot>
                                <option value="">Seleccione una sección</option>
                                @foreach ($secciones as $seccion)
                                    <option value="{{ $seccion->id }}"
                                        {{ old('seccion_id') == $seccion->id ? 'selected' : '' }}>
                                        {{ $seccion->nombre }} {{-- Asume que Seccion tiene un campo 'nombre' --}}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                            @error('seccion_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Campo de Fecha de Inscripción --}}
                        <div class="form-group">
                            <x-adminlte-input name="fecha_inscripcion" label="Fecha Inscripcion" placeholder="YYYY-MM-DD"
                                type="date" label-class="text-lightblue" value="{{ old('fecha_inscripcion') }}"
                                title="Seleccione o escriba la fecha de la inscripcion.">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-info">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('fecha_inscripcion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="col-md-6"> {{-- Columna derecha  --}


                         {{-- Otros campos --}}
                        <div class="form-group">
                            <x-adminlte-input name="periodo_academico" label="Período Académico" placeholder="Ej: 2024-II"
                                value="{{ old('periodo_academico') }}" enable-old-support="true" />
                            @error('periodo_academico')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>




                        <div class="form-group">
                            <x-adminlte-select2 name="trayecto_id" label="Trayecto" label-class="text-lightblue"
                                igroup-size="md">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-purple">
                                        <i class="fas fa-book"></i>
                                    </div>
                                </x-slot>
                                <option value="">Seleccione un Trayecto</option>
                                @foreach ($trayectos as $trayecto)
                                    <option value="{{ $trayecto->id }}"
                                        {{ old('trayecto_id') == $programa->id ? 'selected' : '' }}>
                                        {{ $trayecto->numero_orden }} - ({{ $trayecto->nombre_trayecto }})
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                            @error('trayecto_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="form-group">

                            <x-adminlte-select name="condicion_inscripcion" label="Condición de Inscripcion"
                                igroup-size="md">
                                <option value="">Seleccione el tipo de inscripcion</option> {{-- Añadido para una mejor UX --}}
                                <option value="NR" {{ old('condicion_inscripcion') == 'NR' ? 'selected' : '' }}>NORMAL
                                    REGULAR</option>
                                <option value="RP" {{ old('condicion_inscripcion') == 'RP' ? 'selected' : '' }}>
                                    REPITIENTE</option>
                                <option value="IN" {{ old('condicion_inscripcion') == 'IN' ? 'selected' : '' }}>
                                    INTENSIVO</option>
                                <option value="TR" {{ old('condicion_inscripcion') == 'TR' ? 'selected' : '' }}>
                                    TUTORIA
                                </option>
                                <option value="PER" {{ old('condicion_inscripcion') == 'PER' ? 'selected' : '' }}>PER
                                </option>
                            </x-adminlte-select>
                            @error('condicion_inscripcion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>





                        <div class="form-group">
                            <x-adminlte-select name="condicion_cohorte" label="Condición de Cohorte" igroup-size="md">
                                {{-- Opción por defecto o placeholder --}}
                                <option value="">Seleccione una opción</option> {{-- Añadido para una mejor UX --}}

                                {{-- Opciones con valor de una letra y lógica para recordar la selección --}}
                                <option value="I" {{ old('condicion_inscripcion') == 'I' ? 'selected' : '' }}>INICIAL
                                </option>
                                <option value="N" {{ old('condicion_cohorte') == 'N' ? 'selected' : '' }}>NORMAL
                                </option>
                                <option value="R" {{ old('condicion_cohorte') == 'R' ? 'selected' : '' }}>REINGRESO
                                </option>
                                <option value="P" {{ old('condicion_cohorte') == 'P' ? 'selected' : '' }}>PROSECUCION
                                </option>
                                <option value="E" {{ old('condicion_cohorte') == 'E' ? 'selected' : '' }}>
                                    EQUIVALENCIA
                                </option>
                                <option value="T" {{ old('condicion_cohorte') == 'T' ? 'selected' : '' }}>TRASLADO
                                </option>
                            </x-adminlte-select>
                            @error('condicion_cohorte')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>



            </div>
            <div class="card-footer">
                <x-adminlte-button type="submit" label="Guardar Matrícula" theme="primary" icon="fas fa-save" />
                <a href="{{ route('matriculas.index') }}" class="btn btn-default">Cancelar</a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Script para el datepicker
            $('input[name="fecha_inscripcion"]').datepicker({
                dateFormat: 'dd/mm/yy', // Formato visual y de envío
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0'
            });
        });
    </script>
@stop
