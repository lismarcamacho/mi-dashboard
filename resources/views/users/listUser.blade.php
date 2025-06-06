<!-- users/list-users.blade.php -->
@extends('adminlte::page')

@section('title', 'Lista de Usuarios')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Usuarios...</h4>
@stop

<!-- ***************************** En esta plantilla se VEN LAS LISTAS DE USUARIOS!!-->
@section('content_header')
    <center>
        <h1>Administración de Usuarios</h1>

    </center>
@stop

@section('content')

    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - Para asignar uno o mas roles, ingresa en el boton lapiz que lleva a otra interfaz. <br>
                    - El boton papelera elimina, primero pregunta si desea eliminar
                    el registro, luego lo elimina y envia una notifiacion en la <b>interfaz</b>
                    Administración de Usuarios de que el registro ha sido eliminado.</p>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Aceptar" data-dismiss="modal" />
            <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

    {{-- Example button to open modal --}}
    <x-adminlte-button label="Leer Instructivo" data-toggle="modal" data-target="#modalCustom" class="bg-teal" />

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

        @ role('Administrador')
        <div class="car-header">
            <x-adminlte-button label="Agrega un Nuevo Usuario" theme="primary" icon="fas fa-key" data-toggle="modal"
                data-target="#modalPurple" />
        </div>
        @ endrole
        {{-- Setup data for datatables --}}
        @php
            $heads = ['ID', 'Nombre', 'Email', 'Es Admin?',['label' => 'Acciones', 'no-export' => true, 'width' => 10]];

            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
            </button>';
            $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar este usuario">
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


            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->hasRole('Administrador'))
                            <span class="badge badge-success">Sí</span>
                        @else
                            <span class="badge badge-danger">No</span>
                        @endif
                    </td>
                    <td>@ role('Administrador')
                        <a href="{{ route('asignar.edit', $user) }}" class="btn btn-xs btn-default text-primary mx-1 shadow"
                            title="Asignar Roles a este usuario">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>
                        <form style="display: inline" action="{{ route('asignar.destroy', $user) }}" method="POST"
                            class="formEliminar" title="Eliminar este usuario">
                            @csrf
                            @method('delete') {!! $btnDelete !!}
                        @ endrole

                        </form>

                    </td>

                </tr>
            @endforeach
        </x-adminlte-datatable>

        
    </div>





    

    <div class="container" style="margin-top: 3%; margin-bottom: 1rem;">


        {{-- ESTE MODAL QUEDA OCULTO --}}
        <x-adminlte-modal id="modalPurple" title="Nuevo Usuario" theme="primary" icon="fas fa-bolt" size='lg'
            disable-animations>
            Ingrese el  Usuario
            {{-- With label, invalid feedback disabled, and form group class --}}


            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="row">
                    <x-adminlte-input name="nombre" label="Nombre" placeholder="Aqui su Rol" fgroup-class="col-md-6"
                        disable-feedback />

                </div>

                {{-- <x-slot name="footerSlot"> --}}
                <x-adminlte-button type="submit" class="mr-auto" theme="primary" icon="fas fa-key" label="Guardar" />
                {{--   <x-adminlte-button theme="danger" label="Cancelar" data-dismiss="modal" /> --}}
                {{-- </x-slot> --}}
            </form>




        </x-adminlte-modal>
        {{-- Example button to open modal --}}

    </div>



@endsection

@section('css')
    {{-- Tus estilos CSS opcionales --}}
    <style>
        /* Estilos para el tema oscuro */





        .car-header {

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
