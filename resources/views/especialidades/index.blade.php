@extends('adminlte::page')

@section('title', 'Lista de Especialiadades')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Especialidades..</h4>
@stop


@section('content_header')
    <center>
        <h1>Lista de Especialidades </h1>
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
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <!-- *************************************NO TOCAR***************************** -->

        {{-- Setup data for datatables --}}
        <div class="botones">
            <a href="{{ route('especialidades.create') }}" class="btn btn-primary ml-2"> Agrega aqui una nueva
                especialidad</a>
        </div>
        @php
            $heads = [
                'ID',
                'Codigo Especialidad',
                'Nombre Especialidad',
                'Duracion',
                'Titulo',
           
                ['label' => 'Acciones', 'no-export' => true, 'width' => 20],
            ];

            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
            $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar esta especialidad">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                   <i class="fa fa-lg fa-fw fa-eye"></i>
               </button>';

            $config = [
                'language' => [
                    'url' => 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json',
                ],
            ];

        @endphp

        {{-- Minimal example / fill data using the component slot :config="$config" --}}
        <x-adminlte-datatable id="table5" :heads="$heads" :config="$config" theme="light" striped hoverable>


            @foreach ($especialidades as $especialidad)
                <tr>
                    <td>{{ $especialidad->id }}</td>
                    <td>{{ $especialidad->codigo_especialidad }}</td>
                    <td>{{ $especialidad->nombre_especialidad }}</td>
                    <!--  <td>{ { $especialidad->titulo }}</td> -->
                    {{-- Este @forelse es seguro porque maneja el caso de colección vacía --}}
                    <td>{{ $especialidad->duracion }}</td>
     {{-- INICIO DEL BLOQUE CORREGIDO PARA MOSTRAR LOS TÍTULOS --}}
                    <td>
                        @if($especialidad->titulos->isNotEmpty())
                            <ul> {{-- Usamos una lista no ordenada para listar los títulos --}}
                                @foreach($especialidad->titulos as $titulo)
                                    <li>{{ $titulo->nombre }} ({{ $titulo->duracion }} )</li>
                                @endforeach
                            </ul>
                        @else
                            No hay títulos asociados
                        @endif
                    </td>
                    
                     <!--<td>{ { $especialidad->descripcion }}</td>-->
                    <td><a href="{{ route('especialidades.edit', $especialidad) }}"
                            class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar esta especialidad">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>
                        <a href="{{ route('especialidades.show', $especialidad) }}"
                            class="btn btn-xs btn-default text-primary mx-1 shadow" title="Ver detalles de la especialidad">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </a>
                        <form style="display: inline" action="{{ route('especialidades.destroy', $especialidad) }}"
                            method="POST" class="formEliminar">
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
                <p> - El boton lapiz lleva a otra interfaz llamada editar especialidad<br>
                    - El botón del ojo lleva a una vista donde se ven los detalles de la especialidad:
                    - A que programas esta asociada . <br>
                    - Cuantos trayectos tiene.
                    - Titulo o titulos que se otorgan<br><br>
                    - El boton papelera elimina, primero pregunta si desea eliminar
                    el registro, luego lo elimina y envia una notifiacion en la <b>interfaz</b>
                    lista de especialidades de que el registro ha sido eliminado.<br><br>
                    - <b>Duración por Titulo:</b><br>
                    -Trayecto I- Certificado de Asistente Contable<br>
                    -Trayecto II - TSU en Contaduria Pública<br>
                    -Trayecto IV - Licenciado en Contaduria Publica<br>
                    -Trayecto IV - Ingeniero en Electricidad<br>
                    -Trayecto IV - Ingeniero en Mantenimiento<br>
                    -Trayecto IV - Licenciado en Administración<br>
                </p>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept" data-dismiss="modal" />
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


            /*$(document).on('submit', '.formEliminar', function(e) { // Usar .on() para delegación
                e.preventDefault();
                var form = $(this);
                $.confirm({
                    title: 'Estas Seguro?',
                    text: "No podras Revegjgjgrtir esta acción, Se eliminara un registro",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrarlo!',
                    success: function() {
                        form.submit();
                    },
                    cancel: function() {
                        // No hacer nada si se cancela
                    }
                })
            })*/






        })
    </script>
@stop

@section('js')

    <script></script>

@stop
