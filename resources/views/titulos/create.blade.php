@extends('adminlte::page')

@section('title', 'Registrar Titulo')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nuevo Titulo..</h4>
@stop

@section('content_header')
    <center>
        <h1>Agregar Titulo</h1>
    </center>
@stop

@section('content')

    <p> Ingrese la información del Titulo</p>

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
            <form action="{{ route('titulos.store') }}" method="POST">
                @csrf





                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="nombre" label="Nombre " placeholder="nombre"
                        label-class="text-lightblue" value="{{ old('nombre') }}">
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


                <!--<div class="col-md-12">
                                        @ foreach($especialidades as $especialidad)
                                            <x-adminlte-select name="titulo" label="Especialidad:" fgroup-class="col-md-6">
                                                <option>{ { $especialidad->nombre}}</option>
                                            </x-adminlte-select>
                                       @ endforeach
                                    </div> -->

                <div class="col-md-12 ">
                    {{-- {{ dd($role) }}  --}}
                    {{-- {{ {{dd($role->permissions)}}  --}}

                    <label for="especialidad_id">Especialidad</label>

                    <x-adminlte-select id="especialidad_id" name="especialidad_id"
                        class="col-md-6 block w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione una Especialidad</option>
                        @foreach ($especialidades as $especialidad)
                            <option value="{{ $especialidad->id }}">{{ $especialidad->nombre_especialidad }}</option>
                        @endforeach
                    </x-adminlte-select>

                    @error('{{ $especialidad->id }}')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                </div>









                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="duracion" label="Duracion" placeholder="Duracion"
                        label-class="text-lightblue" value="{{ old('duracion') }}">
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
                    <a href="{{ route('titulos.index') }}" class="btn btn-secondary">Cancelar</a>
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
