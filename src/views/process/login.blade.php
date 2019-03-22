@extends('layouts/master')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')
<div class="container solunes-store">
  <div class="account-profile">

    <div class="row">
      <div class="col-md-2 profile-actual">

      </div>
      <div class="col-md-8 edit-profile">
        <h2>Iniciar Sesión</h2>

        <form class="account-settings-form" action="{{ url('auth/login') }}" method="post">
        
          <p class="small-paragraph-spacing">Si ya tienes una cuenta, ingresa con tu correo electrónico / carnet de identidad y contraseña.</p>
          <div class="row form-section">
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label for="user" class="col-form-label">Email / CI:</label>
                <input type="text" class="form-control" name="user" id="current-user" placeholder="">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
              <div>
                <label for="password" class="col-form-label">Contraseña:</label></div>
                <input type="password" class="form-control" name="password" id="password" placeholder="">
              </div>
            </div><!-- close .col -->
          </div><!-- close .row -->
          <br>
          <p><input type="submit" class="btn btn-site" value="Ingresar"></p>
        </form>

        @if(config('solunes.socialite'))
        <div class="form-horizontal"><br>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              @if(config('solunes.socialite_google'))
                <a href="{{ url('/auth/google') }}" class="auth-btn auth-btn-google"><button class="btn btn-site"><i class="fa fa-google"></i> Google Plus</button></a>
              @endif
              @if(config('solunes.socialite_facebook'))
                <a href="{{ url('/auth/facebook') }}" class="auth-btn auth-btn-facebook"><button class="btn btn-site"><i class="fa fa-facebook"></i> Facebook</button></a>
              @endif
              @if(config('solunes.socialite_twitter'))
                <a href="{{ url('/auth/twitter') }}" class="auth-btn auth-btn-twitter"><button class="btn btn-site"><i class="fa fa-twitter"></i> Twitter</button></a>
              @endif
              @if(config('solunes.socialite_github'))
                <a href="{{ url('/auth/github') }}" class="auth-btn auth-btn-github"><button class="btn btn-site"><i class="fa fa-github"></i> GitHub</button></a>
              @endif
            </div>
          </div>
        </div>
        @endif

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