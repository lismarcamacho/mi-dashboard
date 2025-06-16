@extends('adminlte::page')

@section('title', 'Modificar Estudiante')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Editar Estudiante..</h4>
@stop

@section('content_header')
    <center>
        <h1>Editar Estudiante</h1>
    </center>
@stop

@section('content')

    <p> Modifique la información del Estudiante</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- El resto de tu contenido de la vista --}}

    <div class="card">


        <div class="card-body">
            <form action="{{ route('estudiantes.update', $estudiante) }}" method="POST" id=FormEdit>
                @csrf <!-- NECESARIO PARA PODER HACER EL UPDATE -->

                @method('PUT') <!--NECESARIO PARA PODER HACER EL UPDATE  -->

                <div class="row"> {{-- Abre una nueva fila para las dos columnas --}}
                    <div class="col-md-6"> {{-- Columna izquierda (para datos personales, etc.) --}
                        {{-- Cédula --}}
                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}

                            <x-adminlte-input class="col-md-6" name="cedula" label="Cédula" placeholder="18594461"
                                label-class="text-lightblue" value="{{ $estudiante->cedula }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class=" text-darkblue"></i>

                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('cedula')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}

                            <x-adminlte-input class="col-md-6" name="apellidos_nombres" label="Apellidos y Nombres"
                                placeholder="Apellidos y Nombres" label-class="text-lightblue"
                                value="{{ $estudiante->apellidos_nombres }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class=" text-darkblue"></i>

                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('apellidos_nombres')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}


                            <x-adminlte-input class="col-md-6" name="telefono" label="Teléfono" placeholder="telefono"
                                label-class="text-lightblue" value="{{ $estudiante->telefono }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class=" text-darkblue"></i>

                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('telefono')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}

                            <x-adminlte-input class="col-md-6" name="fecha_nacimiento" label="Fecha Nacimiento"
                                placeholder="DD/MM/AAAA" label-class="text-lightblue"
                                value="{{ old('fecha_nacimiento', \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('d/m/Y')) }}"
                                enable-old-support="true" {{-- Para que old() funcione con AdminLTE components --}}>
                            
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-info">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>

                            </x-adminlte-input>
                            @error('fecha_nacimiento')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>{{--  FIN Columna izquierda (para datos personales, etc.) --}}

                    <div class="col-md-6"> {{-- Columna izquierda (para datos personales, etc.) --}}

                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}

                            <x-adminlte-input class="col-md-6" name="email" label="Correo"
                                placeholder="email" label-class="text-lightblue"
                                value="{{ $estudiante->email }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class=" text-darkblue"></i>

                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- sede --}}
                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}


                            <x-adminlte-input class="col-md-6" name="sede" label="SEDE" placeholder="ANACO"
                                label-class="text-lightblue" value="{{ $estudiante->sede }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class=" text-darkblue"></i>

                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('sede')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}


                            <x-adminlte-input class="col-md-6" name="municipio" label="MUNICIPIO" placeholder="ANACO"
                                label-class="text-lightblue" value="{{ $estudiante->municipio }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class=" text-darkblue"></i>

                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('municipio')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}

                            <x-adminlte-input class="col-md-6" name="parroquia" label="PARROQUIA" placeholder="ANACO"
                                label-class="text-lightblue" value="{{ $estudiante->parroquia }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class=" text-darkblue"></i>

                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('parroquia')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <div class="custom-control custom-checkbox"> {{-- Contenedor de Bootstrap para checkboxes personalizados --}}
                                <input type="checkbox" class="custom-control-input" id="estatus_activo"
                                    name="estatus_activo" value="1"
                                    {{ old('estatus_activo', true) ? 'checked' : '' }}>
                                <label class="custom-control-label text-lightblue" for="estatus_activo">Estatus
                                    Activo</label>
                            </div>
                            @error('estatus_activo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div> {{-- Fin de la columna derecha --}}
                </div> {{-- Fin de la fila principal de dos columnas --}}

                <button type="submit" class="btn btn-primary" id="Edit">Actualizar</button>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>




            </form>

        </div>
    </div>

        {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - El campo Fecha de nacimiento lo puedes cambiar, pero usando el mismo formato DD/MM/AAAA. <br>
                    - El campo telefono no debe ser mayor que 15 caracteres.

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

<@section('js') @if (session('success'))
    <script>
        $(document).ready(function() {
            let mensaje = "{{ session('success') }}";
            Swal.fire({
                title: 'Resultado',
                text: mensaje,
                icon: 'success'
            })
        })
    </script>
    @endif
@stop

<!--

<@ section('js') <script>
    $(document).ready(function() {
        console.log('¡jQuery se integró correctamente!');
    })
</script>
@ stop -->
