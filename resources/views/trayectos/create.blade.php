@extends('adminlte::page')

@section('title', 'Agregar Trayecto')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nuevo Trayecto..</h4>
@stop

@section('content_header')
    <center>
        <h1>Agregar Trayecto</h1>
    </center>
@stop

@section('content')

    <p> Ingrese la información del Trayecto</p>

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
            <form action="{{ route('trayectos.store') }}" method="POST">
                @csrf

                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="numero_orden" label="Numero orden" placeholder="Numero Orden"
                        label-class="text-lightblue" value="{{ old('numero_orden') }}">
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

                    <x-adminlte-input class="col-md-6" name="nombre_trayecto" label="Nombre " placeholder="nombre"
                        label-class="text-lightblue" value="{{ old('nombre_trayecto') }}">
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

   

                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="descripcion" label="Descripcion" placeholder="Descripcion"
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
                    <a href="{{ route('trayectos.index') }}" class="btn btn-secondary">Cancelar</a>
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
                <p> - , <br>
                    
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
