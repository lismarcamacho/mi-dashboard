@extends('adminlte::page')

{{-- Títulos de la página --}}
@section('title', 'Registrar Programa')
@section('page_title', 'Crear Nuevo Programa')
@section('breadcrumb_item', 'Nuevo Programa')

{{-- Preloader personalizado de AdminLTE --}}
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nuevo Programa..</h4>
@stop

{{-- Contenido del encabezado de la página (dentro del wrapper de AdminLTE) --}}
@section('content_header')
    <center>
        <h1>Agregar Programa</h1>
    </center>
@stop

{{-- Contenido principal de la página --}}
@section('content')

    <p>Ingrese la información del Programa.</p>

    {{-- Notificación de éxito si viene de la sesión --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
        <div class="card-body">
            <form action="{{ route('programas.store') }}" method="POST">
                @csrf

                {{-- Fila para Codigo Programa y Nombre Programa --}}
                <div class="row">
                    {{-- Campo Codigo Programa --}}
                    <x-adminlte-input name="codigo_programa" label="Código Programa"
                        placeholder="Ingrese el código del programa" label-class="text-lightblue"
                        value="{{ old('codigo_programa') }}" fgroup-class="col-md-6">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-barcode text-darkblue"></i> {{-- Icono para código --}}
                            </div>
                        </x-slot>
                        @error('codigo_programa')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </x-adminlte-input>

                    {{-- Campo Nombre Programa --}}
                    {{-- Usamos 'name="nombre"' como se acordó para el controlador --}}
                    <x-adminlte-input name="nombre_programa" label="Nombre Programa" placeholder="Ingrese el nombre del programa"
                        label-class="text-lightblue" value="{{ old('nombre_programa') }}" fgroup-class="col-md-6">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-graduation-cap text-darkblue"></i> {{-- Icono para nombre --}}
                            </div>
                        </x-slot>
                        @error('nombre_programa')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </x-adminlte-input>
                </div> {{-- Fin de la fila --}}

                {{-- Fila para Fecha Programa y Descripción --}}
                <div class="row">
                    {{-- Campo Fecha Programa --}}
                    {{-- Corregido: Usamos 'name="fecha_programa"' --}}
                    <x-adminlte-input name="fecha_programa" label="Fecha Programa" placeholder="YYYY-MM-DD" type="date"
                        label-class="text-lightblue" value="{{ old('fecha_programa') }}" fgroup-class="col-md-6"
                        title="Seleccione o escriba la fecha del programa.">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>
                        @error('fecha_programa')
                            <span class="text-danger d-block">{{ $message }}</span> {{-- Usé text-danger d-block para la alineación --}}
                        @enderror
                    </x-adminlte-input>

                    {{-- Campo Descripción --}}
                    {{-- Usamos x-adminlte-textarea para descripciones multilínea --}}
                    <x-adminlte-textarea name="descripcion" label="Descripción"
                        placeholder="Ingrese una descripción del programa" label-class="text-lightblue" rows="3"
                        fgroup-class="col-md-6" value="{{ old('descripcion') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-align-left text-darkblue"></i> {{-- Icono para descripción --}}
                            </div>
                        </x-slot>
                        {{-- old() va dentro del textarea  {{ old('descripcion') }} --}}
                       
                    </x-adminlte-textarea>
                     @error('descripcion')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div> {{-- Fin de la fila --}}

                {{-- Asignar Especialidades (Checkbox Group) --}}
                {{-- Esto ocupa una fila completa debajo de los otros campos --}}
                <div class="form-group col-md-12 mt-3">
                    <label>Asignar Especialidades:</label>
                    <div class="row">
                        {{-- Usamos @forelse para manejar el caso de lista vacía --}}
                        @forelse ($todasEspecialidades as $especialidad)
                            <div class="col-md-4 col-sm-6"> {{-- Columnas responsivas para los checkboxes --}}
                                <div class="form-check">
                                    <input class="form-check-input @error('especialidades') is-invalid @enderror"
                                        type="checkbox" id="especialidad_{{ $especialidad->id }}" name="especialidades[]"
                                        value="{{ $especialidad->id }}"
                                        {{ in_array($especialidad->id, old('especialidades', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="especialidad_{{ $especialidad->id }}">
                                       {{ $especialidad->codigo_especialidad }} - {{ $especialidad->nombre_especialidad }}
                                    </label>
                                </div>
                            </div>
                        @empty
                            {{-- Mensaje que se muestra si $todasEspecialidades está vacía --}}
                            <div class="col-12">
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle"></i> Aún no se ha creado ninguna especialidad. Por favor,
                                    cree al menos una para poder asignarla.
                                </div>
                            </div>
                        @endforelse
                    </div>
                    @error('especialidades')
                        <div class="text-danger mt-2">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                {{-- Botones de acción --}}
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('programas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Modal de Instrucciones --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:auto;">
            <h2>Instrucciones</h2>
            <p>
                - El campo "Fecha Programa" debe seguir el formato **AAAA-MM-DD** para una correcta gestión con el selector
                de fecha.<br>
                - Puedes cambiar la fecha haciendo clic en el campo o escribiendo directamente.
            </p>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Entendido" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

    {{-- Botón para abrir el modal --}}
    <x-adminlte-button label="Leer Instructivo" data-toggle="modal" data-target="#modalCustom" class="bg-teal mt-3" />

@stop

{{-- Secciones de CSS y JS --}}
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // Aquí puedes agregar scripts JavaScript si son necesarios.
    </script>
@stop
