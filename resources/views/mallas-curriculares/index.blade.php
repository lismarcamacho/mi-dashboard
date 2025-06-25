@extends('adminlte::page')

@section('title', 'Lista de Mallas Curriculares')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Mallas Curriculares..</h4>
@stop

@section('content_header')
    <center>
        <h1>Lista de Mallas Curriculares</h1>
    </center>
@stop

@section('content')

    <div class="container"
        style="margin-top: 3%; background-color: #fff; box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2); margin-bottom: 1rem;">
        <center>
            <h3></h3>
        </center>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="botones">
            <a href="{{ route('mallas-curriculares.create') }}" class="btn btn-primary ml-2"> Agrega aquí una nueva Malla Curricular</a>
        </div>

        @php
            $heads = [
                'ID',
                'Nombre Malla',
                'Especialidad',
                'Programa', // Añadido para mostrar el programa
                'Trayecto',
                'Duracion',
                'Total de Creditos',
                'Fase malla',
                'Tipo Uc en malla',
                'Año E vigencia',
                'Ano S vigencia',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 20],
            ];

            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>';
            $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>';
            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></button>';

            $config = [
                'language' => [
                    'url' => 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json',
                    'scrollCollapse' => true,
                ],
            ];
        @endphp

        <x-adminlte-datatable id="table5" :heads="$heads" :config="$config" theme="light" striped hoverable>
            @foreach ($mallasCurriculares as $mallaCurricular)
                <tr>
                    <td>{{ $mallaCurricular->id }}</td>
                    <td>{{ $mallaCurricular->nombre }}</td>
                    <td>
                        @if ($mallaCurricular->especialidad)
                            {{ $mallaCurricular->especialidad->nombre_especialidad ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if ($mallaCurricular->programa) {{-- Asegúrate de cargar la relación 'programa' en el controlador --}}
                            {{ $mallaCurricular->programa->nombre_programa ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if ($mallaCurricular->trayectos->isNotEmpty())
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                @forelse($mallaCurricular->trayectos as $trayecto)
                                    <li>{{ $trayecto->nombre_trayecto }}@unless ($loop->last), @endunless</li>
                                @empty
                                    <li>Ningún Trayecto Asignado</li>
                                @endforelse
                            </ul>
                        @else
                            Ningún Trayecto asociado aún
                        @endif
                    </td>
                    <td>{{ $mallaCurricular->duracion_en_malla }}</td>
                    <td>{{ $mallaCurricular->creditos_en_malla }}</td>
                    <td>{{ $mallaCurricular->fase_malla }}</td>
                    <td>{{ $mallaCurricular->tipo_uc_en_malla }}</td>
                    <td>{{ $mallaCurricular->anio_de_vigencia_de_entrada_malla }}</td>
                    <td>{{ $mallaCurricular->anio_salida_vigencia }}</td>

                    <td>
                        <a href="{{ route('mallas-curriculares.edit', $mallaCurricular->id) }}"
                            class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>
                        <form style="display: inline"
                            action="{{ route('mallas-curriculares.destroy', $mallaCurricular->id) }}" method="POST"
                            class="formEliminar">
                            @csrf
                            @method('delete')
                            {!! $btnDelete !!}
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>

    {{-- Custom Modal para Instrucciones --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - El botón lápiz lleva a otra interfaz llamada editar Malla Curricular<br>
                    - El botón papelera elimina, primero pregunta si desea eliminar el registro, luego lo elimina y envía una notificación en la <b>interfaz</b> lista de Mallas Curriculares de que el registro ha sido eliminado</p>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept" data-dismiss="modal" />
            <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>
    <x-adminlte-button label="Leer Instructivo" data-toggle="modal" data-target="#modalCustom" class="bg-teal" />

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    {{-- Estilos para el tema oscuro, movidos aquí --}}
    <style>
        body.dark-theme .element.style,
        [data-theme="dark"] .element.style {
            color: white;
            background-color: #333;
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

        /* Estilos para DataTables, movidos aquí */
        .datatable th,
        .datatable td {
            white-space: nowrap; /* Evita que el texto se ajuste en varias líneas */
            padding: 8px 15px; /* Ajusta el padding para más espacio */
        }

        .datatable th:nth-child(2),
        .datatable td:nth-child(2) {
            min-width: 200px; /* Ancho mínimo para la columna de especialidad */
        }

        .datatable th:nth-child(3),
        .datatable td:nth-child(3) {
            min-width: 250px; /* Ancho mínimo para la columna de unidad curricular */
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            console.log('¡jQuery se integró correctamente y DataTables listo!');

            // Inicialización de DataTables
            if (!$.fn.dataTable.isDataTable('#table5')) {
                $('#table5').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
                    }
                });
            }

            // Script para la confirmación de eliminación (formEliminar)
            $('.formEliminar').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Estás Seguro?",
                    text: "No podemos Revertir esta acción, ¡Se eliminará un registro!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, ¡borrarlo!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@stop