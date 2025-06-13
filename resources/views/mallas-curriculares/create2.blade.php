@extends('adminlte::page')

@section('title', 'Registrar Malla Curricular')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nueva Malla Curricular..</h4>
@stop

@section('content_header')
    <center>
        <h1>Agregar Malla Curricular</h1>
    </center>
@stop

@section('content')

    <p> Ingrese la información de la Malla Curricular</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

{{--@ php// ESTE CODIGO ES OTRA MANERA DE ENVIAR LA NOTIFICACION AL USUARIO PERO SE QUEDA EN EL FORMULARIO
        if (session()) {
        if (session('message') == 'ok') {
                                                                                                                                                                # code...
        echo '<x-adminlte-alert class="bg-teal text-uppercase" icon="fa fa-lg fa-thumbs-up" title="Done" dismissable>
        Especialidad Creada exitosamente!
    </x-adminlte-alert>';
    }
}


                                                                                                                                                    @ endphp -->
    {{-- El resto de tu contenido de la vista --}}

    <div class="card">



        <div class="card-body">
            <form action="{{ route('mallas-curriculares.store') }}" method="POST">
                @csrf

                <div class="col-md-12 ">
                    {{-- {{ dd($role) }}  --}}
                    {{-- {{ {{dd($role->permissions)}}  --}}

                    <label for="id_especialidad" class="text-lightblue">Especialidad</label>

                    <x-adminlte-select id="id_especialidad" name="id_especialidad"
                        class="form-control @error('id_especialidad') is-invalid @enderror" required
                        class="col-md-6 block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione una Especialidad</option>
                        @foreach ($especialidades as $especialidad)
                            <option value="{{ $especialidad->id }}"
                                {{ old('id_especialidad') == $especialidad->id ? 'selected' : '' }}>
                                {{ $especialidad->nombre_especialidad ?? 'ID: ' . $especialidad->id }}
                            </option>
                        @endforeach
                    </x-adminlte-select>

                    @error('id_especialidad')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!--
                <div class="col-md-12">
                    <label for="id_unidad_curricular" class="text-lightblue">Unidad Curricular:</label>
                    <x-adminlte-select name="id_unidad_curricular" id="id_unidad_curricular"
                        class="form-control @ error('id_unidad_curricular') is-invalid @ enderror" required
                        class="col-md-6 block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione una Unidad Curricular</option>
                        @ foreach ($unidadesCurriculares as $uc)
                            {{-- ¡Necesitarás pasar $unidadesCurriculares desde el controlador! --}}
                            <option value="{ { $uc->id }}" data-creditos="{ { $uc->creditos ?? 0 }}"
                                { { old('id_unidad_curricular') == $uc->id ? 'selected' : '' }}>
                                { { $uc->nombre ?? 'ID: ' . $uc->id }} {{-- Muestra el nombre de la UC, si existe --}}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                    @error('id_unidad_curricular')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                 -->


                {{-- Tu campo de Creditos en Malla (el último input) --}}
                <div class="col-md-12">
                    <label for="creditos_en_malla" class="text-lightblue">Créditos en Malla:</label>
                    {{-- ¡Importante! Añade el atributo `readonly` para que el usuario no lo edite manualmente --}}
                    <x-adminlte-input type="number" name="creditos_en_malla" id="creditos_en_malla"
                        class="form-control @error('creditos_en_malla') is-invalid @enderror"
                        value="{{ old('creditos_en_malla') }}" step="0.01" readonly required
                        class="col-md-6 block w-full mt-1 border-gray-300 focus:border-indigo-500
                         focus:ring-indigo-500 rounded-md shadow-sm">
                        @error('creditos_en_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </x-adminlte-input>
                </div>
                <!--
                <div class="col-md-12">
                    {{-- {{ dd($role) }}  --}}
                    {{-- {{ {{dd($role->permissions)}}  --}}

                    <label for="id_trayecto" class="text-lightblue">Trayecto</label>

                    <x-adminlte-select id="id_trayecto" name="id_trayecto"
                        class="form-control @ error('id_trayecto') is-invalid @ enderror" required
                        class="col-md-6 block w-full mt-1 sm:text-sm bg-blue-50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione un Trayecto</option>
                        @ foreach ($trayectos as $trayecto)
                            {{-- ¡Necesitarás pasar $trayectos desde el controlador! --}}
                            <option value="{ { $trayecto->id }}"
                                { { old('id_trayecto') == $trayecto->id ? 'selected' : '' }}>
                                { { $trayecto->nombre_trayecto ?? 'ID: ' . $trayecto->id }}
                            </option>
                        @ endforeach
                    </x-adminlte-select>
                    @ error('id_trayecto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{ { $message }}</strong>
                        </span>
                    @ enderror
                </div>
                -->

                <!--

                <div class="col-md-12">
                    <label for="minimo_aprobatorio" class="text-lightblue">Minimo Aprobatorio:</label>
                    {{-- ¡Importante! Añade el atributo `readonly` para que el usuario no lo edite manualmente --}}
                    <span class="tooltip-container"> {{-- Contenedor para el tooltip si usas el CSS personalizado --}}
                        <i class="fas fa-info-circle text-blue-500 text-base cursor-help"
                            title="La nota mínima para aprobar esta unidad curricular. Se ajusta automáticamente según si es una materia proyecto o no."></i>
                        {{-- Opcional: Si quieres un tooltip personalizado más complejo, usa el span tooltip-text --}}
                    </span>
                    <x-adminlte-input type="number" name="minimo_aprobatorio" id="minimo_aprobatorio"
                        class="form-control @ error('minimo_aprobatorio') is-invalid @ enderror"
                        value="{ { old('minimo_aprobatorio') }}" step="0.01" readonly required
                        class="col-md-6 block w-full mt-1 border-gray-300 focus:border-indigo-500
                         focus:ring-indigo-500 rounded-md shadow-sm">
                        @ error('minimo_aprobatorio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{ { $message }}</strong>
                            </span>
                        @ enderror
                    </x-adminlte-input>
                </div>
                 -->

                <div class="col-md-12 ">
                    {{-- {{ dd($role) }}  --}}
                    {{-- {{ {{dd($role->permissions)}}  --}}

                    <label for="duracion_en_malla" class="text-lightblue">Duración en malla</label>

                    <span class="tooltip-container"> {{-- Contenedor para el tooltip si usas el CSS personalizado --}}
                        <i class="fas fa-info-circle text-blue-500 text-base cursor-help"
                            title="Si el proyecto es por fase se indica por fase no anual "></i>
                        {{-- Opcional: Si quieres un tooltip personalizado más complejo, usa el span tooltip-text --}}
                    </span>
                    <x-adminlte-select id="duracion_en_malla" name="duracion_en_malla"
                        class="form-control @error('duracion_en_malla') is-invalid @enderror" required
                        class="col-md-6 block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione la Duración</option>
                        <option value="Trimestral" {{ old('duracion_en_malla') == 'Trimestral' ? 'selected' : '' }}>
                            Trimestral</option>
                        <option value="Semestral" {{ old('duracion_en_malla') == 'Semestral' ? 'selected' : '' }}>
                            Semestral</option>
                        <option value="Anual" {{ old('duracion_en_malla') == 'Anual' ? 'selected' : '' }}>Anual</option>
                        <option value="Por Fases" {{ old('duracion_en_malla') == 'Por Fases' ? 'selected' : '' }}>Por
                            Fases</option>
                    </x-adminlte-select>
                    @error('duracion_en_malla')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="col-md-12 ">

                    <label for="fase_malla" class="text-lightblue">Fase en malla</label>

                    <i class="fas fa-info-circle text-blue-500 text-base cursor-help"
                        title="Fase específica de la unidad curricular dentro del trayecto (ej. Fase 1, Fase
                            2). Selecciona el campo vacio, si no aplica."></i>
                    {{-- Opcional: Si quieres un tooltip personalizado más complejo, usa el span tooltip-text --}}
                    </span>
                    <x-adminlte-select id="fase_malla" name="fase_malla"
                        class="form-control @error('fase_malla') is-invalid @enderror" 
                        class="col-md-6
                        block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md
                        shadow-sm">
                        <option value="">Seleccione la Fase</option>
                        <option value="N/A" {{ old('fase_malla') == 'N/A' ? 'selected' : '' }}>N/A</option>
                        <option value="Fase 1" {{ old('fase_malla') == 'Fase 1' ? 'selected' : '' }}>Fase 1</option>
                        <option value="Fase 2" {{ old('fase_malla') == 'Fase 2' ? 'selected' : '' }}>Fase 2</option>
                    </x-adminlte-select>
                    @error('fase_malla')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="col-md-12 ">
                    {{-- {{ dd($role) }}  --}}
                    {{-- {{ {{dd($role->permissions)}}  --}}

                    <label for="tipo_uc_en_malla" class="text-lightblue">Tipo de UC en malla</label>

                    <i class="fas fa-info-circle text-blue-500 text-base cursor-help" title="Seleccione una opcion"></i>
                    {{-- Opcional: Si quieres un tooltip personalizado más complejo, usa el span tooltip-text --}}
                    </span>
                    <x-adminlte-select id="tipo_uc_en_malla" name="tipo_uc_en_malla"
                        class="form-control @error('fase_malla') is-invalid @enderror" required
                        class="col-md-6
                        block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md
                        shadow-sm">
                        <option value="">Seleccione la Fase</option>
                        <option value="Obligatoria" {{ old('tipo_uc_en_malla') == 'Obligatoria' ? 'selected' : '' }}>
                            Obligatoria</option>
                        <option value="Optativa" {{ old('tipo_uc_en_malla') == 'Optativa' ? 'selected' : '' }}>Optativa
                        </option>
                        <option value="Servicio Comunitario"
                            {{ old('tipo_uc_en_malla') == 'Servicio Comunitario' ? 'selected' : '' }}>Servicio Comunitario
                        </option>
                        <option value="Proyecto" {{ old('tipo_uc_en_malla') == 'Proyecto' ? 'selected' : '' }}>Proyecto
                        </option>
                        <option value="Practicas profesionales"
                            {{ old('tipo_uc_en_malla') == 'Practicas profesionales' ? 'selected' : '' }}>Practicas
                            profesionales</option>
                    </x-adminlte-select>
                    @error('tipo_uc_en_malla')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="anio_de_vigencia_de_entrada_malla"
                        label="anio_de_vigencia_de_entrada_malla " type="number" label-class="text-lightblue"
                        min="2008" max="2050" value="{{ old('anio_de_vigencia_de_entrada_malla') }}" required>

                    </x-adminlte-input>
                </div>

                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="anio_salida_vigencia"
                        label="anio_salida_vigencia " type="number" label-class="text-lightblue"
                        min="2008" max="2050" value="{ { old('anio_salida_vigencia') }}" required>

                    </x-adminlte-input>-->




                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('mallas-curriculares.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>










            </form>
        </div>
    </div>




    {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell"
        v-centered static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - El campo Fecha Programa esta indicando la fecha actual, <br>
                    lo puedes cambiar pero usando el mismo formato DD/MM/AAAA.
                </p>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept" data-dismiss="modal" />

        </x-slot>
    </x-adminlte-modal>
    {{-- Example button to open modal --}}
    <x-adminlte-button label="Leer Instructivo" data-toggle="modal" data-target="#modalCustom" class="bg-teal" />

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Estilos para el tooltip (opcional, si AdminLTE no lo maneja por defecto) */
        .tooltip-container {
            position: relative;
            display: inline-block;
        }

        .tooltip-text {
            visibility: hidden;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            /* Posición encima */
            left: 50%;
            margin-left: -60px;
            /* Centrar el tooltip */
            opacity: 0;
            transition: opacity 0.3s;
            white-space: nowrap;
            font-size: 0.75rem;
        }

        .tooltip-container:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const unidadCurricularSelect = document.getElementById('id_unidad_curricular');
            const creditosEnMallaInput = document.getElementById('creditos_en_malla');
            const minimoAprobatorioInput = document.getElementById('minimo_aprobatorio');

            // Función única para actualizar ambos valores (créditos y mínimo aprobatorio)
            function actualizarValoresUnidadCurricular() {
                const selectedOption = unidadCurricularSelect.options[unidadCurricularSelect.selectedIndex];

                // Si no se selecciona ninguna opción (o se selecciona la opción vacía)
                if (!selectedOption || selectedOption.value === "") {
                    creditosEnMallaInput.value = '';
                    minimoAprobatorioInput.value = '';
                    return; // Salir de la función
                }

                // --- Lógica para Créditos en Malla ---
                // Asegúrate de que 'selectedOption' y 'selectedOption.dataset' existen
                const creditos = selectedOption.dataset.creditos; // Obtener los créditos del atributo data-creditos
                creditosEnMallaInput.value = creditos;

                // --- Lógica para Mínimo Aprobatorio ---
                const unidadCurricularNombre = selectedOption.textContent
                    .trim(); // Obtener el texto visible de la opción
                let minimoAprobatorio = '';

                // Convertir a mayúsculas para hacer la comparación insensible a mayúsculas/minúsculas
                const nombreMayusculas = unidadCurricularNombre.toUpperCase();

                // Condición: Si el nombre comienza con "PROYECTO"
                if (nombreMayusculas.startsWith('PROYECTO')) {
                    minimoAprobatorio = 16;
                } else { // Si se selecciona otra UC, que no sea la opción vacía o "PROYECTO..."
                    minimoAprobatorio = 12;
                }

                minimoAprobatorioInput.value = minimoAprobatorio;
            }

            // UN ÚNICO Listener para el evento 'change' en el select de Unidad Curricular
            unidadCurricularSelect.addEventListener('change', actualizarValoresUnidadCurricular);

            // Opcional: Llamar a la función al cargar la página si ya hay una opción seleccionada (ej. con old())
            // Esto es importante para mantener los valores si la página se recarga por una validación fallida
            if (unidadCurricularSelect.value) {
                actualizarValoresUnidadCurricular();
            }
        });
    </script>
@stop
