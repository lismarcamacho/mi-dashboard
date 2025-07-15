{{-- resources/views/especialidades/show.blade.php --}}

@extends('adminlte::page')

@section('title', 'Detalles de la Especialidad')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando detalles de la Especialidad..</h4>
@stop

@section('content_header')
    <center>
        <h4>Detalle de la Especialidad: {{ $especialidad->nombre_especialidad }}</h4>
    </center>
@stop

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Información de la Especialidad</h3>
                <div class="card-tools">
                    <a href="{{ route('especialidades.edit', $especialidad->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('especialidades.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver a la Lista
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $especialidad->id }}</p>
                        <p><strong>Código:</strong> {{ $especialidad->codigo_especialidad ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Nombre:</strong> {{ $especialidad->nombre_especialidad }}</p>
                        <p><strong>Duración:</strong> {{ $especialidad->duracion ?? 'N/A' }}</p>
                    </div>
                </div>
                <hr>
                <p><strong>Descripción:</strong> {{ $especialidad->descripcion ?? 'N/A' }}</p>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Creado el:</strong> {{ $especialidad->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Última Actualización:</strong> {{ $especialidad->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>

                {{-- NUEVO CARD PARA PROGRAMAS ASOCIADOS --}}
        <div class="card mt-4">
            <div class="card-header">
                <h4>Programas Asociados</h4>
            </div>
            <div class="card-body">
                @if ($especialidad->programas->isNotEmpty())
                    <ul>
                        @foreach ($especialidad->programas as $programa)
                            <li>
                                {{-- Opcional: Enlace al detalle del programa si tienes una ruta 'programas.show' --}}
                                <a href="{{ route('programas.show', $programa->id) }}">
                                    {{ $programa->nombre_programa }}
                                </a>
                                ({{ $programa->codigo_programa ?? 'N/A' }})
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No hay programas asociados a esta especialidad.</p>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Títulos Asociados</h4>
            </div>
            <div class="card-body">
                @if ($especialidad->titulos->isNotEmpty())
                    <ul>
                        @foreach ($especialidad->titulos as $titulo)
                            <li>{{ $titulo->nombre }} ({{ $titulo->duracion }})</li>
                        @endforeach
                    </ul>
                @else
                    <p>No hay títulos asociados a esta especialidad.</p>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Todas las Mallas Curriculares:</h4>
            </div>
            <div class="card-body">
                @if ($especialidad->mallasCurriculares->isNotEmpty())
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Año Vigencia</th>
                                <th>Trayecto</th>
                                <th>Fase Malla</th>
                                <th>Unidad Curricular</th> {{-- Esto ahora representará la unidad en el pivote --}}
                                <th>Créditos Malla</th>
                                <th>Tipo UC Malla</th>
                                <th>Duración Malla</th>
                                <th>Mínimo Aprobatorio (Pivote)</th>
                                <th>Tipo UC (Pivote)</th>
                                <th>Periodo Carga (Pivote)</th>
                                <th>Número Fase (Pivote)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($especialidad->mallasCurriculares->sortBy('anio_de_vigencia_de_entrada_malla')->sortBy('fase_malla') as $mallaCurricular)
                                {{-- Si una malla puede tener varias unidades curriculares relacionadas a través del pivote,
                                     necesitas un bucle anidado. Si esperas solo UNA unidad curricular por registro de malla
                                     (aunque la relación sea Many-to-Many), esto puede complicarse si los datos no están así.
                                     Asumo que cada fila de la tabla 'mallas_curriculares' representa UNA línea de la malla.
                                     Si cada MallaCurricular en sí es un "registro principal" que se relaciona con MÚLTIPLES
                                     unidades curriculares a través del pivote, entonces el diseño de tu tabla HTML
                                     necesitará un bucle anidado diferente.
                                     Dada la estructura que me diste anteriormente, donde cada fila de la tabla `mallas_curriculares`
                                     parece ser un registro de una unidad curricular específica dentro de una malla,
                                     es más probable que la relación `unidadCurricular` deba ser `belongsTo` si `id_unidad_curricular`
                                     es una columna directa de `mallas_curriculares`.
                                     Si `malla_unidad_curricular` es una tabla aparte, entonces la estructura es para M:N.

                                     **Revisa tu base de datos:**
                                     - Si `mallas_curriculares` tiene directamente `id_unidad_curricular` y `id_trayecto`,
                                       entonces `unidadCurricular()` y `trayecto()` DEBEN ser `belongsTo`.
                                     - Si `mallas_curriculares` NO tiene esas FKs directamente, pero hay una tabla intermedia
                                       `malla_unidad_curricular` que une `mallas_curriculares` con `unidades_curriculares`,
                                       ENTONCES `unidadesCurriculares()` es `belongsToMany`.

                                     El error original de "undefined relationship [unidadCurricular]" con la precarga
                                     `mallasCurriculares.unidadCurricular` sugería `belongsTo`.
                                     Tu definición `unidadesCurriculares()` con `belongsToMany` sugiere una tabla pivote.

                                     **Vamos a seguir con tu definición de `belongsToMany` y la tabla pivote, pero ten en cuenta la diferencia.**
                                     **Si `id_unidad_curricular` y `id_trayecto` son FKs DIRECTAS en la tabla `mallas_curriculares`,
                                     tu modelo `MallaCurricular` debería tener relaciones `belongsTo` a `UnidadCurricular` y `Trayecto`.**
                                     **Si NO son FKs directas en `mallas_curriculares` y usas una tabla pivote `malla_unidad_curricular`,
                                     entonces la `belongsToMany` es correcta.**

                                     **Asumiendo que `unidadesCurriculares` es Many-to-Many y `trayecto` es BelongsTo:**
                                --}}

                                {{-- Itera sobre las unidades curriculares asociadas a CADA malla curricular (si es many-to-many) --}}
                                @forelse ($mallaCurricular->unidadesCurriculares as $unidadCurricular)
                                    <tr>
                                        <td>{{ $mallaCurricular->anio_de_vigencia_de_entrada_malla ?? 'N/A' }}</td>
                                        <td>{{ $mallaCurricular->trayecto->nombre_trayecto ?? 'N/A' }}</td>
                                        <td>{{ $mallaCurricular->fase_malla ?? 'N/A' }}</td>
                                        {{-- Acceder a los datos de la Unidad Curricular --}}
                                        <td>{{ $unidadCurricular->nombre ?? 'N/A' }}</td>
                                        {{-- Acceder a los datos de la Malla Curricular (no del pivote) --}}
                                        <td>{{ $mallaCurricular->creditos_en_malla ?? 'N/A' }}</td>
                                        <td>{{ $mallaCurricular->tipo_uc_en_malla ?? 'N/A' }}</td>
                                        <td>{{ $mallaCurricular->duracion_en_malla ?? 'N/A' }}</td>
                                        {{-- Acceder a los datos del PIVOTE --}}
                                        <td>{{ $unidadCurricular->pivot->minimo_aprobatorio ?? 'N/A' }}</td>
                                        <td>{{ $unidadCurricular->pivot->tipo_uc_en_malla ?? 'N/A' }}</td>
                                        <td>{{ $unidadCurricular->pivot->periodo_de_carga ?? 'N/A' }}</td>
                                        <td>{{ $unidadCurricular->pivot->numero_de_fase ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    {{-- Si una mallaCurricular no tiene unidadesCurriculares asociadas a través del pivote --}}
                                    <tr>
                                        <td>{{ $mallaCurricular->anio_de_vigencia_de_entrada_malla ?? 'N/A' }}</td>
                                        <td>{{ $mallaCurricular->trayecto->nombre_trayecto ?? 'N/A' }}</td>
                                        <td>{{ $mallaCurricular->fase_malla ?? 'N/A' }}</td>
                                        <td colspan="7">No tiene unidades curriculares vinculadas para esta fila de
                                            malla.</td>
                                    </tr>
                                @endforelse
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No hay mallas curriculares asociadas a esta especialidad.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Custom Modal - Se mantiene tu código si lo necesitas --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - El botón lápiz lleva a otra interfaz llamada editar especialidad<br>
                    - El botón papelera elimina, primero pregunta si desea eliminar
                    el registro, luego lo elimina y envía una notificación en la <b>interfaz</b>
                    lista de especialidades de que el registro ha sido eliminado</p>
            </div>
        </div>
        <x-slot name="footerSlot">
            <x-adminlte-button class="mr-auto" theme="success" label="Accept" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Vista de detalles de la especialidad cargada!');
    </script>
@stop
