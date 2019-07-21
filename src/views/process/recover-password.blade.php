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
        <h2>Recuperar Contraseña</h2>

        <form class="account-settings-form" action="{{ url('account/recover-password') }}" method="post">
        
          <p class="small-paragraph-spacing">Solo introduce tu correo electrónico o carnet de identidad para recuperar tu contraseña.</p>
          <div class="row form-section">
            <div class="col-sm-12 col-md-12">
              <div class="form-group">
                <label for="email" class="col-form-label">Email:</label>
                <input type="text" class="form-control" name="email" id="current-email" placeholder="">
              </div>
            </div><!-- close .col -->
          </div><!-- close .row -->
          <br>
          <p>
            <input type="submit" class="btn btn-site" value="Recuperar Contraseña"></p>
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