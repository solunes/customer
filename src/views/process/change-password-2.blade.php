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
                                <h4 class="mb-0">Editar Contraseña</h4>
                            </div>
                        </div>
                        <p class="px-2">Le recomendamos que ingrese una contraseña segura para continuar.</p>
                        <div class="card-content">
                            <div class="card-body pt-1">
                                <form method="post" action="{{ url('account/change-password') }}">
                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                                        <div class="form-control-position">
                                            <i class="feather icon-lock"></i>
                                        </div>
                                        <label for="user-name">Contraseña</label>
                                    </fieldset>

                                    <fieldset class="form-label-group position-relative has-icon-left">
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirmar Contraseña" required>
                                        <div class="form-control-position">
                                            <i class="feather icon-lock"></i>
                                        </div>
                                        <label for="user-password">Confirmar Contraseña</label>
                                    </fieldset>
                                    <a href="{{ url('account/my-payments/'.config('customer.customers_token')) }}" class="btn btn-outline-primary float-left btn-inline">Saltar</a>
                                    <button type="submit" class="btn btn-primary float-right btn-inline">Cambiar Contraseña</button>
                                    <br><br>
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