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
            {{-- Asegúrate de que el título refleje "Editar" --}}
            <h2>Editar Malla Curricular: {{ $mallaCurricular->nombre }}</h2>

            {{-- Formulario de edición --}}
            <form action="{{ route('mallas-curriculares.update', $mallaCurricular->id) }}" method="POST">
                @csrf {{-- Token CSRF para seguridad --}}
                @method('PUT') {{-- Indica que esta es una solicitud PUT/PATCH para el método update --}}

                <div class="row">
                    {{-- Campo Nombre --}}
                    <div class="col-md-6">
                        <label for="nombre" class="text-lightblue">Nombre de la Malla</label>
                        <input type="text" name="nombre" id="nombre"
                            class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre', $mallaCurricular->nombre) }}" required>
                        @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo Especialidad --}}
                    <div class="col-md-6">
                        <label for="id_especialidad" class="text-lightblue">Especialidad</label>
                        <select name="id_especialidad" id="id_especialidad"
                            class="form-control @error('id_especialidad') is-invalid @enderror" required>
                            <option value="">Seleccione la Especialidad</option>
                            @foreach ($especialidades as $especialidad)
                                <option value="{{ $especialidad->id }}"
                                    {{ old('id_especialidad', $mallaCurricular->id_especialidad) == $especialidad->id ? 'selected' : '' }}>
                                    {{ $especialidad->nombre_especialidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_especialidad')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    {{-- Campo Duración en Malla (si lo tienes en el formulario) --}}
                    <div class="col-md-6">
                        <label for="duracion_en_malla" class="text-lightblue">Duración en Malla:</label>
                        <select name="duracion_en_malla" id="duracion_en_malla"
                            class="form-control @error('duracion_en_malla') is-invalid @enderror" required>
                            <option value="">Seleccione la duración</option>
                            <option value="Semestral"
                                {{ old('duracion_en_malla', $mallaCurricular->duracion_en_malla) == 'Semestral' ? 'selected' : '' }}>
                                Semestral</option>
                            <option value="Trimestral"
                                {{ old('duracion_en_malla', $mallaCurricular->duracion_en_malla) == 'Trimestral' ? 'selected' : '' }}>
                                Trimestral</option>
                            <option value="Anual"
                                {{ old('duracion_en_malla', $mallaCurricular->duracion_en_malla) == 'Anual' ? 'selected' : '' }}>
                                Anual</option>
                            <option value="Fase"
                                {{ old('duracion_en_malla', $mallaCurricular->duracion_en_malla) == 'Fase' ? 'selected' : '' }}>
                                por Fase</option>
                        </select>
                        @error('duracion_en_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo Fase en Malla (si lo tienes en el formulario) --}}
                    <div class="col-md-6">
                        <label for="fase_malla" class="text-lightblue">Fase en malla</label>
                        <select id="fase_malla" name="fase_malla"
                            class="form-control @error('fase_malla') is-invalid @enderror">
                            <option value="">Seleccione la Fase</option>
                            <option value="N/A"
                                {{ old('fase_malla', $mallaCurricular->fase_malla) == 'N/A' ? 'selected' : '' }}>N/A
                            </option>
                            <option value="Fase 1"
                                {{ old('fase_malla', $mallaCurricular->fase_malla) == 'Fase 1' ? 'selected' : '' }}>Fase 1
                            </option>
                            <option value="Fase 2"
                                {{ old('fase_malla', $mallaCurricular->fase_malla) == 'Fase 2' ? 'selected' : '' }}>Fase 2
                            </option>
                            <option value="Semestral"
                                {{ old('fase_malla', $mallaCurricular->fase_malla) == 'Semestral' ? 'selected' : '' }}>
                                Semestral</option>
                            <option value="Trimestral"
                                {{ old('fase_malla', $mallaCurricular->fase_malla) == 'Trimestral' ? 'selected' : '' }}>
                                Trimestral</option>
                        </select>
                        @error('fase_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    {{-- Campo Tipo UC en Malla --}}
                    <div class="col-md-6">
                        <label for="tipo_uc_en_malla" class="text-lightblue">Tipo UC en Malla</label>
                        <select name="tipo_uc_en_malla" id="tipo_uc_en_malla"
                            class="form-control @error('tipo_uc_en_malla') is-invalid @enderror" required>
                            <option value="">Seleccione el Tipo de UC</option>
                            <option value="Obligatoria"
                                {{ old('tipo_uc_en_malla', $mallaCurricular->tipo_uc_en_malla) == 'Obligatoria' ? 'selected' : '' }}>
                                Obligatoria</option>
                            <option value="Electiva"
                                {{ old('tipo_uc_en_malla', $mallaCurricular->tipo_uc_en_malla) == 'Electiva' ? 'selected' : '' }}>
                                Electiva</option>
                            <option value="Requisito"
                                {{ old('tipo_uc_en_malla', $mallaCurricular->tipo_uc_en_malla) == 'Requisito' ? 'selected' : '' }}>
                                Requisito</option>
                        </select>
                        @error('tipo_uc_en_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo Año de Vigencia de Entrada --}}
                    <div class="col-md-6">
                        <label for="anio_de_vigencia_de_entrada_malla" class="text-lightblue">Año de vigencia de entrada de
                            la Malla</label>
                        <input type="number" name="anio_de_vigencia_de_entrada_malla"
                            id="anio_de_vigencia_de_entrada_malla"
                            class="form-control @error('anio_de_vigencia_de_entrada_malla') is-invalid @enderror"
                            value="{{ old('anio_de_vigencia_de_entrada_malla', $mallaCurricular->anio_de_vigencia_de_entrada_malla) }}"
                            required>
                        @error('anio_de_vigencia_de_entrada_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    {{-- Campo Créditos en Malla --}}
                    <div class="col-md-6">
                        <label for="creditos_en_malla" class="text-lightblue">Créditos en Malla</label>
                        <input type="number" name="creditos_en_malla" id="creditos_en_malla"
                            class="form-control @error('creditos_en_malla') is-invalid @enderror"
                            value="{{ old('creditos_en_malla', $mallaCurricular->creditos_en_malla) }}" required>
                        @error('creditos_en_malla')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo Año Salida Vigencia --}}
                    <div class="col-md-6">
                        <label for="anio_salida_vigencia" class="text-lightblue">Año de salida de vigencia</label>
                        <input type="number" name="anio_salida_vigencia" id="anio_salida_vigencia"
                            class="form-control @error('anio_salida_vigencia') is-invalid @enderror"
                            value="{{ old('anio_salida_vigencia', $mallaCurricular->anio_salida_vigencia) }}">
                        {{-- No 'required' si es nullable --}}
                        @error('anio_salida_vigencia')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    {{-- Campo Mínimo Aprobatorio (si lo tienes en el formulario) --}}
                  <!--  <div class="col-md-6">
                        <label for="minimo_aprobatorio" class="text-lightblue">Mínimo Aprobatorio:</label>
                        <input type="number" name="minimo_aprobatorio" id="minimo_aprobatorio"
                            class="form-control @ error('minimo_aprobatorio') is-invalid @ enderror"
                            value="{ { old('minimo_aprobatorio', $mallaCurricular->minimo_aprobatorio) }}" step="0.01"
                            min="0" max="20">
                        @ error('minimo_aprobatorio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{ { $message }}</strong>
                            </span>
                        @ enderror
                    </div>  -->

                    {{-- Campo Trayectos Seleccionados (select multiple) --}}
                    <div class="col-md-6">
                        <label for="trayectos_seleccionados" class="text-lightblue">Asignar a Trayectos:</label>
                        <select multiple="multiple" name="trayectos_seleccionados[]" id="trayectos_seleccionados"
                            class="form-control @error('trayectos_seleccionados') is-invalid @enderror">
                            @foreach ($trayectos as $trayecto)
                                <option value="{{ $trayecto->id }}"
                                    {{ in_array($trayecto->id, old('trayectos_seleccionados', $mallaCurricular->trayectos->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-left">
                        <button type="submit" class="btn btn-primary">Actualizar Malla Curricular</button>
                        <a href="{{ route('mallas-curriculares.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
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
