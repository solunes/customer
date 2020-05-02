@extends('master::layouts/admin-2')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')

<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <h2 class="content-header-title float-left mb-0">Mis Pagos Pendientes</h2>
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url(config('customer.redirect_after_login')) }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Mis Pagos Pendientes</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Data list view starts -->
<section id="data-thumb-view" class="data-thumb-view-header">
  <!-- dataTable starts -->
  <form name="checkbox_general" class="realform" id="checkbox_general" method="post" action="{{ url('pagostt/make-checkbox-payment') }}" style="max-width: 100% !important;">
  <input type="hidden" name="customer_id" value="{{ $customer->id }}"/>
  <div class="table-responsive">
    @if(count($customer->pending_payments)>0)
      <table class="table data-thumb-view pending_payments-class">
          <thead>
              <tr>
                  <th></th>
                  <!--<th></th>-->
                  <th>DETALLE</th>
                  <th>ESTADO</th>
                  <th>MONTO</th>
                  <th>FACTURA</th>
                  <th>ACCIÓN</th>
              </tr>
          </thead>
          <tbody>
            @foreach($customer->pending_payments as $payment)
              <tr>
                  <td><label class="payment-check-label">Seleccionar <input type="checkbox" class="check payment-check" name="check[]" id="check-{{ $payment->id }}" @if($payment->can_pay==0) data-isblocked="true" @else data-isblocked="false" @endif data-block="[]" data-currencyid="{{ $payment->currency_id }}" data-hasinvoice="{{ $payment->invoice }}" @if($payment->payment_check_inverse) data-paymentcheckid="{{ $payment->payment_check_inverse->id }}" data-paymentcheckid2="{{ $payment->payment_check_inverse->id }}" @else data-paymentcheckid="" data-paymentcheckid2="" @endif @if($payment->can_pay==0) disabled="true" @endif value="{{ $payment->id }}" /></label></td>
                  <!--<td class="product-img"><img src="{{ asset('assets/img/banner-wide.jpg') }}" alt="Banner"></td>-->
                  <td class="product-category">
                    {{ $payment->payment_item->name }}
                  </td>
                  <td> {{ trans('payments::admin.'.$payment->status) }} </td>
                  <td class="product-price"><span class="just-show-mobile">Monto: </span>Bs. {{ $payment->amount }} </td>
                  <td> {{ trans('payments::admin.'.$payment->invoice) }} </td>
                  <td>
                    <div class="item-options text-center">
                      <div class="wishlist remove-wishlist">
                        @if(config('payments.customer_cancel_payments')&&$payment->customer_cancel_payments&&$payment->status=='holding')
                        <a href="{{ url('payments/cancel-payment/'.$payment->id) }}">
                          <i class="feather icon-x align-middle"></i> Cancelar
                        </a>
                        @endif
                      </div>
                      <div class="cart move-cart">
                        @if($payment->can_pay==1&&$payment->sale_payment->payment_method->code=='pagostt')
                        <a href="{{ url('pagostt/make-single-payment/'.$customer->id.'/'.$payment->id) }}">
                          <i class="feather icon-home"></i> <span class="move-to-cart">Realizar pago</span>
                        </a>
                        @else
                        Pago deshabilitado
                        @endif
                      </div>
                    </div>
                  </td>
              </tr>
            @endforeach
          </tbody>
      </table>
      <br>
      <button type="submit" class="btn btn-full btn-primary mr-1 mb-1 waves-effect waves-light btn-pay-checkbox">PAGAR SELECCIÓN</button>
      <a href="{{ url('pagostt/make-all-payments/'.$customer->id) }}">
        <button type="button" class="btn btn-full btn-primary mr-1 mb-1 waves-effect waves-light">PAGAR TODO</button>
      </a>
    @else
      <p>Actualmente no tiene pagos realizados en el sistema.</p>
    @endif
  </div>
  </form>
  <!-- dataTable ends -->
</section>
@endsection

