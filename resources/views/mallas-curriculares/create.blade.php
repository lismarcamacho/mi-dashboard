@extends('adminlte::page')

@section('title', 'Agregar Malla Curricular')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nueva Malla Curricular..</h4>
@stop

@section('content_header')
    <center>
        <h1>Agregar Malla Curricular</h1>
    </center>
@stop
{{-- Campos en la tabla mallas_curriculares (Modelo MallaCurricular):
duracion_en_malla: Por ejemplo, "Semestral", "Anual", "Trimestral", "Por Fase".
fase_malla: Por ejemplo, "N/A", "Fase 1", "Fase 2".
tipo_uc_en_malla: Por ejemplo, "Obligatoria", "Electiva", "Requisito".
Lógica: Estos campos en la tabla mallas_curriculares se refieren a las
características GENERALES o PREDETERMINADAS de la malla curricular como un todo.
Son metadatos sobre la estructura general del plan de estudios. Por ejemplo:

Una Malla Curricular X podría ser un plan de estudios que, por su diseño,
 se cursa de forma "Semestral" en general.
Podría tener una "Fase en Malla" que indica el nivel general o el agrupamiento principal 
de ese plan (aunque tu Excel sugiere que esto es más granular).
Podría indicar el "Tipo UC en Malla" general que predomina en ese pensum 
(ej., la mayoría de sus unidades curriculares son "Obligatorias" por diseño).
Estos campos son útiles para una clasificación de alto nivel de la malla.
 Por ejemplo, al buscar "todas las mallas que son Semestrales" o 
 "todas las mallas con un tipo de UC principal Obligatoria".--}}
