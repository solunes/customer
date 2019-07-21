@extends(config('solunes.dashadmin_layout'))
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')
<div class="container solunes-store">
  <div class="account-profile">

    <div class="row">
      <div class="col-md-12 edit-profile">
        <h2>Editar Contraseña</h2>

        <form class="account-settings-form" action="{{ url('account/change-password') }}" method="post">
        
          <p class="small-paragraph-spacing">Le recomendamos que cambie su contraseña por una segura aquí.</p>
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
          <p><input type="submit" class="btn" value="Editar Contraseña"></p>
          
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