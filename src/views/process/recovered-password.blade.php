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
        <h2>Revise su Correo Electrónico</h2>

          <p class="small-paragraph-spacing">Enviamos un correo electrónico con los pasos para restablecer su contraseña.</p>
          <br>
          <p>
            <a href="{{ url('account/recover-password/'.request()->segment(3)) }}">
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