{{-- resources/views/especialidades/show.blade.php --}}

@extends('adminlte::page')

@section('title', 'Detalles de la Especialidad')

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando detalles de la Especialidad..</h4>
@stop

@section('content_header')

@stop

@section('content')
    <div class="container">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-4">Malla de {{ $especialidad->nombre_especialidad }}</h1>
        <p class="text-center text-gray-600 mb-6">Estructura detallada de las unidades curriculares por trayecto.</p>

         @if ($mallasCurriculares->isEmpty())
                <p class="text-gray-600 text-center">No hay unidades curriculares asignadas a esta especialidad aún.</p>
            @else
                <div>
                    @foreach($mallasCurriculares as $mallaEntry)
                        <div class="uc-item">
                            <span class="uc-name">{{ $mallaEntry->unidadCurricular->nombre ?? 'Unidad Desconocida' }}</span>
                            <div class="uc-details">
                                <span class="badge">Créditos: {{ $mallaEntry->creditos_en_malla }}</span>
                                <span class="badge">Tipo: {{ $mallaEntry->tipo_uc_en_malla }}</span>
                                @if($mallaEntry->fase_malla)
                                    <span class="badge">Fase: {{ $mallaEntry->fase_malla }}</span>
                                @endif
                                {{-- Si la relación N:M 'trayectos' existe en MallaCurricular, la mostramos aquí --}}
                                @if($mallaEntry->trayectos && $mallaEntry->trayectos->isNotEmpty())
                                    <span class="badge">Trayectos:
                                        @foreach($mallaEntry->trayectos as $trayecto)
                                            {{ $trayecto->nombre_trayecto }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </span>
                                @else
                                    <span class="badge">Trayectos: N/A</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        <div class="mt-6 text-center">
            <a href="{{ route('especialidades.index') }}"
                class="px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-md shadow-md hover:bg-gray-300 transition ease-in-out duration-150">
                Volver a Especialidades
            </a>
        </div>
    </div> //
    {{-- Custom --}}
    <x-adminlte-modal id="modalCustom" title="Instrucciones" size="lg" theme="teal" icon="fas fa-bell" v-centered
        static-backdrop scrollable>
        <div style="height:800px;">
            <h2>Instrucciones</h2>
            <div style="height:400px;">
                <p> - El boton lapiz lleva a otra interfaz llamada editar especialidad<br>
                    - El boton papelera elimina, primero pregunta si desea eliminar
                    el registro, luego lo elimina y envia una notifiacion en la <b>interfaz</b>
                    lista de especialidades
                    de que el registro ha sido eliminado</p>
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
    <script></script>
@stop
