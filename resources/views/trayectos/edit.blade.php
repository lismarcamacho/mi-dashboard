@extends('adminlte::page')

@section('title', 'Editar Trayecto')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Editar Trayecto..</h4>
@stop

@section('content_header')
    <center>
        <h1>Editar Trayecto</h1>
    </center>
@stop

@section('content')

    <p> Modifique la información del Trayecto</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- El resto de tu contenido de la vista --}}

    <div class="card">


        <div class="card-body">
            <form action="{{ route('trayectos.update', $trayecto) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->


                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->

                {{-- Fila 1: Numero Orden y Nombre Trayecto --}}
                <div class="row">
                    {{-- Campo Numero Orden --}}
                    <div class="col-md-6">
                        <x-adminlte-input name="numero_orden" label="Numero orden" placeholder="Numero Orden"
                            label-class="text-lightblue" value="{{ old('numero_orden', $trayecto->numero_orden) }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-hashtag text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('numero_orden')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo Nombre Trayecto --}}
                    <div class="col-md-6">
                        <x-adminlte-input name="nombre_trayecto" label="Nombre" placeholder="Nombre del Trayecto"
                            label-class="text-lightblue" value="{{ old('nombre_trayecto', $trayecto->nombre_trayecto) }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-signature text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('nombre_trayecto')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> {{-- Fin de Fila 1 --}}

                {{-- Fila 2: Descripción y Programa --}}
                <div class="row mt-3">
                    {{-- Campo Descripción --}}
                    <div class="col-md-6">
                        <x-adminlte-input name="descripcion" label="Descripción" placeholder="Descripción del Trayecto"
                            label-class="text-lightblue" value="{{ old('descripcion', $trayecto->descripcion) }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-info-circle text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('descripcion')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- Campo Programa (select) --}}
                    <div class="col-md-6">
                        <x-adminlte-select name="programa_id" label="Programa al que Pertenece" label-class="text-lightblue"
                            required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                            </x-slot>
                            <option value="">Seleccione un Programa</option>
                            @foreach ($programas as $programa)
                                <option value="{{ $programa->id }}"
                                    {{ old('programa_id', $trayecto->programa_id) == $programa->id ? 'selected' : '' }}>
                                    {{ $programa->nombre_programa }}
                                </option>
                            @endforeach
                        </x-adminlte-select>
                        @error('programa_id')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> {{-- Fin de Fila 2 --}}

                {{-- Fila para Botones --}}
                <div class="row mt-4">
                    <div class="col-md-12 text-left">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('trayectos.index') }}" class="btn btn-secondary ml-2">Cancelar</a>
                    </div>
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
                <p> -
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
