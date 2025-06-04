@extends('adminlte::page')

@section('title', 'Registrar Programa')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Editar Programa..</h4>
@stop

@section('content_header')
    <center>
        <h1>Editar Programa</h1>
    </center>
@stop

@section('content')

    <p> Modifique la información del Programa</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- El resto de tu contenido de la vista --}}

    <div class="card">


        <div class="card-body">
            <form action="{{ route('programas.update', $programa) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->


                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->


                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="codigo_programa" label="Codigo Programa"
                        label-class="text-lightblue" value="{{ $programa->codigo_programa }}">
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
                    <x-adminlte-input class="col-md-6" name="nombre_programa" label="Nombre Programa"
                        label-class="text-lightblue" value="{{ $programa->nombre_programa }}">
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
                    <x-adminlte-input class="col-md-6" name="fecha_programa" label="Fecha Programa"
                        label-class="text-lightblue"
                        value="{{ old('fecha_programa', \Carbon\Carbon::parse($programa->fecha_programa)->format('d/m/Y')) }}"
                        enable-old-support="true" {{-- Para que old() funcione con AdminLTE components --}}>
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class=" text-darkblue"></i>
                                <!-- @ error('nombre_carrera')
                                                             <div class="error">{ { $message }}</div>
                                                              @ enderror -->
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    @error('fecha_programa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="col-md-12">
                    <x-adminlte-input class="col-md-6" name="descripcion" label="Descripcion" label-class="text-lightblue"
                        value="{{ $programa->descripcion }}">
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
                <a href="{{ route('programas.index') }}" class="btn btn-secondary">Regresar</a>




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
