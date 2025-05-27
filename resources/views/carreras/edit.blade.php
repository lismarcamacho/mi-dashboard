@extends('adminlte::page')

@section('title', 'Registrar Especialidad')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Editar Especialidad..</h4>
@stop

@section('content_header')
    <center>
        <h1>Editar Especialidad</h1>
    </center>
@stop

@section('content')

    <p> Modifique la información de la Especialidad</p>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

    {{-- El resto de tu contenido de la vista --}}

    <div class="card">


        <div class="card-body">
            <form action="{{ route('carreras.update', $carrera) }}" method="POST">
                @csrf


                @method('PUT')


                {{-- With prepend slot --}}
                <x-adminlte-input class="col-md-6" name="codigo_carrera" label="Codigo Especialidad"
                    label-class="text-lightblue" value="{{$carrera->codigo_carrera}}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class=" text-darkblue"></i>
                            <!-- @ error('codigo_carrera')
                        <div class="error">{ { $message }}</div>
                      @ enderror -->
                        </div>
                    </x-slot>
                </x-adminlte-input>


                <x-adminlte-input class="col-md-6" name="nombre_carrera" label="Nombre Especialidad"
                     label-class="text-lightblue" value="{{$carrera->nombre_carrera}}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class=" text-darkblue"></i>
                            <!-- @ error('nombre_carrera')
                     <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                      @ enderror -->
                        </div>
                    </x-slot>
                </x-adminlte-input>
                

                <div class="row">

                    <x-adminlte-select name="titulo" label="Titulo a obtener:" fgroup-class="col-md-6">
                        <option value="{{$carrera->titulo}}"></option>
                        <option value="Asistente Contable">ASISTENTE CONTABLE</option>
                        <option value="Tsu en Contaduria Publica">TSU EN CONTADURIA PUBLICA </option>
                        <option value="Licenciado en Contaduria Publica">LICENCIADO EN CONTADURIA PUBLICA</option>
                        <option value="Ingeniero en Electricidad">INGENIERO EN ELECTRICIDAD</option>
                    </x-adminlte-select>
                    <!-- @ error('titulo')
                <div class="error">{ { $message }}</div>
            @ enderror-->
                </div>

                <!-- EL metodo old permite mantener los datos cuando se recarga el formulario por errores del usuario cuando se valida el formulario -->
                <x-adminlte-input class="col-md-6" name="duracion_x_titulo" label="Duracion por Titulo"
                     label-class="text-lightblue" value="{{$carrera->duracion_x_titulo}}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class=" text-darkblue"></i>
                            <!-- @ error('duracion_x_titulo')
                         <div class="error">{ { $message }}</div>
                          @ enderror -->
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input class="col-md-6" name="descripcion" label="Descripcion" 
                    label-class="text-lightblue" value="{{$carrera->descripcion}}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class=" text-darkblue"></i>
                            <!-- @ error('descripcion')
                          <div class="error">{ { $message }}</div>
                          @ enderror -->
                        </div>
                    </x-slot>
                </x-adminlte-input>





                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Cancelar</a>




            </form>

        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop