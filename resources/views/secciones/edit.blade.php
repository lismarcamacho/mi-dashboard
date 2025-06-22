@extends('adminlte::page')

@section('title', 'Editar Sección')
@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando formulario de Editar Sección..</h4>
@stop

@section('content_header')
    <h1 class="m-0 text-dark">Editar Sección: {{ $seccion->nombre }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Edición de Sección</h3>
                </div>
                <form action="{{ route('secciones.update', $seccion) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Importante para el método PUT/PATCH --}}
                    <div class="card-body">
                        <div class="row">
                            {{-- Campo Nombre de Sección --}}
                            <x-adminlte-input name="nombre" label="Nombre de Sección" placeholder="Ej: 01, A, 2B"
                                label-class="text-lightblue" value="{{ old('nombre', $seccion->nombre) }}" fgroup-class="col-md-6">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-chalkboard-teacher text-darkblue"></i>
                                    </div>
                                </x-slot>
                                @error('nombre')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </x-adminlte-input>

                            {{-- Campo Capacidad Máxima --}}
                            <x-adminlte-input name="capacidad_maxima" label="Capacidad Máxima" type="number"
                                placeholder="Ej: 25, 30" label-class="text-lightblue" value="{{ old('capacidad_maxima', $seccion->capacidad_maxima) }}" fgroup-class="col-md-6" min="0">
                                <x-slot name="prependSlot">
                                    <div class="input-group-text">
                                        <i class="fas fa-users text-darkblue"></i>
                                    </div>
                                </x-slot>
                                @error('capacidad_maxima')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </x-adminlte-input>
                        </div>
                    </div>
                    <div class="card-footer">
                        <x-adminlte-button class="btn-flat" type="submit" label="Actualizar Sección" theme="warning" icon="fas fa-lg fa-save"/>
                        <a href="{{ route('secciones.index') }}" class="btn btn-flat btn-default float-right">
                            <i class="fas fa-lg fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop