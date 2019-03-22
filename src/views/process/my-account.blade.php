@extends('layouts/master')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')
<div class="container solunes-store">
  <div class="account-profile">

    <div class="row">
      <div class="col-md-3 profile-actual">
        <div class="profile-picture">
          @if($customer->image)
            <img class="img-responsive" src="{{ asset(Asset::get_image_path('customer-image', 'normal', $customer->image)) }}" />
          @else
            <img class="img-responsive" src="{{ asset('assets/admin/img/user.jpg') }}" />
          @endif
        </div><br>
        @if(config('customer.fields.image'))
        {{Form::open(array('url' => url('account/edit-image'), 'class'=>'account-settings-form', 'method' => 'post', 'files' => true))}}
          {{ Form::file('image', ['id'=>'image','class'=>'form-control']) }}<br>
          <p><input type="submit" class="btn btn-green-pro" value="Subir Foto de Perfil" /></p>
        {{ Form::close() }}
        @endif
        @if($customer->image)
        <p><a href="{{ url('account/delete-image') }}" class="btn">Eliminar Foto</a></p>
        @endif
        <div class="profile-description">
          <h2>{{ $customer->name }}</h2>
          @if(config('customer.fields.city')&&$customer->city)
            <p><span class="p_title">Ciudad: </span>{{ $customer->city->name }}</p>
          @endif
          @if(config('customer.fields.address')&&$customer->address)
            <p><span class="p_title">Dirección: </span>{{ $customer->address.' -'.$customer->address_extra }}</p>
          @endif
          @if(config('customer.fields.invoice_data'))
            @if($customer->nit_number)
              <p><span class="p_title">NIT: </span>{{ $customer->nit_number }}</p>
            @endif
            @if($customer->nit_name)
              <p><span class="p_title">Razón Social: </span>{{ $customer->nit_name }}</p>
            @endif
          @endif
        </div>
      </div>
      <div class="col-md-9 edit-profile">
        <h2>Editar datos de Cuenta</h2>

        <form class="account-settings-form" action="{{ url('account/edit-customer') }}" method="post">
        
          <h5>Información General</h5>
          <p class="small-paragraph-spacing">Al saber tus datos personales, podemos hacer de tu experiencia mas cálida y cercana.</p>
          <div class="row form-section">
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label for="first-name" class="col-form-label">Nombre:</label>
                <input type="text" class="form-control" name="first_name" id="first-name" value="{{ $customer->first_name }}">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
              <label for="last-name" class="col-form-label">Apellido:</label>
                <input type="text" class="form-control" name="last_name" id="last-name" value="{{ $customer->last_name }}">
              </div>
            </div><!-- close .col -->
            @if(config('customer.fields.city'))
              <div class="col-sm-4 col-md-4">
                <div class="form-group">
                  <label for="last-name" class="col-form-label">Ciudad:</label>
                  {!! Form::select('city_id', $cities, $customer->city_id, ['class'=>'form-control custom-select']) !!}
                </div>
              </div><!-- close .col -->
            @endif
          </div><!-- close .row -->
          <div class="row form-section">
            @if(config('customer.fields.address'))
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label for="address" class="col-form-label">Dirección:</label>
                <input type="text" class="form-control" name="address" id="address" value="{{ $customer->address }}">
              </div>
            </div><!-- close .col -->
            @endif
            @if(config('customer.fields.invoice_data'))
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
              <label for="nit_number" class="col-form-label">NIT:</label>
                <input type="text" class="form-control" name="nit_number" id="nit_number" value="{{ $customer->nit_number }}">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label for="nit_name" class="col-form-label">Razón Social:</label>
                <input type="text" class="form-control" name="nit_name" id="nit_name" value="{{ $customer->nit_name }}">
              </div>
            </div><!-- close .col -->
            @endif
          </div><!-- close .row -->
          <br>
          <p><input type="submit" class="btn" value="Guardar Datos"></p>
          <br>
          <hr>
        </form>
        <form class="account-settings-form" action="{{ url('account/change-password') }}" method="post">
          <br>
          <h5>Cambiar contraseña</h5>
          <p class="small-paragraph-spacing">Puedes cambiar la contraseña de tu cuenta aqui.</p>
          <div class="row form-section">
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label for="password" class="col-form-label">Nueva Contraseña:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Mínimo 6 carácteres">
              </div>
            </div><!-- close .col -->
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
              <div>
                <label for="confirm_password" class="col-form-label">Confirmar contraseña:</label></div>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="">
              </div>
            </div><!-- close .col -->
          </div><!-- close .row -->
          <br>
          <p><input type="submit" class="btn" value="Cambiar Contraseña"></p>
          
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