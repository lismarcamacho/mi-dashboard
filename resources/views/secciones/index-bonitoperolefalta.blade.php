@extends('adminlte::page')

@section('title', 'Gestionar Secciones')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Secciones..</h4>
@stop

@section('content_header')
    <h1 class="m-0 text-dark">Gestionar Secciones</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Secciones</h3>
                    <div class="card-tools">
                        <a href="{{ route('secciones.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Añadir Nueva Sección
                        </a>
                    </div>
                </div>
                <div class="card-body">
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

                    <table id="secciones_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de Sección</th>
                                <th>Capacidad Máxima</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($secciones as $seccion)
                                <tr>
                                    <td>{{ $seccion->id }}</td>
                                    <td>{{ $seccion->nombre }}</td>
                                    <td>{{ $seccion->capacidad_maxima }}</td>
                                    <td>{{ $seccion->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('secciones.edit', $seccion) }}"
                                            class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar">
                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                        </a>
                                        <a href="{{ route('secciones.show', $seccion) }}"
                                            class="btn btn-xs btn-default text-primary mx-1 shadow" title="Detalles">
                                            <i class="fa fa-lg fa-fw fa-eye"></i>
                                        </a>
                                        <form style="display: inline" action="{{ route('secciones.destroy', $seccion) }}"
                                             method="POST" class="formEliminar">
                                             @csrf 
                                             @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                class="btn btn-xs btn-default text-primary mx-1 shadow" title="Eliminar">

                                                <i class="fa fa-lg fa-fw fa-trash"></i>
                                            </button>



                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(document).ready(function() {
                    $('#secciones_table').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" // Para traducir DataTables
                        }
                    });

                    $('.formEliminar').submit(function(e) {
                        // Evita que el formulario se envíe de inmediato de forma predeterminada.
                        // Esto nos da control para mostrar la confirmación.
                        e.preventDefault();

                        // Almacena una referencia al formulario que se está enviando actualmente.
                        // 'this' dentro de la función de submit de jQuery se refiere al elemento DOM del formulario.
                        var form = this;

                        // Muestra el cuadro de diálogo de confirmación de SweetAlert2.
                        Swal.fire({
                            title: "¿Estás Seguro?",
                            text: "¡No podrás revertir esta acción, se eliminará un registro!", // Mensaje más descriptivo
                            icon: "warning", // Muestra un icono de advertencia
                            showCancelButton: true, // Muestra el botón "Cancelar"
                            confirmButtonColor: "#3085d6", // Color azul para el botón de confirmación
                            cancelButtonColor: "#d33", // Color rojo para el botón de cancelación
                            confirmButtonText: "Sí, ¡eliminarlo!", // Texto del botón de confirmación
                            cancelButtonText: "Cancelar" // Texto del botón de cancelación
                        }).then((result) => {
                            // Se ejecuta después de que el usuario hace clic en un botón del diálogo de SweetAlert2.
                            // 'result.isConfirmed' es true si el usuario hizo clic en "Sí, eliminarlo!".
                            if (result.isConfirmed) {
                                // Si el usuario confirma, envía el formulario original.
                                // 'form.submit()' envía el formulario de manera programática.
                                form.submit();
                            }
                        });
                    });
    </script>
@endpush
