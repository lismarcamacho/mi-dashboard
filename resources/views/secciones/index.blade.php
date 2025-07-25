@extends('adminlte::page')

@section('title', 'Lista de Secciones')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Secciones..</h4>
@stop


@section('content_header')
    <center>
        <h1>Lista de Secciones</h1>
    </center>
@stop

@section('content')

    <!--  { { $carreras }} Nada mas con esta directiva puedo SABER si la informacion registrada esta llegando a la vista-->
    <div class="container"
        style="margin-top: 3%; background-color: #fff; box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1rem;">
        <center>
            <h3 tyle="margin-top: 10%; "></h3>
        </center>

        <!-- NO TOCAR : SIN ESTA DIRECTIVA NO SE VAN A ENVIAR LAS NOTIFICACIONES DE GUARDADO, ELIMINACION, EDICION,ECT -->
        @if (session('success'))
            <x-adminlte-alert theme="success" title="Éxito" dismissable>
                {{ session('success') }}
            </x-adminlte-alert>
        @endif
        @if (session('error'))
            <x-adminlte-alert theme="danger" title="Error" dismissable>
                {{ session('error') }}
            </x-adminlte-alert>
        @endif
        <!-- *************************************NO TOCAR***************************** -->

        {{-- Setup data for datatables --}}
        <div class="botones">
            <a href="{{ route('secciones.create') }}" class="btn btn-primary ml-2"> <i class="fas fa-plus"></i>Agrega aqui
                una nueva sección</a>
        </div>
        @php

            $heads = [
                'ID',
                'Nombre de Sección',
                'Capacidad Máxima',
                'Fecha de Creación',

                ['label' => 'Acciones', 'no-export' => true, 'width' => 10],
            ];

            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
            $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

            $config = [
                'language' => [
                    'url' => 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json',
                    'scrollCollapse' => true,
                ],
            ];

            $config['lengthMenu'] = [10, 50, 100, 500, 1000, 2000, 3000];

        @endphp




        {{-- Minimal example / fill data using the component slot :config="$config" --}}
        <x-adminlte-datatable id="table5" :heads="$heads" :config="$config" theme="light" striped hoverable>


            @foreach ($secciones as $seccion)
                <tr>
                    <td>{{ $seccion->id }}</td>
                    <td>{{ $seccion->nombre }}</td>
                    <td>{{ $seccion->capacidad_maxima }}</td>
                    <td>{{ $seccion->created_at->format('d/m/Y H:i') }}</td>

                    <td><a href="{{ route('secciones.edit', $seccion) }}"
                            class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>
                        <a href="{{ route('secciones.show', $seccion) }}"
                            class="btn btn-xs btn-default text-primary mx-1 shadow" title="Show">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </a>
                        <form style="display: inline" action="{{ route('secciones.destroy', $seccion) }}" method="POST"
                            class="formEliminar">
                            @csrf
                            @method('delete') {!! $btnDelete !!}

                        </form>

                    </td>

                </tr>
            @endforeach
        </x-adminlte-datatable>





    </div>
    {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - El boton lapiz lleva a otra interfaz llamada editar seccion<br>
                    - El boton papelera elimina, primero pregunta si desea eliminar
                    el registro, luego lo elimina y envia una notifiacion en la <b>interfaz</b>
                    lista de secciones
                    de que el registro ha sido eliminado</p>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept" />
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    {{-- Example button to open modal --}}
    <x-adminlte-button label="Leer Instructivo" data-toggle="modal" data-target="#modalCustom" class="bg-teal" />

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
    <script>
        // cuando el domunento este listo dispara la funcion
        $(document).ready(function() {

            if (!$.fn.dataTable.isDataTable('#table5')) {
                console.log('Ruta del idioma:',
                    'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'); // Ajusta la ruta

                $('#table5').DataTable({
                    // Tus opciones de DataTables aquí
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json' // Asegúrate de que esta ruta sea correcta
                    }
                });
            }



            $('.formEliminar').submit(function(e) { // cuando se activa el submit se activa otra funcion
                e.preventDefault();
                Swal.fire({
                    title: "Estas Seguro?",
                    text: "No podemos Revertir esta acción, Se eliminara un registro",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, borrarlo!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();

                    }
                })

            })

        })
    </script>
@stop

@section('js')

    <script></script>

@stop
