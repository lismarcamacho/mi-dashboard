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

                               <x-adminlte-input name="fecha_nacimiento" type="date" label="Fecha de Nacimiento"
                                label-class="text-lightblue" fgroup-class="col-md-6"
                                value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento instanceof \Carbon\Carbon ? $estudiante->fecha_nacimiento->format('Y-m-d') : ($estudiante->fecha_nacimiento ? \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->format('Y-m-d') : '')) }}">
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
                                label-class="text-lightblue" value="{{ $estudiante->email }}">
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

                <div class="row">
                    <div class="form-group col-md-7">
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


                       <!-- <div class="form-group">
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

                <button type="submit" class="btn btn-primary" id="Edit">Actualizar</button>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar y ver lista estudiantes</a>
                <a href="{{ route('estudiantes.show', $estudiante) }}" class="btn btn-secondary">Cancelar y volver a detalles</a>





            </form>

        </div>
    </div>

    {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell"
        v-centered static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                      <p> - En este vista podras editar los datos personales de cada estudiante.<br>
                    
                    - Apellidos y Nombres debe quedar registrado en ese orden.<br>
                    - Solo se debe ingresar un numero de telefono por campo.<br><br>
                    - <b> estado_actual_estudiante.</b> Este campo podría contener valores como:<br>
                    <b>Activo:</b> El estudiante está cursando actualmente.<br>
                    <b>Inactivo:</b> El estudiante está en una pausa temporal (ej. por un semestre, pero planea regresar).<br>
                    <b>Abandono:</b> El estudiante ha dejado de cursar sin intención de regresar en el corto plazo.<br>
                    <b>Egresado:</b> El estudiante ha completado sus estudios.<br>
                    <b>Suspendido:</b> El estudiante ha sido suspendido por razones académicas o disciplinarias.<br>
                   <br>

                    - Los estudiantes <b>TODOS</b> tienen el estado <b>ACTIVO</b> por defecto, este valor puede ser editado. <br>
                    - La <b>cohorte actual</b> esta definida para los casos especiales, en que el estudiante abandona y se inscribe por Prosecución,
                      entoces la cohorte ingreso ya no es la fecha o periodo valida para ese estudiante, si no esta Cohorte actual<br>

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
