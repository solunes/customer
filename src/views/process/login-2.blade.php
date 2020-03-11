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
                                <h4 class="mb-0">Iniciar Sesión</h4>
                            </div>
                        </div>
                        <p class="px-2">Bienvenido, puede iniciar sesión llenando los siguientes datos.</p>
                        <div class="card-content">
                            <div class="card-body pt-1">
                                <form method="post" action="{{ url('auth/login') }}">
                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                        <input type="text" class="form-control" id="user-name" name="user" placeholder="Email / CI" required>
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                        <label for="user-name">Email / CI</label>
                                    </fieldset>

                                    <fieldset class="form-label-group position-relative has-icon-left">
                                        <input type="password" class="form-control" name="password" id="user-password" placeholder="Contraseña" required>
                                        <div class="form-control-position">
                                            <i class="feather icon-lock"></i>
                                        </div>
                                        <label for="user-password">Contraseña</label>
                                    </fieldset>
                                    <div class="form-group d-flex justify-content-between align-items-center">
                                        <div class="text-left">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox">
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">Recordarme</span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="text-right"><a href="{{ url('account/recover-password/'.$token.'/'.$agency_token) }}" class="card-link">¿Olvidó su Contraseña?</a></div>
                                    </div>
                                    @if(config('customer.custom.register'))
                                    <a href="{{ url('account/register/'.$token.'/'.$agency_token) }}" class="btn btn-outline-primary float-left btn-inline">Registro</a>
                                    @endif
                                    @if(config('customer.different_customers_by_agency'))
                                    <input type="hidden" id="agency_token" name="agency_token" value="{{ $agency_token }}" />
                                    @endif
                                    <button type="submit" class="btn btn-primary float-right btn-inline">Iniciar Sesión</button>
                                </form>
                            </div>
                        </div>
                        <div class="login-footer">
                            <div class="divider">
                                <div class="divider-text">O</div>
                            </div>
                            <div class="footer-btn d-inline">
                              @if(config('solunes.socialite_google'))
                                <a href="{{ url('/auth/google/'.$agency_token) }}" class="btn btn-google" style="color: #fff;"><span class="fa fa-google"></span></a>
                              @endif
                              @if(config('solunes.socialite_facebook'))
                                <a href="{{ url('/auth/facebook/'.$agency_token) }}" class="btn btn-facebook" style="color: #fff;"><span class="fa fa-facebook"></span></a>
                              @endif
                              @if(config('solunes.socialite_twitter'))
                                <a href="{{ url('/auth/twitter/'.$agency_token) }}" class="btn btn-twitter white"><span class="fa fa-white"></span></a>
                              @endif
                              @if(config('solunes.socialite_github'))
                                <a href="{{ url('/auth/github/'.$agency_token) }}" class="btn btn-github" style="color: #fff;"><span class="fa fa-github"></span></a>
                              @endif
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