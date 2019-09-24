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
                    <img src="{{ asset('assets/admin/img/login.png') }}" alt="branding logo">
                </div>
                <div class="col-lg-6 col-12 p-0">
                    <div class="card rounded-0 mb-0 px-2">
                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="mb-0">Recuperar Contraseña</h4>
                            </div>
                        </div>
                        <p class="px-2">Para recuperar su contraseña, solo introduzca su email y le enviaremos las instrucciones por correo.</p>
                        <div class="card-content">
                            <div class="card-body pt-1">
                                <form method="post" action="{{ url('account/recover-password') }}">
                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                        <input type="text" class="form-control" id="user-email" name="email" placeholder="Email" required>
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                        <label for="user-name">Email</label>
                                    </fieldset>
                                    <a href="{{ url('account/login/1934673413') }}" class="btn btn-outline-primary float-left btn-inline">Iniciar Sesión</a>
                                    <button type="submit" class="btn btn-primary float-right btn-inline">Recuperar Contraseña</button>
                                    <br><br><br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
  <!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection