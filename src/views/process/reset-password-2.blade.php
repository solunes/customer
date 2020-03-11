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
                                <h4 class="mb-0">Resetear Contraseña</h4>
                            </div>
                        </div>
                        <p class="px-2">Está a punto de terminar. Solo debe introducir una nueva contraseña para su cuenta aqui.</p>
                        <div class="card-content">
                            <div class="card-body pt-1">
                                <form method="post" action="{{ url('account/reset-password') }}">
                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                        <input type="password" class="form-control" id="user-password" name="password" placeholder="Contraseña" required>
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                        <label for="user-password">Contraseña</label>
                                    </fieldset>
                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                        <input type="password" class="form-control" id="user-password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required>
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                        <label for="user-password_confirmation">Confirmar Contraseña</label>
                                    </fieldset>
                                    <input type="hidden" name="token" value="{{ $confirmation_token }}">
                                    @if(config('customer.different_customers_by_agency'))
                                    <input type="hidden" id="agency_token" name="agency_token" value="{{ $agency_token }}" />
                                    @endif
                                    <a href="{{ url('account/login/'.$token.'/'.$agency_token) }}" class="btn btn-outline-primary float-left btn-inline">Iniciar Sesión</a>
                                    <button type="submit" class="btn btn-primary float-right btn-inline">Actualizar Contraseña</button>
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