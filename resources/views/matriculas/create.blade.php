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

    {{-- Preparar variables para la precarga del Select2.
         Asegúrate de que $matricula esté definido en tu controlador (para edición).
         Para la creación, $matricula probablemente será nulo, por lo que usamos '?? null'. --}}
    @php
        // Aseguramos que $matricula siempre sea un objeto o null para evitar errores de acceso a propiedades en el @php block
        $matricula = $matricula ?? null;

        // Inicializamos las variables con valores por defecto para que siempre estén definidas
        $selectedEstudianteId = old('estudiante_id', $matricula->estudiante_id ?? null);
        $selectedEstudianteText = '';

        // Solo intenta obtener el texto del estudiante si ya tenemos un ID seleccionado
        // y si $matricula no es nula y tiene una relación 'estudiante'.
        // Esto previene errores en formularios de creación donde $matricula no existe.
        if ($selectedEstudianteId && $matricula && $matricula->estudiante) {
            $selectedEstudianteText =
                $matricula->estudiante->apellidos_nombres . ' (C.I.: ' . $matricula->estudiante->cedula . ')';
        }
        // Si no se carga desde $matricula, pero hay un old('estudiante_id') (ej. error de validación),
        // podrías considerar cómo obtener el texto aquí si es que el frontend no lo maneja
        // Select2 normalmente maneja esto internamente si los datos son pasados correctamente en el AJAX response.
        // La parte clave es que $selectedEstudianteText SIEMPRE DEBE ESTAR DEFINIDA.
    @endphp

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Datos de la Matrícula</h3>
        </div>
        <form action="{{ isset($matricula) ? route('matriculas.update', $matricula->id) : route('matriculas.store') }}"
            method="POST">
            @csrf
            @if (isset($matricula))
                @method('PUT') {{-- Usa PUT para el método update --}}
            @endif
            <div class="card-body">
                <div class="row">
                    {{-- Campo Estudiante con búsqueda remota (Select2 AJAX) - col-md-6 para la columna --}}
                    <!--<div class="form-group col-md-6">
                        <x-adminlte-select2 name="estudiante_id" label="Estudiante" label-class="text-lightblue"
                            data-placeholder="Busque por Cédula o Nombre..." enable-old-support="true" {{-- Configuración para búsqueda AJAX con Select2 --}}
                            data-ajax--url="{ { route('admin.estudiantes.search') }}" data-ajax--cache="true"
                            data-ajax--delay="250" data-ajax--dataType="json" {{-- Atributos de precarga Select2 --}}
                            data-selected="{ { $selectedEstudianteId }}" data-selected-text="{ { $selectedEstudianteText }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user-graduate text-darkblue"></i>
                                </div>
                            </x-slot>
                            {{-- Opción inicial vacía. Select2 AJAX gestionará el resto de opciones y la precarga basada en data-selected. --}}
                            <option value="">Seleccione un estudiante</option>
                        </x-adminlte-select2>
                        @ error('estudiante_id')
                            <span class="text-danger d-block">{ { $message }}</span>
                        @ enderror
                    </div> -->

                    <select class="form-control" id="estudiante_id" name="estudiante_id">
                        <option value="">Busque por Cédula o Nombre...</option>
                    </select>

                    {{-- Campo Período Académico - col-md-6 para la columna --}}
                    <div class="form-group col-md-6">
                        <x-adminlte-input name="periodo_academico" label="Período Académico" label-class="text-lightblue"
                            placeholder="Ej: 2024-II"
                            value="{{ old('periodo_academico', $matricula->periodo_academico ?? '') }}"
                            enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('periodo_academico')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div> {{-- Fin de la primera row --}}

                <div class="row">
                    {{-- Select para Programa (Selección Única) - col-md-6 para la columna --}}
                    <div class="form-group col-md-6">
                        <x-adminlte-select2 name="programa_id" label="Programa" label-class="text-lightblue"
                            igroup-size="md" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-purple">
                                    <i class="fas fa-book"></i>
                                </div>
                            </x-slot>
                            <option value="">Seleccione un programa</option>
                            @foreach ($programas as $programa)
                                <option value="{{ $programa->id }}"
                                    {{ old('programa_id', $matricula->programa_id ?? '') == $programa->id ? 'selected' : '' }}>
                                    {{ $programa->nombre_programa }} ({{ $programa->codigo_programa }})
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                        @error('programa_id')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Select para Sección (Selección Única) - col-md-6 para la columna --}}
                    <div class="form-group col-md-6">
                        <x-adminlte-select2 name="seccion_id" label="Sección" label-class="text-lightblue" igroup-size="md"
                            enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-teal">
                                    <i class="fas fa-users"></i>
                                </div>
                            </x-slot>
                            <option value="">Seleccione una sección</option>
                            @foreach ($secciones as $seccion)
                                <option value="{{ $seccion->id }}"
                                    {{ old('seccion_id', $matricula->seccion_id ?? '') == $seccion->id ? 'selected' : '' }}>
                                    {{ $seccion->nombre }} {{-- Asume que Seccion tiene un campo 'nombre' --}}
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                        @error('seccion_id')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div> {{-- Fin de la segunda row --}}

                <div class="row">
                    {{-- Campo de Fecha de Inscripción - col-md-6 para la columna --}}
                    <div class="form-group col-md-6">
                        <x-adminlte-input name="fecha_inscripcion" label="Fecha Inscripcion" placeholder="YYYY-MM-DD"
                            type="date" label-class="text-lightblue"
                            value="{{ old('fecha_inscripcion', $matricula->fecha_inscripcion ?? '') }}"
                            title="Seleccione o escriba la fecha de la inscripcion." enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('fecha_inscripcion')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Select para Trayecto - col-md-6 para la columna --}}
                    {{-- ESTE CAMPO SE MOVIO PARA QUE ESTÉ EN UNA COLUMNA DE 6 Y ALINEADO CON LA FECHA --}}
                    <div class="form-group col-md-6">
                        <x-adminlte-select2 name="trayecto_id" label="Trayecto" label-class="text-lightblue"
                            igroup-size="md" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-purple">
                                    <i class="fas fa-road"></i> {{-- Se cambió a fas fa-road para trayecto --}}
                                </div>
                            </x-slot>
                            <option value="">Seleccione un Trayecto</option>
                            @foreach ($trayectos as $trayecto)
                                <option value="{{ $trayecto->id }}"
                                    {{ old('trayecto_id', $matricula->trayecto_id ?? '') == $trayecto->id ? 'selected' : '' }}>
                                    {{ $trayecto->numero_orden }} - ({{ $trayecto->nombre_trayecto }})
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                        @error('trayecto_id')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div> {{-- Fin de la tercera row --}}

                <div class="row">
                    {{-- Campo de Condición de Inscripción - col-md-6 para la columna --}}
                    <div class="form-group col-md-6">
                        <x-adminlte-select name="condicion_inscripcion" label="Condición de Inscripción"
                            label-class="text-lightblue" igroup-size="md" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info"> {{-- Color de fondo para el icono --}}
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </x-slot>
                            <option value="">Seleccione el tipo de inscripcion</option>
                            <option value="NORMAL"
                                {{ old('condicion_inscripcion', $matricula->condicion_inscripcion ?? '') == 'NORMAL' ? 'selected' : '' }}>
                                NORMAL</option>
                            <option value="REINGRESO"
                                {{ old('condicion_inscripcion', $matricula->condicion_inscripcion ?? '') == 'REINGRESO' ? 'selected' : '' }}>
                                REINGRESO</option>
                            <option value="PROSECUCION"
                                {{ old('condicion_inscripcion', $matricula->condicion_inscripcion ?? '') == 'PROSECUCION' ? 'selected' : '' }}>
                                PROSECUCION</option>
                            <option value="EQUIVALENCIA"
                                {{ old('condicion_inscripcion', $matricula->condicion_inscripcion ?? '') == 'EQUIVALENCIA' ? 'selected' : '' }}>
                                EQUIVALENCIA</option>
                            <option value="TRASLADO"
                                {{ old('condicion_inscripcion', $matricula->condicion_inscripcion ?? '') == 'TRASLADO' ? 'selected' : '' }}>
                                TRASLADO</option>
                            <option value="NUEVO INGRESO"
                                {{ old('condicion_inscripcion', $matricula->condicion_inscripcion ?? '') == 'NUEVO INGRESO' ? 'selected' : '' }}>
                                NUEVO INGRESO</option>
                        </x-adminlte-select>
                        @error('condicion_inscripcion')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Campo de Condición de Cohorte - col-md-6 para la columna --}}
                    {{-- SE RECOMIENDA EVALUAR LA NECESIDAD DE ESTE CAMPO SI ES REDUNDANTE CON 'CONDICION DE INSCRIPCION' --}}
                    <div class="form-group col-md-6">
                        <x-adminlte-select name="condicion_cohorte" label="Condición de Cohorte" igroup-size="md"
                            enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-orange"> {{-- Otro color para el icono --}}
                                    <i class="fas fa-layer-group"></i>
                                </div>
                            </x-slot>
                            <option value="">Seleccione una opción</option>
                            <option value="I"
                                {{ old('condicion_cohorte', $matricula->condicion_cohorte ?? '') == 'I' ? 'selected' : '' }}>
                                INICIAL</option>
                            <option value="N"
                                {{ old('condicion_cohorte', $matricula->condicion_cohorte ?? '') == 'N' ? 'selected' : '' }}>
                                NORMAL</option>
                            <option value="R"
                                {{ old('condicion_cohorte', $matricula->condicion_cohorte ?? '') == 'R' ? 'selected' : '' }}>
                                REINGRESO</option>
                            <option value="P"
                                {{ old('condicion_cohorte', $matricula->condicion_cohorte ?? '') == 'P' ? 'selected' : '' }}>
                                PROSECUCION</option>
                            <option value="E"
                                {{ old('condicion_cohorte', $matricula->condicion_cohorte ?? '') == 'E' ? 'selected' : '' }}>
                                EQUIVALENCIA</option>
                            <option value="T"
                                {{ old('condicion_cohorte', $matricula->condicion_cohorte ?? '') == 'T' ? 'selected' : '' }}>
                                TRASLADO</option>
                        </x-adminlte-select>
                        @error('condicion_cohorte')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div> {{-- Fin de la cuarta row --}}
            </div> {{-- Fin de card-body --}}

            <div class="card-footer">
                <x-adminlte-button type="submit" label="Guardar Matrícula" theme="success" icon="fas fa-lg fa-save"
                    class="btn-flat" />
                <a href="{{ route('matriculas.index') }}" class="btn btn-default btn-flat float-right">
                    <i class="fas fa-lg fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
