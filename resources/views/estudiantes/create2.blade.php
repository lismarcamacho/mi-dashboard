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
                            <label for="telefono" class="text-lightblue">Teléfono</label>

                            <span>
                                <i class="fas fa-info-circle text-blue-500 text-base cursor-help"
                                    title="Hay tres formatos que puede usar, pero coloque solo un numero de Telefono."></i>
                            </span>
                            <x-adminlte-input class="col-md-6" name="telefono"
                                placeholder="04121111111 / 02824111111 / +584121111111" label-class="text-lightblue"
                                value="{{ old('telefono') }}">

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


                            {{-- En create.blade.php o edit.blade.php para el campo fecha_nacimiento --}}
                            <x-adminlte-input name="fecha_nacimiento" type="date" label="Fecha de Nacimiento"
                                label-class="text-lightblue" fgroup-class="col-md-6"
                                value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento ?? '') }}">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar text-darkblue"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('fecha_nacimiento')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">

                            <x-adminlte-input class="col-md-6" type="text" name="cohorte_ingreso" id="cohorte_actual"
                                label="Cohorte Ingreso (Año o Año-Período)" label-class="text-lightblue"
                                value="{{ old('cohorte_ingreso', $estudiante->cohorte_ingreso ?? '') }}"
                                placeholder="Ej: 2024 o 2024-1"> {{-- Placeholder actualizado para reflejar ambos formatos --}}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt text-darkblue"></i> {{-- Icono para cohorte --}}
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('cohorte_ingreso')
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

                            <x-adminlte-input class="col-md-6" type="text" name="cohorte_actual" id="cohorte_actual"
                                label="Cohorte Actual (Año o Año-Período)" label-class="text-lightblue"
                                value="{{ old('cohorte_actual', $estudiante->cohorte_actual ?? '') }}"
                                placeholder="Ej: 2024 o 2024-1"> {{-- Placeholder actualizado para reflejar ambos formatos --}}
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt text-darkblue"></i> {{-- Icono para cohorte --}}
                                    </div>
                                </x-slot>
                            </x-adminlte-input>
                            @error('cohorte_actual')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                      

                        <div class="col-md-8">
                            <span>
                                <i class="fas fa-info-circle text-blue-500 text-base cursor-help"
                                    title="El estudiante esta Activo por defecto"></i>
                            </span>
                            {{-- Utiliza x-adminlte-select para un mejor estilo con AdminLTE --}}
                            <x-adminlte-select name="estado_estudiante" label="Estado Estudiante"
                                label-class="text-lightblue" required>

                                <x-slot name="prependSlot">

                                    <div class="input-group-text bg-gradient-info">
                                        <i class="fas fa-graduation-cap"> </i>
                                    </div>
                                </x-slot>

                                <option value="">Seleccione un Estado </option>
                                <option value="Activo" {{ old('estado_estudiante') == 'Activo' ? 'selected' : '' }}>Activo
                                </option>
                                <option value="Inactivo" {{ old('estado_estudiante') == 'Inactivo' ? 'selected' : '' }}>
                                    Inactivo</option>
                                <option value="Abandono" {{ old('estado_estudiante') == 'Abandono' ? 'selected' : '' }}>
                                    Abandono</option>
                                <option value="Egresado" {{ old('estado_estudiante') == 'Egresado' ? 'selected' : '' }}>
                                    Egresado</option>
                                <option value="Suspendido"
                                    {{ old('estado_estudiante') == 'Suspendido' ? 'selected' : '' }}>Suspendido</option>

                            </x-adminlte-select>
                            @error('estado_estudiante')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <!--  <div class="form-group">
                                                            <div class="custom-control custom-checkbox"> {{-- Contenedor de Bootstrap para checkboxes personalizados --}}
                                                                <input type="checkbox" class="custom-control-input" id="estatus_activo"
                                                                    name="estatus_activo" value="1"
                                                                    { { old('estatus_activo', true) ? 'checked' : '' }}>
                                                                <label class="custom-control-label text-lightblue" for="estatus_activo">Estatus
                                                                    Activo</label>
                                                            </div>
                                                            @ error('estatus_activo')
                                                                <span class="text-danger">{ { $message }}</span>
                                                            @ enderror
                                                        </div> -->


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
        });
    </script>
@stop
