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
        <div class="profile-picture">
          <img src ="{{ asset('assets/admin/img/user.jpg') }}" />
        </div>
        <div class="profile-description">
          <h2>Prueba Prueba</h2>
          <p><span class="p_title">Ciudad: </span>La Paz</p>
          <p><span class="p_title">Dirección: </span>Av. Prueba #123 Calle Test</p>
          <p><span class="p_title">NIT: </span>123456789</p>
          <p><span class="p_title">Razón Social: </span>Prueba</p>
        </div>
      </div>
      <div class="col-md-9 edit-profile">
        <h2>Editar datos de Cuenta</h2>

        <form class="account-settings-form" action="http://bolivartv.test/process/edit-account" method="post">
        
          <h5>Información General</h5>
          <p class="small-paragraph-spacing">Al saber tus datos personales, podemos hacer de tu experiencia mas cálida y cercana.</p>
          <div class="row form-section">
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label for="first-name" class="col-form-label">Nombre:</label>
                <input type="text" class="form-control" name="first_name" id="first-name" value="">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
              <label for="last-name" class="col-form-label">Apellido:</label>
                <input type="text" class="form-control" name="last_name" id="last-name" value="">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label for="last-name" class="col-form-label">Departamento:</label>
                <select name="city_id" class="custom-select">
                  <option value="1">La Paz</option>
                  <option value="2">El Alto</option>
                  <option value="3">Santa Cruz de la Sierra</option>
                  <option value="4">Montero</option>
                  <option value="5">Cochabamba</option>
                  <option value="6">Quillacollo</option>
                  <option value="7">Sucre</option>
                  <option value="8">Oruro</option>
                  <option value="9">Tarija</option>
                  <option value="10">Potosi</option>
                  <option value="11">Trinidad</option>
                  <option value="12">Cobija</option>
                  <option value="13">Otra Ciudad</option>
                </select>
              </div>
            </div><!-- close .col -->
          </div><!-- close .row -->
          <div class="row form-section">
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label for="first-name" class="col-form-label">Dirección:</label>
                <input type="text" class="form-control" name="first_name" id="first-name" value="">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
              <label for="last-name" class="col-form-label">NIT:</label>
                <input type="text" class="form-control" name="last_name" id="last-name" value="">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label for="last-name" class="col-form-label">Razón Social:</label>
                <input type="text" class="form-control" name="last_name" id="last-name" value="">
              </div>
            </div><!-- close .col -->
          </div><!-- close .row -->
          <br>
          <p><input type="submit" class="btn" value="Guardar los Cambios"></p>
          <br>
          <hr>
        
          <br>
          <h5>Cambiar contraseña</h5>
          <p class="small-paragraph-spacing">Puedes cambiar la contraseña de tu cuenta aqui.</p>
          <div class="row form-section">
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label for="password" class="col-form-label">Contraseña Actual:</label>
                <input type="password" class="form-control" name="current_password" id="current-password" placeholder="">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label for="new-password" class="col-form-label">Nueva Contraseña:</label>
                <input type="password" class="form-control" name="new_password" id="new-password" placeholder="Mínimo 6 carácteres">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
              <div>
                <label for="confirm-password" class="col-form-label">Confirmar contraseña:</label></div>
                <input type="password" class="form-control" name="confirm_new_password" id="confirm-new-password" placeholder="">
              </div>
            </div><!-- close .col -->
          </div><!-- close .row -->
          <br>
          <p><input type="submit" class="btn" value="Guardar los Cambios"></p>
          
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