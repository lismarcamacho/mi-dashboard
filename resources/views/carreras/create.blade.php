@extends('adminlte::page')

@section('title', 'Crear Carrera')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nueva Carrera..</h4>
@stop

@section('content_header')
    <center><h1>Agregar Nueva Carrera</h1></center>
@stop

@section('content')

    <p> Ingrese la información de la Carrera</p>

{{-- El resto de tu contenido de la vista --}}
    <form action="{{ route('carreras.store') }}" method="POST">
        @csrf



        {{-- With prepend slot --}}
        <x-adminlte-input  class="col-md-6" name="codigo_carrera" label="Codigo Carrera" placeholder="codigo carrera" label-class="text-lightblue" value="{{old('codigo_carrera')}}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class=" text-darkblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>


        <x-adminlte-input  class="col-md-6" name="nombre_carrera" label="Nombre Carrera" placeholder="nombre carrera" label-class="text-lightblue" value="{{old('nombre_carrera')}}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class=" text-darkblue"></i>  
                </div>
            </x-slot>
        </x-adminlte-input>


        <div class="row">

        <x-adminlte-select name="titulo" label="Titulo a obtener:"   fgroup-class="col-md-6" >
            <option>ASISTENTE CONTABLE</option>
            <option selected>TSU EN CONTADURIA PUBLICA </option>
            <option selected>LICENCIADO EN CONTADURIA PUBLICA</option>

        </x-adminlte-select>

        </div>
        

        <x-adminlte-input  class="col-md-6" name="duracion_x_titulo" label="Duracion por Titulo" placeholder="Duracion por Titulo" label-class="text-lightblue" value="{{old('duracion_x_titulo')}}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class=" text-darkblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input  class="col-md-6" name="descripcion" label="Descripcion" placeholder="Descripcion" label-class="text-lightblue" value="{{old('descripcion')}}">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class=" text-darkblue"></i>
                </div>
            </x-slot>
        </x-adminlte-input>





      

        <button type="submit" class="btn btn-primary">Guardar Carrera</button>
        <a href="{{ route('carreras.index') }}" class="btn btn-secondary">Cancelar</a>



        
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>


@stop
