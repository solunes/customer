@extends('master::layouts/admin')

@section('content')
<h1>Editar Cuenta</h1>
@if($customer)
  @include('includes.member')
  <form action="{{ url('admin/edit-account') }}" method="post" class="tg-commentform help-form">
    <fieldset class="row">
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Nombres</span>
        {{ Form::text('first_name', $customer->first_name, ['class'=>'form-control', 'required'=>true, 'placeholder'=>'EJ: Ricardo']) }}
      </div></div>
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Apellidos</span>
        {{ Form::text('last_name', $customer->last_name, ['class'=>'form-control', 'required'=>true, 'placeholder'=>'EJ: Diaz']) }}
      </div></div>
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Email</span>
        {{ Form::text('email', $customer->email, ['class'=>'form-control', 'required'=>$custom_rules, 'placeholder'=>'EJ: rdiaz@gmail.com']) }}
      </div></div>
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Teléfono Celular</span>
          {{ Form::text('cellphone', $customer->cellphone, ['class'=>'form-control', 'required'=>false, 'placeholder'=>'EJ: 70550000']) }}
      </div></div>
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Número de NIT</span>
        {{ Form::text('nit_number', $customer->nit_number, ['class'=>'form-control', 'required'=>false, 'placeholder'=>'EJ: 4765754017']) }}
      </div></div>
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Razón Social</span>
        {{ Form::text('nit_name', $customer->nit_name, ['class'=>'form-control', 'required'=>false, 'placeholder'=>'EJ: Diaz']) }}
      </div></div>
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Fecha de Nacimiento</span>
          {{ Form::text('birth_date', $customer->birth_date, ['class'=>'form-control datepicker-max', 'required'=>true, 'placeholder'=>'EJ: 1980-04-27']) }}
      </div></div>
      @if(config('customer.fields.city')||config('sales.delivery_city'))
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Ciudad</span>
        {{ Form::text('city_id', $customer->city_id, ['class'=>'form-control', 'required'=>false, 'placeholder'=>'EJ: Zona Calle # puerta']) }}
      </div></div>
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Ciudad (Otro)</span>
        {{ Form::text('city_other', $customer->city_other, ['class'=>'form-control', 'required'=>false, 'placeholder'=>'EJ: Zona Calle # puerta']) }}
      </div></div>
      @endif
      @if(config('customer.fields.address')||config('sales.ask_address'))
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Dirección</span>
        {{ Form::text('address', $customer->address, ['class'=>'form-control', 'required'=>false, 'placeholder'=>'EJ: Zona Calle # puerta']) }}
      </div></div>
      <div class="col-sm-6"><div class="form-group">
        <span class="control-label">Dirección (Extra)</span>
        {{ Form::text('address_extra', $customer->address_extra, ['class'=>'form-control', 'required'=>false, 'placeholder'=>'EJ: Zona Calle # puerta']) }}
      </div></div>
      @endif
    </fieldset>
    <input type="hidden" name="action" value="edit" />
    <input type="hidden" name="customer_id" value="{{ $customer->id }}" />
    <button type="submit" class="btn btn-site">Guardar</button>
  </form>
@else
  <p>No tiene una cuenta de cliente disponible.</p>
@endif
@endsection