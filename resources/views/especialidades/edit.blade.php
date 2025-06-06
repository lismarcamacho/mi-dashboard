@extends('adminlte::page')

@section('title', 'Editar Especialidad')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Editar Especialidad..</h4>
@stop

@section('content_header')
    <center>
        <h1>Editar Especialidad</h1>
    </center>
@stop

@section('content')

    <p> Modifique la información de la Especialidad</p>

    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- El resto de tu contenido de la vista --}}

    <div class="card">


        <div class="card-body">
            <form action="{{ route('especialidades.update', $especialidad) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->


                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->


                {{-- With prepend slot --}}
                <x-adminlte-input class="col-md-6" name="codigo_especialidad" label="Codigo Especialidad"
                    label-class="text-lightblue" value="{{ $especialidad->codigo_especialidad }}">
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
                    label-class="text-lightblue" value="{{ $especialidad->nombre_especialidad }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class=" text-darkblue"></i>
                            <!-- @ error('nombre_carrera')
                                         <div class="error">{ { $message }}</div>
                                          @ enderror -->
                        </div>
                    </x-slot>
                </x-adminlte-input>




             <!--    <x-adminlte-input class="col-md-6" name="titulo" label="Titulo" label-class="text-lightblue"
                    value="{ { $especialidad->titulo }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class=" text-darkblue"></i>
                           
                        </div>
                    </x-slot>
                </x-adminlte-input>   -->



                <!-- EL metodo old permite mantener los datos cuando se recarga el formulario por errores del usuario cuando se valida el formulario -->
                <x-adminlte-input class="col-md-6" name="duracion" label="Duracion "
                    label-class="text-lightblue" value="{{ $especialidad->duracion }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class=" text-darkblue"></i>
                            <!-- @ error('duracion_x_titulo')
                                                                 <div class="error">{ { $message }}</div>
                                                                  @ enderror -->
                            </div>
                        </x-slot>
                </x-adminlte-input>

                

                <x-adminlte-input class="col-md-6" name="descripcion" label="Descripcion" label-class="text-lightblue"
                        value="{{ $especialidad->descripcion }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('descripcion')
                                                                  <div class="error">{ { $message }}</div>
                                                                  @ enderror -->
                            </div>
                        </x-slot>
                </x-adminlte-input>





                <button type="submit" class="btn btn-primary" id="Edit">Actualizar</button>
                <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Cancelar</a>




            </form>

        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

<@section('js')

    @if (session('success'))
     <script>
         $(document).ready(function() {
             let mensaje = "{{ session ('success') }}";
             Swal.fire({
                 title: 'Resultado',
                 text: mensaje,
                 icon: 'success'
             })
         })
     </script>
    @endif 
@stop 


<@section('js')
    <script>
        $(document).ready(function() {
            console.log('¡jQuery se integró correctamente!');
        })
    </script>
@stop 


