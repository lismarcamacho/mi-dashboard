@extends('adminlte::page')

@section('title', 'Registrar Especialidad')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nueva Especialidad..</h4>
@stop

@section('content_header')
    <center>
        <h1>Agregar Especialidad</h1>
    </center>
@stop

@section('content')

    <p> Ingrese la información de la Especialidad</p>

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
            <form action="{{ route('especialidades.store') }}" method="POST">
                @csrf



                {{-- With prepend slot --}}
                <x-adminlte-input class="col-md-6" name="codigo_especialidad" label="Codigo Especialidad"
                    placeholder="codigo especialidad" label-class="text-lightblue" value="{{ old('codigo_especialidad') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class=" text-darkblue"></i>
                            <!-- @ error('codigo_carrera')
                            <div class="error">{ { $message }}</div>
                          @ enderror -->
                        </div>
                    </x-slot>
                </x-adminlte-input>


                <x-adminlte-input class="col-md-6" name="nombre_especialidad" label="Nombre Especialidad"
                    placeholder="nombre especialidad" label-class="text-lightblue" value="{{ old('nombre_especialidad') }}">
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
                        <option>ASISTENTE CONTABLE</option>
                        <option selected>TSU EN CONTADURÍA PUBLICA </option>
                        <option selected>LICENCIADO EN CONTADURÍA PUBLICA</option>
                        <option>ASISTENTE ADMINISTRATIVO</option>
                        <option selected>TSU EN ADMINISTRACIÓN </option>
                        <option selected>LICENCIADO EN ADMINISTRACIÓN</option>
                        <option selected>INGENIERO EN ELECTRICIDAD</option>
                        <option selected>INGENIERO DE MANTENIMIENTO</option>
                    </x-adminlte-select>
                    <!-- @ error('titulo')
                    <div class="error">{ { $message }}</div>
                @ enderror-->
                </div>

                <!-- EL metodo old permite mantener los datos cuando se recarga el formulario por errores del usuario cuando se valida el formulario -->
                <x-adminlte-input class="col-md-6" name="duracion_x_titulo" label="Duracion por Titulo"
                    placeholder="Duracion por Titulo" label-class="text-lightblue" value="{{ old('duracion_x_titulo') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class=" text-darkblue"></i>
                            <!-- @ error('duracion_x_titulo')
                             <div class="error">{ { $message }}</div>
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
                <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Cancelar</a>




            </form>

        </div>


    </div>

    {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - El boton lapiz lleva a otra interfaz llamada editar especialidad<br>
                    - El boton papelera elimina, primero pregunta si desea eliminar
                    el registro, luego lo elimina y envia una notifiacion en la <b>interfaz</b>
                    lista de especialidades
                    de que el registro ha sido eliminado</p>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script></script>
@stop
