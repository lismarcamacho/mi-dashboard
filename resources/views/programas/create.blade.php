@extends('adminlte::page')

@section('title', 'Registrar Programa')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nuevo Programa..</h4>
@stop

@section('content_header')
    <center>
        <h1>Agregar Programa</h1>
    </center>
@stop

@section('content')

    <p> Ingrese la información del Programa</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!--@ php// ESTE CODIGO ES OTRA MANERA DE ENVIAR LA NOTIFICACION AL USUARIO PERO SE QUEDA EN EL FORMULARIO
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
            <form action="{{ route('programas.store') }}" method="POST">
                @csrf

                {{-- With prepend slot --}}
                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="codigo_programa" label="Codigo Programa"
                        placeholder="Codigo programa" label-class="text-lightblue" value="{{ old('codigo_programa') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                             <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="nombre_programa" label="Nombre Programa"
                        placeholder="nombre programa" label-class="text-lightblue" value="{{ old('nombre_programa') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                             <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="fecha_programa" label="Fecha Programa" placeholder="DD/MM/AAAA"
                        label-class="text-lightblue"
                        value="{{ old('fecha_programa') }}"
                        enable-old-support="false" title="Puedes cambiar la fecha haciendo clic o escribiendo aquí.">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </x-slot>

                    </x-adminlte-input>
                    @error('fecha_programa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="descripcion" label="Descripción" placeholder="Descripción"
                        label-class="text-lightblue" value="{{ old('descripcion') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('descripcion')
                                                  <div class="error">{ { $message }}</div>
                                                  @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('programas.index') }}" class="btn btn-secondary">Regresar</a>
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
@stop

@section('js')
    <script></script>
@stop
