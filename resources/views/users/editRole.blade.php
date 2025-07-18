@extends('adminlte::page')

@section('title', 'Registrar Programa')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Roles..</h4>
@stop

@section('content_header')
    <center>
        <h1>Editar Rol</h1>
    </center>
@stop

@section('content')

    <p> Modifique la información del Rol</p>

    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- El resto de tu contenido de la vista --}}

    <div class="card">


        <div class="card-body">
            <form action="{{ route('roles.update', $role) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->


                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->



                <x-adminlte-input class="col-md-6" name="name" label="Nombre del Rol"
                    label-class="text-lightblue" value="{{ $role->name }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class=" text-darkblue"></i>
                            <!-- @ error('nombre_carrera')
                                         <div class="error">{ { $message }}</div>
                                          @ enderror -->
                        </div>
                    </x-slot>
                </x-adminlte-input>



                <button type="submit" class="btn btn-primary" id="Edit">Actualizar</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>




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


