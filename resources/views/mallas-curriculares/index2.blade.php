@extends('adminlte::page')

@section('title', 'Lista de Mallas Curriculares')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Lista de Mallas Curriculares..</h4>
@stop


@section('content_header')
    <center>
        <h1>Lista de Mallas Curriculares</h1>
    </center>
@stop


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estructura Académica por Especialidad</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('mallas-curriculares.create') }}" class="btn btn-primary my-2">Agregar Malla Curricular</a>
                    {{-- Si quieres un botón para agregar especialidades o trayectos, irían aquí --}}

                    @if($especialidades->isNotEmpty())
                        @foreach($especialidades as $especialidad)
                            <div class="card card-primary card-outline collapsed-card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $especialidad->nombre }}</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body" style="display: none;"> {{-- O display:block para que estén abiertos por defecto --}}
                                    @if($especialidad->mallasCurriculares->isNotEmpty())
                                        @foreach($especialidad->mallasCurriculares as $malla)
                                            <div class="card card-info card-outline collapsed-card ml-4">
                                                <div class="card-header">
                                                    <h6 class="card-title">Malla Curricular: {{ $malla->id }} ({{ $malla->anio_de_vigencia_de_entrada_malla  }} - {{ $malla->anio_salida_vigencia ?? 'Actual' }})</h6>
                                                    <div class="card-tools">
                                                        <a href="{{ route('mallas-curriculares.edit', $malla->id) }}" class="btn btn-warning btn-sm mx-1">Editar Malla</a>
                                                        <form action="{{ route('mallas-curriculares.destroy', $malla->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta malla?')">Eliminar Malla</button>
                                                        </form>
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body" style="display: none;">
                                                    @if($malla->trayectos->isNotEmpty())
                                                        @foreach($malla->trayectos as $trayecto)
                                                            <div class="card card-secondary card-outline collapsed-card ml-4">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Trayecto: {{ $trayecto->nombre_trayecto }}</h6>
                                                                    <div class="card-tools">
                                                                        {{-- Aquí botones para editar/eliminar Trayecto --}}
                                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                            <i class="fas fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body" style="display: none;">
                                                                    @if($trayecto->unidadesCurriculares->isNotEmpty())
                                                                        <table class="table table-sm table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Unidad Curricular</th>
                                                                                    <th>Créditos</th>
                                                                                    {{-- Si Unidad Curricular tiene sus propias vigencias --}}
                                                                                    <th>Vigencia UC</th>
                                                                                    <th>Acciones UC</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($trayecto->unidadesCurriculares as $unidad)
                                                                                    <tr>
                                                                                        <td>{{ $unidad->nombre }}</td>
                                                                                        <td>{{ $unidad->creditos }}</td>
                                                                                        <td>{{ $unidad->anio_de_vigencia_de_entrada_malla ?? '' }} - {{ $unidad->anio_salida_vigencia ?? 'Actual' }}</td>
                                                                                        <td>
                                                                                            {{-- Botones para editar/eliminar Unidad Curricular --}}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    @else
                                                                        <p class="ml-4">No hay unidades curriculares en este trayecto.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="ml-4">No hay trayectos definidos para esta malla.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="ml-4">No hay mallas curriculares definidas para esta especialidad.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No hay especialidades registradas.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection