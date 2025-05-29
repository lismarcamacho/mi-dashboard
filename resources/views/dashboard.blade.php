@extends('adminlte::page')
{{-- Setup Custom Preloader Content --}}

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando Dashboard...</h4>
@stop

@section('plugins.Sweetalert2', true)

@section('title', 'Dashboard')

@section('content_header')

    <h1>Inicio</h1>

@stop

@section('content')
    <!--<div class="ribbon-wrapper" id="cabecera">
        <div class="ribbon bg-primary">
            Ribbon
        </div>
    </div>-->


    <p >Bienvenido <b>{{ Auth::User()->name }} </b> </p>

 

    <div class="card-info">
        <div class="card-header">
            <h3 class="card-title">Lista de Actividades </h3>
            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            Actividad o Notificación
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            The footer of the card
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->

    <br>
    <div class="card-info">
        <div class="card-header">
            <h3 class="card-title">Lista de Notificaciones</h3>
            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->

            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="timeline">
                <!-- Timeline time label -->
                <div class="time-label">
                    <span class="bg-green">23 Aug. 2019</span>
                </div>
                <div>
                    <!-- Before each timeline item corresponds to one icon on the left scale -->
                    <i class="fas fa-envelope bg-blue"></i>
                    <!-- Timeline item -->
                    <div class="timeline-item">
                        <!-- Time -->
                        <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                        <!-- Header. Optional -->
                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                        <!-- Body -->
                        <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                        </div>
                        <!-- Placement of additional controls. Optional -->
                        <div class="timeline-footer">
                            <a class="btn btn-primary btn-sm">Read more</a>
                            <a class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </div>
                </div>
                <!-- The last icon means the story is complete -->
                <div>
                    <i class="fas fa-clock bg-gray"></i>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            The footer of the card
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
<!-- setting all icons used in buttons to have the same width using fa-fw -->
<div>
  <span style="display: inline-block; margin: 0.25em; border: 1px solid silver; border-radius: 0.25em; padding: .25em 0.5em"><i class="fa-solid fa-arrow-left fa-fw" title="Back"></i></span>
  <span style="display: inline-block; margin: 0.25em; border: 1px solid silver; border-radius: 0.25em; padding: .25em 0.5em"><i class="fa-solid fa-arrow-right fa-fw" title="Forward"></i></span>
  <span style="display: inline-block; margin: 0.25em; border: 1px solid silver; border-radius: 0.25em; padding: .25em 0.5em"><i class="fa-solid fa-arrows-rotate fa-fw" title="Refresh"></i></span>
  <span style="display: inline-block; margin: 0.25em; border: 1px solid silver; border-radius: 0.25em; padding: .25em 0.5em"><i class="fa-solid fa-house fa-fw" title="Home"></i></span>
  <span style="display: inline-block; margin: 0.25em; border: 1px solid silver; border-radius: 0.25em; padding: .25em 0.5em"><i class="fa-solid fa-info fa-fw" title="Info"></i></span>
  <span style="display: inline-block; margin: 0.25em; border: 1px solid silver; border-radius: 0.25em; padding: .25em 0.5em"><i class="fa-solid fa-download fa-fw" title="Download"></i></span>
</div>

    <!-- Main node for this component -->



    <br>

    <br>



@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')
    <script></script>
@stop

@section('js')
    <script>
        Swal.fire({
            title: 'Hello world',
            text: 'You click on the button',
            icon: 'success'
        });

        alert("You clicked the button!");
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>

@stop
