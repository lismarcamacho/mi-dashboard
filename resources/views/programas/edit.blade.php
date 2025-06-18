@extends('adminlte::page')

@section('title', 'Editar Programa')
@section('page_title', 'Editar Programa')
@section('breadcrumb_item', 'Editar Programa')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Editar Programa..</h4>
@stop

@section('content_header')
    <center>
        <h1>Editar Programa</h1>
    </center>
@stop

@section('content')

    <p> Modifique la información del Programa</p>

    {{-- Notificación de éxito si viene de la sesión --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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

    {{-- El resto de tu contenido de la vista --}}

    <div class="card">


        <div class="card-body">
            <form action="{{ route('programas.update', $programa) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->


                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->


                {{-- Fila para Codigo Programa y Nombre Programa --}}
                <div class="row">
                    {{-- Campo Codigo Programa --}}
                    <x-adminlte-input name="codigo_programa" label="Código Programa"
                        placeholder="Ingrese el código del programa" label-class="text-lightblue"
                        value="{{ $programa->codigo_programa }}" fgroup-class="col-md-6">
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
                    <x-adminlte-input name="nombre_programa" label="Nombre Programa"
                        placeholder="Ingrese el nombre del programa" label-class="text-lightblue"
                        value="{{ $programa->nombre_programa }}" fgroup-class="col-md-6">
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
                    <x-adminlte-input name="fecha_programa" label="Fecha Programa" type="date"
                        value="{{ old('fecha_programa', $programa->fecha_programa instanceof \Carbon\Carbon ? $programa->fecha_programa->format('Y-m-d') : ($programa->fecha_programa ? \Carbon\Carbon::parse($programa->fecha_programa)->format('Y-m-d') : '')) }}"
                        title="Seleccione o escriba la fecha del programa." enable-old-support="true"
                        fgroup-class="col-md-6">
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
                    <x-adminlte-textarea name="descripcion" label="Descripción" label-class="text-lightblue" rows="3"
                        fgroup-class="col-md-6">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-align-left text-darkblue"></i> {{-- Icono para descripción --}}
                            </div>
                        </x-slot>
                        {{ $programa->descripcion }}{{-- old() va dentro del textarea --}}
                        @error('descripcion')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </x-adminlte-textarea>
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
                                        {{ in_array($especialidad->id, old('especialidades', $programa->especialidades->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="especialidad_{{ $especialidad->id }}">
                                        {{ $especialidad->codigo_especialidad }} -
                                        {{ $especialidad->nombre_especialidad }}
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
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <a href="{{ route('programas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>








            </form>

        </div>
    </div>

    {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
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

<@section('js') @if (session('success'))
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

<!--

<@ section('js') <script>
    $(document).ready(function() {
        console.log('¡jQuery se integró correctamente!');
    })
</script>
@ stop -->
