@extends('master::layouts/admin-2-clean')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')
<section class="row flexbox-container">
    <div class="col-xl-8 col-11 d-flex justify-content-center">
        <div class="card bg-authentication rounded-0 mb-0">
            <div class="row m-0">
                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                  <a href="{{ url('inicio') }}">
                    <img src="{{ asset('assets/admin/img/login.png') }}" alt="logo">
                  </a>
                </div>
                <div class="col-lg-6 col-12 p-0">
                    <div class="card rounded-0 mb-0 px-2">
                        <div class="card-header pb-1 mt-2">
                            <div class="card-title">
                                <h4 class="mb-0">Revise su Correo Electrónico</h4>
                            </div>
                        </div>
                        <p class="px-2">Enviamos un correo electrónico con los pasos para restablecer su contraseña.</p>
                        <div class="card-content">
                            <div class="card-body pt-1">
                                  <a href="{{ url('account/recover-password/'.$token.'/'.$agency_token) }}">
                                    <button class="btn btn-primary float-right btn-inline">Volver a Enviar</button>
                                  </a>
                                  <br><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container solunes-store">
  <div class="account-profile">

    <div class="row">
      <div class="col-md-3 profile-actual">
      </div>
      <div class="col-md-6 edit-profile">
        <h2>Revise su Correo Electrónico</h2>

          <p class="small-paragraph-spacing">Enviamos un correo electrónico con los pasos para restablecer su contraseña.</p>
          <br>
          <p>
            <a href="{{ url('account/recover-password/'.$token.'/'.$agency_token) }}">
              <input type="submit" class="btn btn-site" value="Volver a Enviar"></p>
            </a>
          <hr>
          <br>

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