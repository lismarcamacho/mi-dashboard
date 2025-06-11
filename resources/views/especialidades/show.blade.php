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
        <h2>Detalles de la Especialidad: {{ $especialidad->nombre_especialidad }}</h2>

        <div class="card mt-4">
            <div class="card-header">
                Información de la Especialidad
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $especialidad->id }}</p>
                <p><strong>Código:</strong> {{ $especialidad->codigo_especialidad ?? 'N/A' }}</p> {{-- Asumo que tienes codigo_especialidad --}}
                <p><strong>Nombre:</strong> {{ $especialidad->nombre_especialidad }}</p>
                <p><strong>Duración:</strong> {{ $especialidad->duracion ?? 'N/A' }}</p> {{-- Asumo que tienes duracion --}}
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                Títulos Asociados
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

        <!--<div class="card mt-4">
                <div class="card-header">
                    Trayectos Asociados
                </div>
                <div class="card-body">
                    @ if ($especialidad->trayectos->isNotEmpty())
                        <ul>
                            @ foreach ($especialidad->trayectos as $trayecto)
                                <li>
                                    <strong>{ { $trayecto->nombre_trayecto }}</strong>
                                    @ if ($trayecto->numero_trayecto)
                                        (Número: { { $trayecto->numero_trayecto }})
                                    @ endif
                                    @ if ($trayecto->descripcion)
                                        - { { $trayecto->descripcion }}
                                    @ endif
                                </li>
                            @ endforeach
                        </ul>
                    @ else
                        <p>No hay trayectos asociados a esta especialidad.</p>
                    @ endif
                </div>
            </div>-->
        <div class="card mt-4">
            <div class="card-header">
                <h4>Unidades Curriculares Asociadas:</h4>
            </div>
            <div class="card-body">
                @if ($especialidad->mallasCurriculares->isNotEmpty())
                    <ul>
                        @foreach ($especialidad->mallasCurriculares as $mallaCurricular)
                           <!-- <li>
                                {{-- Aquí usas los atributos de Malla que existen --}}
                                Mínimo Aprobatorio: { { $mallaCurricular->minimo_aprobatorio }} <br>
                                Duración: { { $mallaCurricular->duracion_en_malla }} <br>
                                Fase: { { $mallaCurricular->fase_malla }} <br>
                                Tipo UC: { { $mallaCurricular->tipo_uc_en_malla }} <br>
                                Créditos: { { $mallaCurricular->creditos_en_malla }} <br>
                                {{-- O si tienes el accesor en el modelo Malla: --}}
                              {{--  Identificador: {{ $mallaCurricular->identificador }} --}}
                                Malla vigente: 
                                <hr> -->
                            </li>
                            <!-- <h4> Malla vigente:{ { $mallaCurricular->año_de_vigencia_de_entrada_malla}}</h4>  -->
                        
                             <li>
                               {{ $mallaCurricular->trayecto->nombre_trayecto }}
                             
                {{ $mallaCurricular->unidadCurricular->nombre }}  - Créditos: {{ $mallaCurricular->creditos_en_malla }}
                            </li>
                        

                        @endforeach
                    </ul>
                @else
                    <p>No hay mallas asociadas a esta especialidad.</p>
                @endif
            </div>
        </div>

        <a href="{{ route('especialidades.index') }}" class="btn btn-secondary mt-3">Volver a la lista de
            Especialidades</a>
    </div>
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
