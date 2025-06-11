@extends('adminlte::page')

@section('title', 'Registrar Unidad Curricular')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nueva Unidad Curricular..</h4>
@stop

@section('content_header')
    <center>
        <h1>Agregar Unidad Curricular</h1>
    </center>
@stop

@section('content')

    <p> Ingrese la información del Unidad Curricular</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
            <form action="{{ route('unidades-curriculares.store') }}" method="POST">
                @csrf


                {{-- With prepend slot --}}
                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="codigo" label="Codigo Unidad Curricular"
                        placeholder="Codigo Unidad Curricular : SIN CARACTERES ESPECIALES -*/ " label-class="text-lightblue" value="{{ old('codigo') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                             <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="nombre" label="Nombre Unidad Curricular"
                        placeholder="Nombre unidad curricular" label-class="text-lightblue" value="{{ old('nombre') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                             <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>




                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="creditos" label="Creditos (UC)"
                        placeholder="numero entero" label-class="text-lightblue" value="{{ old('creditos') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                             <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>


                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="horas_semanales" label="Horas semanales (HRS.SEM)"
                        placeholder="numero entero" label-class="text-lightblue" value="{{ old('horas_semanales') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                             <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="horas_trabajo_asistidas" label="Horas Trabajo Asistidas (HTA)"
                        placeholder="numero entero" label-class="text-lightblue" value="{{ old('horas_trabajo_asistidas') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                             <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                


                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="horas_trabajo_independiente" label="Horas Trabajo Independiente (HTI)"
                        placeholder="numero entero" label-class="text-lightblue" value="{{ old('horas_trabajo_independiente') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                             <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="horas_trabajo_estudiantil" label="Horas Trabajo Estudiantil (HTE)"
                        placeholder="numero entero" label-class="text-lightblue" value="{{ old('horas_trabajo_estudiantil') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                             <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-12">

                    <x-adminlte-input class="col-md-6" name="eje" label="Eje"
                        placeholder="Ejemplo: PROFESIONAL" label-class="text-lightblue" value="{{ old('eje') }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                             <div class="error">{ { $message }}</div> //las dos llaves que estan abriendo deben estar juntas
                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>


                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="descripcion" label="Descripción" placeholder="Colocar una Distribución: trimestral, anual, semestral, por fase ( Fase 1, y Fase 2)"
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
                <a href="{{ route('unidades-curriculares.index') }}" class="btn btn-secondary">Regresar</a>
                </div>










            </form>

        </div>
    </div>

    {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - El campo Fecha Programa esta indicando la fecha actual, <br>
                    lo puedes cambiar pero usando el mismo formato DD/MM/AAAA. 
                </p>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept" data-dismiss="modal" />
            
        </x-slot>
    </x-adminlte-modal>
    {{-- Example button to open modal --}}
    <x-adminlte-button label="Leer Instructivo" data-toggle="modal" data-target="#modalCustom" class="bg-teal" />

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script></script>
@stop