@section('content')

    <p>Ingrese la información de la Malla Curricular</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Aquí se mostrarán los errores generales si hay algún problema no relacionado con un campo específico --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h2>Crear Nueva Malla Curricular</h2>

            <form action="{{ route('mallas-curriculares.store') }}" method="POST">
                @csrf

                {{-- Fila 1: Nombre de Malla y Especialidad --}}
                <div class="row">
                    {{-- Campo Nombre de la Malla --}}
                    <div class="col-md-6">
                        <label for="nombre" class="text-lightblue">Nombre Malla:</label>
                        <input type="text" name="nombre" id="nombre"
                            class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo Especialidad --}}
                    <div class="col-md-6">
                        <label for="id_especialidad" class="text-lightblue">Especialidad</label>
                        <select id="id_especialidad" name="id_especialidad"
                            class="form-control @error('id_especialidad') is-invalid @enderror" required>
                            <option value="">Seleccione una Especialidad</option>
                            @foreach ($especialidades as $especialidad)
                                <option value="{{ $especialidad->id }}"
                                    {{ old('id_especialidad') == $especialidad->id ? 'selected' : '' }}>
                                    {{ $especialidad->nombre_especialidad ?? 'ID: ' . $especialidad->id }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_especialidad')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> {{-- Cierre de la Fila 1 --}}

                {{-- Fila Nueva: Campo Programa --}}
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="id_programa" class="text-lightblue">Programa</label>
                        <select name="id_programa" id="id_programa"
                            class="form-control @error('id_programa') is-invalid @enderror" required>
                            <option value="">Seleccione el Programa</option>
                            @foreach ($programas as $programa)
                                <option value="{{ $programa->id }}"
                                    {{ old('id_programa') == $programa->id ? 'selected' : '' }}>
                                    {{ $programa->nombre_programa }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_programa')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- Dejar el col-md-6 de al lado vacío o mover otro campo aquí si quieres --}}
                </div>

                {{-- Fila 2: Créditos en Malla y Trayectos Seleccionados --}}
                <div class="row mt-3"> {{-- mt-3 añade un margen superior para más separación entre filas --}}
                    {{-- Campo Créditos en Malla --}}
                    <div class="col-md-6">
                        <label for="creditos_en_malla" class="text-lightblue">Créditos en Malla:</label>
                        <input type="number" name="creditos_en_malla" id="creditos_en_malla"
                            class="form-control @error('creditos_en_malla') is-invalid @enderror"
                            value="{{ old('creditos_en_malla') }}" step="0.01" required>
                        @error('creditos_en_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo Seleccione uno o más Trayectos --}}
                    <div class="col-md-6">
                        <label for="trayectos_seleccionados" class="text-lightblue">Seleccione uno o más Trayectos</label>
                        <select class="form-control @error('trayectos_seleccionados') is-invalid @enderror"
                            id="trayectos_seleccionados" name="trayectos_seleccionados[]" multiple required>
                            @foreach ($trayectos as $trayecto)
                                <option value="{{ $trayecto->id }}"
                                    {{ in_array($trayecto->id, old('trayectos_seleccionados', [])) ? 'selected' : '' }}>
                                    {{ $trayecto->nombre_trayecto }}
                                </option>
                            @endforeach
                        </select>
                        @error('trayectos_seleccionados')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> {{-- Cierre de la Fila 2 --}}

                {{-- Fila 3: Duración en Malla, Fase en Malla y Tipo de UC en Malla --}}
                <div class="row mt-3"> {{-- mt-3 añade un margen superior --}}
                    {{-- Campo Duración en malla --}}
                    <div class="col-md-6">
                        <label for="duracion_en_malla" class="text-lightblue">Duración en malla</label>
                        <span>
                            <i class="fas fa-info-circle text-blue-500 text-base cursor-help"
                                title="Duración de la malla (ej. Semestral, Anual, Por fases)."></i>
                        </span>
                        <select id="duracion_en_malla" name="duracion_en_malla" class="form-control @error('duracion_en_malla') is-invalid @enderror" required>
                            <option value="">Seleccione la Duración</option>
                            <option value="Semestral" {{ old('duracion_en_malla') == 'Semestral' ? 'selected' : '' }}>Semestral</option>
                            <option value="Trimestral" {{ old('duracion_en_malla') == 'Trimestral' ? 'selected' : '' }}>Trimestral</option>
                            <option value="Anual" {{ old('duracion_en_malla') == 'Anual' ? 'selected' : '' }}>Anual</option>
                            <option value="Por fases" {{ old('duracion_en_malla') == 'Por fases' ? 'selected' : '' }}>Por fases</option>
                        </select>
                        @error('duracion_en_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo Fase en malla --}}
                    <div class="col-md-6">
                        <label for="fase_malla" class="text-lightblue">Fase en malla</label>
                        <span>
                            <i class="fas fa-info-circle text-blue-500 text-base cursor-help"
                                title="Fase específica de la unidad curricular dentro del trayecto (ej. Fase 1, Fase 2). Selecciona el campo vacio, si no aplica."></i>
                        </span>
                        <select id="fase_malla" name="fase_malla" class="form-control @error('fase_malla') is-invalid @enderror">
                            <option value="">Seleccione la Fase</option>
                            <option value="N/A" {{ old('fase_malla') == 'N/A' ? 'selected' : '' }}>N/A</option>
                            <option value="Fase 1" {{ old('fase_malla') == 'Fase 1' ? 'selected' : '' }}>Fase 1</option>
                            <option value="Fase 2" {{ old('fase_malla') == 'Fase 2' ? 'selected' : '' }}>Fase 2</option>
                        </select>
                        @error('fase_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo Tipo de UC en malla (mover a otra fila si es necesario para el diseño) --}}
                    {{-- Lo dejo aquí para mostrar que se valida correctamente --}}
                    <div class="col-md-6 mt-3"> {{-- Añade mt-3 para separar si queda en la misma fila --}}
                        <label for="tipo_uc_en_malla" class="text-lightblue">Tipo de UC en malla</label>
                        <span>
                            <i class="fas fa-info-circle text-blue-500 text-base cursor-help" title="Seleccione una opcion"></i>
                        </span>
                        <select id="tipo_uc_en_malla" name="tipo_uc_en_malla"
                            class="form-control @error('tipo_uc_en_malla') is-invalid @enderror" required>
                            <option value="">Seleccione El tipo UC</option>
                            <option value="Obligatoria" {{ old('tipo_uc_en_malla') == 'Obligatoria' ? 'selected' : '' }}>Obligatoria</option>
                            <option value="Optativa" {{ old('tipo_uc_en_malla') == 'Optativa' ? 'selected' : '' }}>Optativa</option>
                            <option value="Servicio Comunitario" {{ old('tipo_uc_en_malla') == 'Servicio Comunitario' ? 'selected' : '' }}>Servicio Comunitario</option>
                            <option value="Proyecto" {{ old('tipo_uc_en_malla') == 'Proyecto' ? 'selected' : '' }}>Proyecto</option>
                            <option value="Practicas profesionales" {{ old('tipo_uc_en_malla') == 'Practicas profesionales' ? 'selected' : '' }}>Practicas profesionales</option>
                        </select>
                        @error('tipo_uc_en_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> {{-- Cierre de la Fila 3 --}}


                {{-- Fila 4: Año de Vigencia de Entrada y Año de Salida de Vigencia --}}
                <div class="row mt-3"> {{-- mt-3 añade un margen superior --}}
                    {{-- Campo anio_de_vigencia_de_entrada_malla --}}
                    <div class="col-md-6">
                        <label for="anio_de_vigencia_de_entrada_malla" class="text-lightblue">Año de Entrada en vigencia</label>
                        <input name="anio_de_vigencia_de_entrada_malla" id="anio_de_vigencia_de_entrada_malla"
                            class="form-control @error('anio_de_vigencia_de_entrada_malla') is-invalid @enderror" type="number"
                            min="1900" max="2100" value="{{ old('anio_de_vigencia_de_entrada_malla') }}" required> {{-- Ajustado min/max --}}
                        @error('anio_de_vigencia_de_entrada_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo anio_salida_vigencia --}}
                    <div class="col-md-6">
                        <label for="anio_salida_vigencia" class="text-lightblue">Año de Salida en Vigencia</label>
                        <input name="anio_salida_vigencia" id="anio_salida_vigencia"
                            class="form-control @error('anio_salida_vigencia') is-invalid @enderror" type="number"
                            min="1900" max="2100" value="{{ old('anio_salida_vigencia') }}"> {{-- Ajustado min/max, es nullable --}}
                        @error('anio_salida_vigencia')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> {{-- Cierre de la Fila 4 --}}


                {{-- Botones de acción --}}
                <div class="row mt-4"> {{-- Margin top para separar los botones de los campos --}}
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('mallas-curriculares.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- Custom Modal (instrucciones) --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell"
        v-centered static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <h4> -Estas en la vista: Crear Mallas Curriculares (Modelo MallaCurricular):</h4> <br>
                <p>    <b>duracion_en_malla:</b> Por ejemplo, "Semestral", "Anual", "Trimestral", "Por Fase".<br>
                    <b>fase_malla: </b>Por ejemplo, "N/A", "Fase 1", "Fase 2".<br>
                    <b>tipo_uc_en_malla: </b> Por ejemplo, "Obligatoria", "Electiva", "Requisito".<br><br>
                    <b>Lógica:</b> Estos campos en la tabla mallas_curriculares se refieren a las<br>
                    características GENERALES o PREDETERMINADAS de la malla curricular como un todo.<br>
                    <b>Es decir se colocan los campos que mas predominan en la mayoria de las materias</b><br>
                     Son metadatos sobre la estructura general del plan de estudios. <br>
                </p>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Aceptar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-button label="Leer Instructivo" data-toggle="modal" data-target="#modalCustom" class="bg-teal" />

@stop


@section('js') @if (session('success'))
    <script>
        $(document).ready(function() {
            let mensaje = "{{ session('success') }}";
            Swal.fire({
                title: 'Resultado',
                text: mensaje,
                icon: 'success'
            })
        })
    </script>
    @endif
@stop