@extends(config('solunes.dashadmin_layout'))
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')
<div class="container solunes-store">
  <div class="account-profile">

    <div class="row">
      <div class="col-md-3 profile-actual">
      </div>
      <div class="col-md-6 edit-profile">
        <h2>Resetear Contraseña</h2>

        <form class="account-settings-form" action="{{ url('account/reset-password') }}" method="post">
        
          <p class="small-paragraph-spacing">Está a punto de terminar. Solo debe introducir una nueva contraseña para su cuenta aqui.</p>
          <div class="row form-section">
            <div class="col-sm-12 col-md-12">
              <div class="form-group">
                <label for="password" class="col-form-label">Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-12 col-md-12">
              <div class="form-group">
                <label for="password_confirmation" class="col-form-label">Confirmar Contraseña:</label>
                <input type="password" class="form-control" name="password_confirmation" id="confirm-password" placeholder="">
              </div>
            </div><!-- close .col -->
          </div><!-- close .row -->
          <br>
          <p>
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="submit" class="btn btn-site" value="Actualizar Contraseña"></p>
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