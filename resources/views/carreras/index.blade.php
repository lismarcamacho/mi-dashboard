@extends('adminlte::page')

@section('title', 'Lista de Especialiadades')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Especialidades..</h4>
@stop


@section('content_header')
    <center>
        <h1>Lista de Especialidades</h1>
    </center>
@stop

@section('content')

    <!--  {{ $carreras }} Nada mas con esta directiva puedo SABER si la informacion registrada esta llegando a la vista-->
    <div class="container"
        style="margin-top: 3%; background-color: #fff; box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1rem;">
        <center>
            <h3 tyle="margin-top: 10%; "></h3>
        </center>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Setup data for datatables --}}

        <div class="botones">
                <a href="{{ route('carreras.create') }}" class="btn btn-primary ml-2"> Agrega aqui una nueva especialidad</a>
        </div>
        @php
            $heads = [
                'ID',
                'Nombre Especialidad',
                'Codigo Especialidad',
                'Titulo',
                'Duración por titulo',
                'Descripción',
                ['label' => 'Actions', 'no-export' => true, 'width' => 10],



            ];

            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
            $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';
            
               $config=[
                'language'=>[
                    'url'=>'//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json',
                ]

            ];

        @endphp

        {{-- Minimal example / fill data using the component slot --}}
        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
                @foreach ($carreras as $carrera)
                    <tr>
                        <td>{{ $carrera->id }}</td>
                        <td>{{ $carrera->codigo_carrera }}</td>
                        <td>{{ $carrera->nombre_carrera }}</td>
                        <td>{{ $carrera->titulo }}</td>
                        <td>{{ $carrera->duracion_x_titulo }}</td>
                        <td>{{ $carrera->descripcion }}</td>
                        <td>{!!$btnEdit!!}{!!$btnDelete!!} </td>

                    </tr>
                @endforeach
        </x-adminlte-datatable>

     





    </div>

@endsection

@section('css')
    {{-- Tus estilos CSS opcionales --}}
    <style>
        /* Estilos para el tema oscuro */
        body.dark-theme .element.style,
        [data-theme="dark"] .element.style {
            color: white;
            background-color: #333;
            /* Un gris oscuro */
            border-color: #555;
        }


        .botones {

            margin-left: 0%;
            margin-top: 1%;
            margin-block-end: inherit;


        }

        .form-group {}

        .buscar {
            margin-top: -5%;
        }
    </style>
@stop

@section('js')
    {{-- Tu JavaScript opcional --}}
@stop
