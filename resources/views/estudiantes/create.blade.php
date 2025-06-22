@extends('adminlte::page')

@section('title', 'Registrar Estudiante')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Formulario Nuevo Estudiante..</h4>
@stop

@section('content_header')
    <center>
        <h1>Agregar Estudiante</h1>
    </center>
@stop

@section('content')

    <p> Ingrese la información del Estudiante</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    {{-- El resto de tu contenido de la vista --}}

    <div class="card">



        <div class="card-body">
            <form action="{{ route('estudiantes.store') }}" method="POST">
                @csrf

                {{-- With prepend slot --}}

                <div class="row"> {{-- Abre una nueva fila para las dos columnas --}}
                    <div class="col-md-6"> {{-- Columna izquierda (para datos personales, etc.) --}
                        {{-- Cédula --}}
                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}

                            <x-adminlte-input class="col-md-6" name="cedula" label="Cédula" placeholder="18594461"
                                label-class="text-lightblue" value="{{ old('cedula') }}">
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
                                value="{{ old('apellidos_nombres') }}">
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
                                label-class="text-lightblue" value="{{ old('telefono') }}">
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


                        <!--   <div class="form-group"> {{-- Usamos form-group para los márgenes --}}

                                <x-adminlte-input class="col-md-6" name="fecha_nacimiento" label="Fecha Nacimiento"
                                    placeholder="DD/MM/AAAA" label-class="text-lightblue"
                                    value="{ { old('fecha_nacimiento', \Carbon\Carbon::now()->format('d/m/Y')) }}"
                                    enable-old-support="false"
                                    title="Puedes cambiar la fecha haciendo clic o escribiendo aquí.">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-gradient-info">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </x-slot>

                                </x-adminlte-input>
                                @ error('fecha_nacimiento')
                                    <span class="text-danger">{ { $message }}</span>
                                @ enderror
                            </div> -->

                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}
                            <x-adminlte-input name="fecha_nacimiento" type="text" label="Fecha Nacimiento"
                                placeholder="DD/MM/YYYY" class="col-md-6" label-class="text-lightblue"
                                value="{{ old('fecha_nacimiento', \Carbon\Carbon::now()->format('d/m/Y')) }}"
                                enable-old-support="true" {{-- Esto es importante para x-adminlte-input --}}>
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-gradient-info">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                        </div>

                        <div class="form-group">
                        
                            <x-adminlte-input type="number" name="anio_cohorte" id="anio_cohorte" label="Año de Cohorte (Ingreso)"
                                 class="col-md-6" label-class="text-lightblue" enable-old-support="true"
                                value="{{ old('anio_cohorte', $estudiante->anio_cohorte ?? '') }}" min="1900"
                                max="{{ date('Y') + 5 }}" placeholder="Ej: 2023">
                          
                            </x-adminlte-input>
                              @error('anio_cohorte')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>{{--  FIN Columna izquierda (para datos personales, etc.) --}}

                    <div class="col-md-6"> {{-- Columna izquierda (para datos personales, etc.) --}}

                        <div class="form-group"> {{-- Usamos form-group para los márgenes --}}

                            <x-adminlte-input class="col-md-6" name="email" label="Correo" placeholder="email"
                                label-class="text-lightblue" value="{{ old('email') }}">
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
                                label-class="text-lightblue" value="{{ old('sede') }}">
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
                                label-class="text-lightblue" value="{{ old('municipio') }}">
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
                                label-class="text-lightblue" value="{{ old('parroquia') }}">
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



                <div class="row mt-4"> {{-- Margin top para separar los botones de los campos --}}
                    <div class="col-md-12 ">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>

            </form>

        </div>
    </div>

    {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell"
        v-centered static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - En este formulario se registran los datos personales del estudiante.<br>
                    - Apellidos y Nombres debe quedar registrado en ese orden.<br>
                    - Solo se debe ingresar un numero de telefono por campo.<br>
                    - El campo Fecha Nacimiento esta indicando la fecha actual. <br>
                    lo puedes cambiar pero usando el mismo formato DD/MM/AAAA.
                    -
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
    <script>
        $(document).ready(function() {
            $('input[name="fecha_nacimiento"]').datepicker({
                dateFormat: 'dd/mm/yy', // Este es el formato visual y el que debería enviar al input text
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0', // Ejemplo: rango de 100 años hacia atrás desde el actual
                // No se necesita altFormat si el input type es "text" y el valor es el mismo que dateFormat
            });
        });
    </script>
@stop
