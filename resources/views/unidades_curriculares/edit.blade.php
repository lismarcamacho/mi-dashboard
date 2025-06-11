@extends('adminlte::page')

@section('title', 'Editar Unidad Curricular')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Editar Unidad Curricular..</h4>
@stop

@section('content_header')
    <center>
        <h1>Editar Unidad Curricular</h1>
    </center>
@stop

@section('content')

    <p> Modifique la información de la Unidad Curricular</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- El resto de tu contenido de la vista --}}

    <div class="card">


        <div class="card-body">
            <form action="{{ route('unidades-curriculares.update', $unidadCurricular) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->


                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->


                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="codigo" label="Codigo Unidad Curricular"
                        label-class="text-lightblue" value="{{ $unidadCurricular->codigo }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                                             <div class="error">{ { $message }}</div>
                                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>

                </div>

                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="nombre" label="Nombre Unidad Curricular"
                        label-class="text-lightblue" value="{{ $unidadCurricular->nombre}}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                                             <div class="error">{ { $message }}</div>
                                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="creditos" label="creditos"
                        label-class="text-lightblue" value="{{ $unidadCurricular->creditos}}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                                             <div class="error">{ { $message }}</div>
                                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="horas_semanales" label="horas_semanales"
                        label-class="text-lightblue" value="{{ $unidadCurricular->horas_semanales}}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                                             <div class="error">{ { $message }}</div>
                                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>



                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="horas_trabajo_asistidas" label="horas_trabajo_asistidas"
                        label-class="text-lightblue" value="{{ $unidadCurricular->horas_trabajo_asistidas}}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                                             <div class="error">{ { $message }}</div>
                                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="horas_trabajo_independiente" label="horas_trabajo_independiente"
                        label-class="text-lightblue" value="{{ $unidadCurricular->horas_trabajo_independiente}}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                                             <div class="error">{ { $message }}</div>
                                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>


                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="horas_trabajo_estudiantil" label="horas_trabajo_estudiantil"
                        label-class="text-lightblue" value="{{ $unidadCurricular->horas_trabajo_estudiantil}}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                                             <div class="error">{ { $message }}</div>
                                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="eje" label="eje"
                        label-class="text-lightblue" value="{{ $unidadCurricular->eje}}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                                             <div class="error">{ { $message }}</div>
                                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>



    


                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="descripcion" label="Descripcion" label-class="text-lightblue"
                        value="{{ $unidadCurricular->descripcion }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('descripcion')
                                                                                      <div class="error">{ { $message }}</div>
                                                                                      @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>

                <button type="submit" class="btn btn-primary" id="Edit">Actualizar</button>
                <a href="{{ route('unidades-curriculares.index') }}" class="btn btn-secondary">Regresar</a>




            </form>

        </div>
    </div>

        {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - El campo Fecha Programa lo puedes cambiar, pero usando el mismo formato DD/MM/AAAA. 
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


<!-- ESTE CODIGO FUNCIONA PERFECTAMENTE-->
<!-- 
<@ section('js') @ if (session('success'))
    <script>
        $(document).ready(function() {
            let mensaje = "{ { session('success') }}";
            Swal.fire({
                title: 'Resultado',
                text: mensaje,
                icon: 'success'
            })
        })
    </script>
    @ endif
@ stop
-->

<@section('js') <script>
    $(document).ready(function() {
        console.log('¡jQuery se integró correctamente!');
    })
</script>
@stop
