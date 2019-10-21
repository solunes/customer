@extends('master::layouts/admin-2')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')

<div class="content-header-left col-md-9 col-12 mb-2">
  <div class="row breadcrumbs-top">
      <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Mis Suscripciones</h2>
          <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url(config('customer.redirect_after_login')) }}">Inicio</a></li>
                  <li class="breadcrumb-item active">Mis Suscripciones
                  </li>
              </ol>
          </div>
      </div>
  </div>
</div>
<!-- Data list view starts -->
<section id="data-thumb-view" class="data-thumb-view-header">
  @foreach($items as $item)
    <!-- dataTable starts -->
    @if(count($item->customer_subscription_months)>0)
    <h2>{{ $item->name }}</h2>
    <div class="table-responsive">
      <table class="table data-thumb-view">
          <thead>
              <tr>
                  <th></th>
                  <th>DETALLE</th>
                  <th>FECHA INICIAL / FINAL</th>
                  <th>ESTADO</th>
                  <th>PAGO</th>
                  <th>MONTO</th>
              </tr>
          </thead>
          <tbody>
            @foreach($item->active_customer_subscription_months as $subitem)
              <tr>
                  <td></td>
                  <td class="product-name">{{ $subitem->subscription_plan->name }}</td>
                  <td class="product-category">{{ $subitem->initial_date }} / {{ $subitem->end_date }}</td>
                  <td class="product-category">{{ trans('customer::admin.'.$subitem->status) }}</td>
                  <td>
                    @if($subitem->status=='pending')
                      <div class="chip chip-success">
                        <div class="chip-body">
                          <div class="chip-text"><a target="_blank" href="{{ url('pagostt/make-single-payment/'.$item->customer_id.'/'.$subitem->sale->sale_payment->payment_id) }}">Pagar Ahora</a></div>
                        </div>
                      </div>
                    @elseif($subitem->invoice_url)
                      <div class="chip chip-warning">
                        <div class="chip-body">
                          <div class="chip-text"><a target="_blank" href="{{ $subitem->invoice_url }}">Ver Factura</a></div>
                        </div>
                      </div>
                    @else
                       - 
                    @endif
                  </td>
                  <td class="product-price">Bs. {{ $subitem->amount }}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
    </div>
    @endif
    <!-- dataTable ends -->
  @endforeach
</section>
@endsection

@section('script')
  <!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection