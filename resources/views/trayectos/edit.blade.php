@extends('adminlte::page')

@section('title', 'Editar Trayecto')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Editar Trayecto..</h4>
@stop

@section('content_header')
    <center>
        <h1>Editar Trayecto</h1>
    </center>
@stop

@section('content')

    <p> Modifique la información del Trayecto</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- El resto de tu contenido de la vista --}}

    <div class="card">


        <div class="card-body">
            <form action="{{ route('trayectos.update', $trayecto) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->


                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->


                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="nombre_trayecto" label="Nombre"
                        label-class="text-lightblue" value="{{ $trayecto->nombre_trayecto }}">
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
                    @foreach($especialidades as $especialidad)
                    <x-adminlte-input class="col-md-6" name="{{ $especialidad->nombre_especialidad}}" label=""
                        label-class="text-lightblue" value="{{ $especialidad->nombre_especialidad}}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                                             <div class="error">{ { $message }}</div>
                                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    @endforeach
                </div>


    


                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="descripcion" label="Descripcion" label-class="text-lightblue"
                        value="{{ $trayecto->descripcion }}">
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
                <a href="{{ route('trayectos.index') }}" class="btn btn-secondary">Regresar</a>




            </form>

        </div>
    </div>

        {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - 
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