@stop

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/admin_custom.css"> {{-- Tu CSS personalizado --}}
@endpush
@push('js')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicialización del Select2 para el campo Estudiante
            $('#estudiante_id').select2({
                placeholder: 'Busque por Cédula o Nombre...', // Texto por defecto
                minimumInputLength: 3, // Cuántos caracteres debe escribir el usuario para iniciar la búsqueda
                language: { // Opcional: Para cambiar los textos a español
                    inputTooShort: function(args) {
                        var remainingChars = args.minimum - args.input.length;
                        return 'Por favor ingrese ' + remainingChars + ' o más caracteres';
                    },
                    noResults: function() {
                        return 'No se encontraron resultados';
                    },
                    searching: function() {
                        return 'Buscando...';
                    },
                    loadingMore: function() {
                        return 'Cargando más resultados...';
                    }
                },
                ajax: {
                    // *** ¡ESTA ES LA URL CORRECTA PARA TU RUTA API! ***
                    url: '{{ route('api.estudiantes.buscar') }}',
                    dataType: 'json',
                    delay: 250, // Pequeña pausa para no hacer peticiones a cada letra
                    data: function (params) {
                        return {
                            q: params.term // El término de búsqueda que Laravel espera como 'q'
                        };
                    },
                    processResults: function (data) {
                        // El controlador debe devolver un array de objetos con 'id' y 'text'
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    </script>

    <script>
        console.log('Hi!'); // Para verificar que tus scripts se están ejecutando
    </script>
@endpush
