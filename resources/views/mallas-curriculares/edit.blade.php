@extends('adminlte::page')

@section('title', 'Editar Malla Curricular')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Editar Malla Curricular..</h4>
@stop

@section('content_header')
    <center>
        <h1>Editar Malla Curricular</h1>
    </center>
@stop

@section('content')

    <p> Modifique la información de la Malla Curricular</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- El resto de tu contenido de la vista --}}

    <div class="card">


        <div class="card-body">
            <form action="{{ route('mallas-curriculares.update', $mallaCurricular->id) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->


                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->



                <div class="col-md-12 ">
                    {{-- {{ dd($role) }}  --}}
                    {{-- {{ {{dd($role->permissions)}}  --}}

                    <label for="id_especialidad" class="text-lightblue">Especialidad</label>

                    <x-adminlte-select id="id_especialidad" name="id_especialidad"
                        class="form-control @error('id_especialidad') is-invalid @enderror" required
                        class="col-md-6 block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione una Especialidad</option>
                        @foreach ($especialidades as $especialidad)
                            <option value="{{ $especialidad->id }}" {{-- Compara el ID de la especialidad actual con el id_especialidad de la malla --}}
                                @if (old('id_especialidad', $mallaCurricular->id_especialidad) == $especialidad->id) selected @endif>{{ $especialidad->nombre_especialidad }}
                            </option>
                        @endforeach
                    </x-adminlte-select>

                    @error('id_especialidad')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="id_unidad_curricular" class="text-lightblue">Unidad Curricular:</label>
                    <x-adminlte-select name="id_unidad_curricular" id="id_unidad_curricular"
                        class="form-control @error('id_unidad_curricular') is-invalid @enderror" required
                        class="col-md-6 block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione una Unidad Curricular</option>
                        @foreach ($unidadesCurriculares as $unidadCurricular)
                            <option value="{{ $unidadCurricular->id }}" @if (old('id_unidad_curricular', $mallaCurricular->id_unidad_curricular) == $unidadCurricular->id) selected @endif>
                                {{ $unidadCurricular->codigo }} - {{ $unidadCurricular->nombre }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                    @error('id_unidad_curricular')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>



                <!--    <div class="col-md-12 "> -->
                {{-- {{ dd($role) }}  --}}
                {{-- {{ {{dd($role->permissions)}}  --}}
                {{-- <div> --}}



                <div class="col-md-12">
                    <label for="creditos_en_malla" class="text-lightblue">Créditos en Malla:</label>
                    {{-- ¡Importante! Añade el atributo `readonly` para que el usuario no lo edite manualmente --}}
                    <span class="tooltip-container"> {{-- Contenedor para el tooltip si usas el CSS personalizado --}}
                        <i class="fas fa-info-circle text-blue-500 text-base cursor-help"
                            title="Este valor en el formulario de registrar malla,  se carga automaticamente desde la unidad curricular, en particular este dato no deberia ser cambiado a la ligera"></i>
                        {{-- Opcional: Si quieres un tooltip personalizado más complejo, usa el span tooltip-text --}}
                    </span>
                    <x-adminlte-input type="number" name="creditos_en_malla" id="creditos_en_malla" class="form-control"
                        class="col-md-6 block w-full mt-1 sm:text-sm bg-blue-50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        value="{{ old('creditos_en_malla', $mallaCurricular->creditos_en_malla) }}" required>

                        @error('creditos_en_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </x-adminlte-input>
                </div>



                <div class="col-md-12">
                    {{-- {{ dd($role) }}  --}}
                    {{-- {{ {{dd($role->permissions)}}  --}}

                    <label for="id_trayecto" class="text-lightblue">Trayecto</label>

                    <x-adminlte-select id="id_trayecto" name="id_trayecto"
                        class="form-control @error('id_trayecto') is-invalid @enderror" required
                        class="col-md-6 block w-full mt-1 sm:text-sm bg-blue-50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione un Trayecto</option>
                        @foreach ($trayectos as $trayecto)
                            <option value="{{ $trayecto->id }}" @if (old('id_trayecto', $mallaCurricular->id_trayecto) == $trayecto->id) selected @endif>
                                {{ $trayecto->nombre_trayecto }} {{-- Asegúrate que 'nombre' es la columna correcta para el nombre del trayecto --}}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                    @error('id_trayecto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>




                <div class="col-md-12">
                    <label for="minimo_aprobatorio" class="text-lightblue">Minimo Aprobatorio:</label>
                    {{-- ¡Importante! Añade el atributo `readonly` para que el usuario no lo edite manualmente --}}
                    <span class="tooltip-container"> {{-- Contenedor para el tooltip si usas el CSS personalizado --}}
                        <i class="fas fa-info-circle text-blue-500 text-base cursor-help"
                            title="La nota mínima para aprobar esta unidad curricular. Este dato se carga automaticamente dependiendo si la UNIDAD CURRICULAR es proyecto o no ,tambien en registrar malla, no deberia cambiar este dato a la ligera sin confirmar primero."></i>
                        {{-- Opcional: Si quieres un tooltip personalizado más complejo, usa el span tooltip-text --}}
                    </span>
                    <x-adminlte-input type="number" name="minimo_aprobatorio" id="minimo_aprobatorio" class="form-control"
                        class="col-md-6 block w-full mt-1 sm:text-sm bg-blue-50 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        value="{{ old('minimo_aprobatorio', $mallaCurricular->minimo_aprobatorio) }}" required>

                        @error('minimo_aprobatorio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </x-adminlte-input>
                </div>

                {{-- <div class="col-md-12 "> --}}
                {{-- {{ dd($role) }}  --}}
                {{-- {{ {{dd($role->permissions)}}  --}}


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
                        <option value="Trimestral" @selected(old('duracion_en_malla', $mallaCurricular->duracion_en_malla) == 'Trimestral')>Trimestral</option>
                        <option value="Semestral" @selected(old('duracion_en_malla', $mallaCurricular->duracion_en_malla) == 'Semestral')>Semestral</option>
                        <option value="Anual" @selected(old('duracion_en_malla', $mallaCurricular->duracion_en_malla) == 'Anual')>Anual</option>
                        <option value="Por Fases" @selected(old('duracion_en_malla', $mallaCurricular->duracion_en_malla) == 'Por Fases')>Por Fases</option>
                    </x-adminlte-select>
                    @error('duracion_en_malla')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>


                <div class="col-md-12 ">
                    {{-- {{ dd($role) }}  --}}
                    {{-- {{ {{dd($role->permissions)}}  --}}

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
                        <option value="N/A" @selected(old('fase_malla', $mallaCurricular->fase_malla) == 'N/A')>N/A</option>
                        <option value="Fase 1" @selected(old('fase_malla', $mallaCurricular->fase_malla) == 'N/A')>Fase 1</option>
                        <option value="Fase 2" @selected(old('fase_malla', $mallaCurricular->fase_malla) == 'N/A')>Fase 2</option>
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

                    {{-- Opcional: Si quieres un tooltip personalizado más complejo, usa el span tooltip-text --}}
                    
                    <x-adminlte-select id="tipo_uc_en_malla" name="tipo_uc_en_malla"
                        class="form-control @error('fase_malla') is-invalid @enderror" required
                        class="col-md-6
                        block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md
                        shadow-sm">
                        <option value="">Seleccione la Fase</option>
                        <option value="Obligatoria" @selected(old('tipo_uc_en_malla', $mallaCurricular->tipo_uc_en_malla) == 'Obligatoria')>Obligatoria</option>
                        <option value="Optativa" @selected(old('tipo_uc_en_malla', $mallaCurricular->tipo_uc_en_malla) == 'Optativa')>Optativa</option>
                        <option value="Servicio Comunitario" @selected(old('tipo_uc_en_malla', $mallaCurricular->tipo_uc_en_malla) == 'Servicio Comunitario')>Servicio Comunitario</option>
                        <option value="Proyecto" @selected(old('tipo_uc_en_malla', $mallaCurricular->tipo_uc_en_malla) == 'Proyecto')>Proyecto</option>
                        <option value="Practicas profesionales" @selected(old('tipo_uc_en_malla', $mallaCurricular->tipo_uc_en_malla) == 'Practicas profesionales')>Practicas profesionales
                        </option>
                    </x-adminlte-select>
                    @error('tipo_uc_en_malla')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>






                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="anio_de_vigencia_de_entrada_malla"
                        label="Año de Vigencia Entrada" type="number" label-class="text-lightblue" min="2008"
                        max="2050" value="{{ $mallaCurricular->anio_de_vigencia_de_entrada_malla }}" required>

                    </x-adminlte-input>
                </div>

                <div class="col-md-12">
                    <label for="tipo_uc_en_malla" class="text-lightblue">Año de Vigencia Entrada</label>

                    <span class="tooltip-container"> {{-- Contenedor para el tooltip si usas el CSS personalizado --}}
                        <i class="fas fa-info-circle text-blue-500 text-base cursor-help"
                            title="Este campo queda vacio si la UNIDAD CURRICULAR aun esta vigente"></i>
                        {{-- Opcional: Si quieres un tooltip personalizado más complejo, usa el span tooltip-text --}}
                    </span>
                    <x-adminlte-input class="col-md-6" name="anio_salida_vigencia" id="tipo_uc_en_malla"
                        type="number" label-class="text-lightblue" min="2008" max="2050"
                        value="{{ $mallaCurricular->anio_salida_vigencia }}" >

                    </x-adminlte-input>

                <button type="submit" class="btn btn-primary" id="Edit">Actualizar</button>
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
                <p> - El campo Fecha Programa lo puedes cambiar, pero usando el mismo formato DD/MM/AAAA.
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
@stop


<!-- ESTE CODIGO FUNCIONA PERFECTAMENTE-->
<!--
<@ section('js') @ if (session('success'))
    <script>
        $(document).ready(function() {
            let mensaje = "{ { session('success') }}";
            Swal.fire({
                title: 'Resultado',
                text: mensaje,
                icon: 'success'
            })
        })
    </script>
    @ endif
@ stop
-->

<@section('js') <script>
    $(document).ready(function() {
        console.log('¡jQuery se integró correctamente!');
    })
</script>
@stop
