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




    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Aquí se mostrarán los errores generales si hay algún problema no relacionado con un campo específico --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- El resto de tu contenido de la vista --}}

    <div class="card">



        <div class="card-body">
            <form action="{{ route('estudiantes.store') }}" method="POST">
                @csrf

                {{-- With prepend slot --}}

                <div class="row">
                    <div class="col-12">
                        <h5><i class="fas fa-id-card"></i> Datos Personales</h5>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <x-adminlte-input name="cedula" label="Cédula" label-class="text-lightblue"
                            value="{{ old('cedula', $estudiante->cedula ?? '') }}" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-id-card-alt text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('cedula')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <x-adminlte-input name="apellidos_nombres" label="Apellidos y Nombres" label-class="text-lightblue"
                            value="{{ old('apellidos_nombres', $estudiante->apellidos_nombres ?? '') }}"
                            enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('apellidos_nombres')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <x-adminlte-input name="fecha_nacimiento" type="date" label="Fecha de Nacimiento"
                            label-class="text-lightblue"
                            value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento ?? '') }}"
                            enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-alt text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('fecha_nacimiento')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Puedes añadir más campos personales aquí si los tienes, siempre en pares para mantener la simetría --}}
                </div>

                {{-- Sección: Información de Contacto --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <h5><i class="fas fa-address-book"></i> Información de Contacto</h5>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <x-adminlte-input name="email" label="Correo Electrónico" label-class="text-lightblue"
                            type="email" value="{{ old('email', $estudiante->email ?? '') }}" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('email')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <x-adminlte-input name="telefono" label="Teléfono" label-class="text-lightblue" placeholder="0412-11.11.111 / 0282-411.11.11 / +58-412-11.11.111"
                            value="{{ old('telefono', $estudiante->telefono ?? '') }}" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-phone text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                         <x-slot name="description">
                                Solo debe ingresar un número de teléfono.
                        </x-slot>
                        <small class="form-text text-muted ml-1">Solo debe ingresar un número de teléfono.</small>
                        @error('telefono')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <x-adminlte-input name="sede" label="Sede" label-class="text-lightblue" placeholder="ANACO"
                            value="{{ old('sede', $estudiante->sede ?? '') }}" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-building text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('sede')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <x-adminlte-input name="municipio" label="Municipio" label-class="text-lightblue" placeholder="ANACO"
                            value="{{ old('municipio', $estudiante->municipio ?? '') }}" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-city text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('municipio')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <x-adminlte-input name="parroquia" label="Parroquia" label-class="text-lightblue" placeholder="ANACO"
                            value="{{ old('parroquia', $estudiante->parroquia ?? '') }}" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-church text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('parroquia')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Sección: Datos Académicos --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <h5><i class="fas fa-graduation-cap"></i> Datos Académicos</h5>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <x-adminlte-input type="text" name="cohorte_ingreso" id="cohorte_ingreso"
                            label="Cohorte Ingreso (Año o Año-Período)" label-class="text-lightblue"
                            value="{{ old('cohorte_ingreso', $estudiante->cohorte_ingreso ?? '') }}"
                            placeholder="Ej: 2023 o 2023-1" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-check text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('cohorte_ingreso')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <x-adminlte-input type="text" name="cohorte_actual" id="cohorte_actual"
                            label="Cohorte Actual (Año o Año-Período)" label-class="text-lightblue"
                            value="{{ old('cohorte_actual', $estudiante->cohorte_actual ?? '') }}"
                            placeholder="Ej: 2024 o 2024-1" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-alt text-darkblue"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        @error('cohorte_actual')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <x-adminlte-select name="estado_estudiante" label="Estado Estudiante"
                            label-class="text-lightblue" enable-old-support="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user-tag text-darkblue"></i>
                                </div>
                            </x-slot>
                            <option value="">Seleccione un Estado</option>
                            <option value="Activo"
                                {{ old('estado_estudiante', $estudiante->estado_estudiante ?? '') == 'Activo' ? 'selected' : '' }}>
                                Activo</option>
                            <option value="Inactivo"
                                {{ old('estado_estudiante', $estudiante->estado_estudiante ?? '') == 'Inactivo' ? 'selected' : '' }}>
                                Inactivo</option>
                            <option value="Abandono"
                                {{ old('estado_estudiante', $estudiante->estado_estudiante ?? '') == 'Abandono' ? 'selected' : '' }}>
                                Abandono</option>
                            <option value="Egresado"
                                {{ old('estado_estudiante', $estudiante->estado_estudiante ?? '') == 'Egresado' ? 'selected' : '' }}>
                                Egresado</option>
                            {{-- Agrega más opciones si tienes otros estados --}}
                        </x-adminlte-select>
                        @error('estado_estudiante')
                            <span class="text-danger d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Puedes añadir más campos académicos aquí --}}
                </div>



                <div class="row mt-4"> {{-- Margin top para separar los botones de los campos --}}
                    <div class="col-md-12 ">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar y ver lista de estudiantes</a>
                        

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
                <p> - En este vista se registran de los datos personales de todos los estudiantes.<br>
                    - Apellidos y Nombres debe quedar registrado en ese orden.<br>
                    - Solo se debe ingresar un numero de telefono por campo.<br><br>
                    - <b> estado_actual_estudiante.</b> Este campo podría contener valores como:<br>
                    <b>Activo:</b> El estudiante está cursando actualmente.<br>
                    <b>Inactivo:</b> El estudiante está en una pausa temporal (ej. por un semestre, pero planea
                    regresar).<br>
                    <b>Abandono:</b> El estudiante ha dejado de cursar sin intención de regresar en el corto plazo
                    (esto es clave para tu escenario).<br>
                    <b>Egresado:</b> El estudiante ha completado sus estudios.<br>
                    <b>Suspendido:</b> El estudiante ha sido suspendido por razones académicas o disciplinarias.<br>
                    <br>

                    - Los estudiantes <b>TODOS</b> tienen el estado <b>ACTIVO</b> por defecto. <br>
                    - La <b>cohorte actual</b> esta definida para los casos especiales, en que el estudiante abandona y se
                    inscribe por Prosecución,<br>
                    entoces la cohorte ingreso ya no es la fecha o periodo valida para ese estudiante, si no esta Cohorte
                    actual<br>

                </p>

                </p>
            </div>
        </div>

        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Aceptar" data-dismiss="modal" />

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

             let mensaje = "{{ session('success') }}";
            Swal.fire({
                title: 'Resultado',
                text: mensaje,
                icon: 'success'
            })
        });

        
    </script>
@stop
