@extends('layouts/master')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')
<div class="container solunes-store">
  <div class="account-profile">

    <div class="row">
      <div class="col-md-3 profile-actual">
        <div class="profile-description">
          <h2>{{ $customer->name }}</h2>
          <p><span class="p_title">Ciudad: </span>{{ $customer->city->name }}</p>
          <p><span class="p_title">CI: </span>{{ $customer->ci_number }} {{ $customer->ci_expedition }}</p>
          <p><span class="p_title">NIT: </span>{{ $customer->nit_number }}</p>
          <p><span class="p_title">Razón Social: </span>{{ $customer->nit_name }}</p>
        </div>
      </div>
      <div class="col-md-9 edit-profile">
        <h2>Editar datos de Cuenta</h2>

        <form class="account-settings-form" action="{{ url('auth/login') }}" method="post">
        
          <h5>Cambiar contraseña</h5>
          <p class="small-paragraph-spacing">Puedes cambiar la contraseña de tu cuenta aqui.</p>
          <div class="row form-section">
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label for="password" class="col-form-label">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
              <div>
                <label for="confirm_password" class="col-form-label">Confirmar Contraseña:</label></div>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="">
              </div>
            </div><!-- close .col -->
          </div><!-- close .row -->
          <br>
          <p><input type="submit" class="btn" value="Ingresar"></p>
          
          <hr>
          <br>
        </form>

      </div>
    </div>

  </div>
</div><!-- End container  -->
@endsection

@section('script')
  <!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection