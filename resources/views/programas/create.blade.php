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
                <a href="{{ route('programas.index') }}" class="btn btn-secondary">Cancelar</a>




            </form>

        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
 
    </script>
@stop
