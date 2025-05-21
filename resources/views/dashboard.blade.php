@extends('adminlte::page')
{{-- Setup Custom Preloader Content --}}

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando...</h4>
@stop

@section('plugins.Sweetalert2',true)

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')



      <p>Welcome <b>{{Auth::User()->name}} </b>to this beautiful admin panel. </p>


  <div class="card-info">
          <div class="card-header">
            <h3 class="card-title">Default Card Secondary Example</h3>
                  <div class="card-tools">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->

                  </div>
          <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            The body of the card
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
            <h3 class="card-title">Default Card Secondary Example</h3>
                  <div class="card-tools">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->
                    <span class="badge badge-info">Label</span>
                  </div>
          <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            The body of the card
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            The footer of the card
          </div>
          <!-- /.card-footer -->
  </div>
  <!-- /.card -->

<br>


    
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> </script>
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
