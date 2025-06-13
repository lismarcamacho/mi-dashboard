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
            <a href="{{ route('mallas-curriculares.create') }}" class="btn btn-primary ml-2"> Agrega aqui una nueva Malla
                Curricular</a>
        </div>
        @php

            $heads = [
                'ID',
                'Nombre Malla',
                'Especialidad',
                'Trayecto',
                'Duracion',
                'Total de Creditos',
                'Fase malla',
                'Tipo Uc en malla',
                'Año E vigencia',
                'Ano S vigencia',

                ['label' => 'Acciones', 'no-export' => true, 'width' => 20],
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

        @endphp

        {{-- Minimal example / fill data using the component slot :config="$config" --}}
        <x-adminlte-datatable id="table5" :heads="$heads" :config="$config" theme="light" striped hoverable>


            @foreach ($mallasCurriculares as $mallaCurricular)
                <tr>
                    <td>{{ $mallaCurricular->id }}</td>
                    {{-- Accede al nombre de la especialidad a través de la relación --}}

                    <td>{{ $mallaCurricular->nombre }}</td>
                    {{-- Accede al nombre de la especialidad a través de la relación --}}
                    <td>
                        @if ($mallaCurricular->especialidad)
                            {{-- Asegúrate de que la relación existe para evitar errores si es null --}}
                            {{ $mallaCurricular->especialidad->nombre_especialidad ?? 'N/A' }}{{-- Asumiendo que la columna se llama 'nombre' en Especialidad --}}
                        @else
                            N/A
                        @endif
                    </td>
                    {{-- Accede al nombre de la unidad curricular a través de la relación --}}
                    <!--  <td>
                            @ if ($mallaCurricular->unidadCurricular)
                                { { $mallaCurricular->unidadCurricular->codigo }} -
                                { { $mallaCurricular->unidadCurricular->nombre }}
                            @ else
                                N/A
                            @ endif
                        </td>  -->
                    {{-- Accede al nombre del trayecto a través de la relación --}}
                    <td>
                        {{-- **CÓMO MOSTRAR LOS TRAYECTOS ASOCIADOS (RELACIÓN N:M)** --}}
                        @if ($mallaCurricular->trayectos->isNotEmpty())
                            <ul>
                                @forelse($mallaCurricular->trayectos as $trayecto)
                                    {{ $trayecto->nombre_trayecto }}@unless ($loop->last), @endunless
                            @empty
                                Ningún Trayecto Asignado
                            @endforelse
                        </ul>
                    @else
                        Ningun Trayecto asociado aún
                    @endif
                </td>
                <td>{{ $mallaCurricular->duracion_en_malla }}</td>
                <td>{{ $mallaCurricular->creditos_en_malla }}</td>
                <td>{{ $mallaCurricular->fase_malla }}</td>
                <td>{{ $mallaCurricular->tipo_uc_en_malla }}</td>
                <td>{{ $mallaCurricular->anio_de_vigencia_de_entrada_malla }}</td>
                <td>{{ $mallaCurricular->anio_salida_vigencia }}</td>

                <td><a href="{{ route('mallas-curriculares.edit', $mallaCurricular->id) }}"
                        class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>
                    <form style="display: inline"
                        action="{{ route('mallas-curriculares.destroy', $mallaCurricular->id) }}" method="POST"
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
            <p> - El boton lapiz lleva a otra interfaz llamada editar Malla Curricular<br>
                - El boton papelera elimina, primero pregunta si desea eliminar
                el registro, luego lo elimina y envia una notifiacion en la <b>interfaz</b>
                lista de Mallas Curriculares
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

@section('css')

<script>
    /* En tu archivo CSS o en una etiqueta <style> en tu vista */
    .datatable th,
    .datatable td {
        white - space: nowrap; /* Evita que el texto se ajuste en varias líneas */
        padding: 8 px 15 px; /* Ajusta el padding para más espacio */
    }

    .datatable th: nth - child(2), /* Por ejemplo, la segunda columna (Especialidad) */
        .datatable td: nth - child(2) {
            min - width: 200 px; /* Ancho mínimo para la columna de especialidad */
        }

        .datatable th: nth - child(3), /* Por ejemplo, la tercera columna (Unidad Curricular) */
        .datatable td: nth - child(3) {
            min - width: 250 px; /* Ancho mínimo para la columna de unidad curricular */
        }
</script>

@stop

@section('js')

<script></script>

@stop