@section('script')
  <script>
  $( document ).ready(function() {
    @foreach($customer->pending_payments as $payment)
      changeCheck('form#checkbox_general', $('#check-{{ $payment->id }}'));
    @endforeach
    formCheck('form#checkbox_general');
  });
  $('form#checkbox_general').on('change','.check',function() {
    changeCheck('form#checkbox_general', this);
    formCheck('form#checkbox_general');
  });
  function changeCheck(form_general_id, field) {
    var currencyid = $(field).data('currencyid');
    if(currencyid==1){
      var othercurrency = 2;
    } else {
      var othercurrency = 1;
    }
    var hasinvoice = $(field).data('hasinvoice');
    if(hasinvoice==1){
      var otherhasinvoice = 0;
    } else {
      var otherhasinvoice = 1;
    }
    console.log('hasinvoice:'+hasinvoice);
    console.log('otherhasinvoice:'+otherhasinvoice);

    $(form_general_id+" .check[data-currencyid='"+othercurrency+"']").each(function() {
      if($(field).is(":checked")){
        if ($(this).attr('data-currencyid') != currencyid) {
          checkBlock($(this), 1, true);
        }
      } else {
        if ($(this).attr('data-currencyid') != currencyid) {
          check_currencies = true;
          $(form_general_id+" .check[data-currencyid='"+currencyid+"']").each(function() {
            if($(this).is(":checked")){
              check_currencies = false;
            };
          });
          if(check_currencies===true){
            checkBlock($(this), 1, false);
          }
        }
      }
    });
    
    /*$(form_general_id+" .check[data-hasinvoice='"+otherhasinvoice+"']").each(function() {
      if($(field).is(":checked")){
        if ($(this).attr('data-hasinvoice') != hasinvoice) {
          checkBlock($(this), 4, true);
        }
      } else {
        if ($(this).attr('data-hasinvoice') != hasinvoice) {
          check_invoices = true;
          $(form_general_id+" .check[data-hasinvoice='"+hasinvoice+"']").each(function() {
            if($(this).is(":checked")){
              check_invoices = false;
            };
          });
          if(check_invoices===true){
            checkBlock($(this), 4, false);
          }
        }
      }
    });*/

    var paymentcheckid = $(field).data('paymentcheckid');
    if(paymentcheckid){
      var paymentcheckfield = $('#check-'+paymentcheckid);
      if($(field).is(":checked")){
        checkBlock(paymentcheckfield, 2, false);
      } else {
        checkBlock(paymentcheckfield, 2, true);
      }
    }

    var paymentcheckid2 = $(field).data('paymentcheckid2');
    if(paymentcheckid2){
      var paymentcheckfield2 = $('#check-'+paymentcheckid2);
      if($(field).is(":checked")){
        checkBlock(paymentcheckfield2, 3, false);
      } else {
        checkBlock(paymentcheckfield2, 3, true);
      }
    }

    return true;
  }
  function checkBlock(item, id, status) {
    var block = item.attr('data-block');
    console.log('Check block: '+block);
    if(!block){
      block = item.data('block');
    }
    block = JSON.parse(block);
    console.log('Block check: '+item.val()+' - '+id+' ('+JSON.stringify(block)+')');
    if(status){
      if(!block.includes(id)){
        block.push(id);
        console.log('Block includes now: '+item.val()+' - '+id+' ('+JSON.stringify(block)+')');
        changeBlock(item, block)
        if(block.length>0){
          if(item.prop('disabled')==false){
            hasChanged(true, item);
          }
        } else {
          if(item.prop('disabled')==true){
            hasChanged(false, item);
          }
        }
      }
    } else {
      if(block.includes(id)){
        var index = block.indexOf(id);
        if (index > -1) {
          block.splice(index, 1);
        }
        console.log('Block includes no more: '+item.val()+' - '+id+' ('+JSON.stringify(block)+')');
        changeBlock(item, block)
        if(block.length>0){
          if(item.prop('disabled')==false){
            hasChanged(true, item);
          }
        } else {
          if(item.prop('disabled')==true){
            hasChanged(false, item);
          }
        }
      }
    }
  }
  function changeBlock(item, block){
    block = JSON.stringify(block);
    item.attr('data-block', block);
    console.log('Change block: '+item.val()+' - '+block);
  }
  function hasChanged(action, item, change){
    item.prop('disabled', action);
    if(action==true){
      item.prop('checked', false);
    }
    console.log('Applying change: '+item.val());
    item.trigger( "change" );
  }
  function formCheck(form_id){
    var filled_form = false;
    $(form_id+' .check').each(function() {
      if($(this).is(":checked")){
        filled_form = true;
        //alert('is checked');
      }
    });
    if(filled_form){
      $(form_id+' .btn-pay-checkbox').prop('disabled', false);
    } else {
      $(form_id+' .btn-pay-checkbox').prop('disabled', true);
    }
  }
  </script>
@endsection