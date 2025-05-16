@extends('adminlte::page')
{{-- Setup Custom Preloader Content --}}

@section('preloader')
    <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
    <h4 class="mt-4 text-dark">Cargando...</h4>
@stop


@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

<x-adminlte-alert icon="fas fa-user">
    User has logged in!
</x-adminlte-alert>

      <p>Welcome to this beautiful admin panel. Lismar</p>

      <div class="container text-center">
  <div class="row">
    <div class="col-6 col-sm-3">.col-6 .col-sm-3</div>
    <div class="col-6 col-sm-3">.col-6 .col-sm-3</div>

    <!-- Force next columns to break to new line -->
    <div class="w-100"></div>

    <div class="col-6 col-sm-3">.col-6 .col-sm-3</div>
    <div class="col-6 col-sm-3">.col-6 .col-sm-3</div>
  </div>
</div>

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
    
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop