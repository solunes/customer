@extends('master::layouts/admin-2')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')

<div class="content-header-left col-md-9 col-12 mb-2">
  <div class="row breadcrumbs-top">
      <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Historial de Pagos</h2>
          <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url(config('customer.redirect_after_login')) }}">Inicio</a></li>
                  <li class="breadcrumb-item active">Historial de Pagos
                  </li>
              </ol>
          </div>
      </div>
  </div>
</div>
<!-- Data list view starts -->
<section id="data-thumb-view" class="data-thumb-view-header">
  <!-- dataTable starts -->
  <div class="table-responsive">
      <table class="table data-thumb-view">
          <thead>
              <tr>
                  <th></th>
                  <th>IMAGEN</th>
                  <th>DETALLE</th>
                  <th>ESTADO</th>
                  <th>MONTO</th>
              </tr>
          </thead>
          <tbody>
            @foreach($customer->paid_payments as $payment)
              <tr>
                  <td></td>
                  <?php $sale_item_id = $payment->payment_item->item_id; ?>
                  <td class="product-img">
                    <?php $sale_image = \Solunes\Sales\App\SaleItem::find($sale_item_id); ?>
                    @if($sale_image&&$sale_image->product_bridge->image)
                      <img src="{{ asset(\Asset::get_image_path('product-bridge-image','thumb',$sale_image->product_bridge->image)) }}" alt="Banner">
                    @endif
                  </td>
                  <td class="product-name">{{ $payment->name }}</td>
                  <!--<td class="product-category">Suscripción anual</td>-->
                  <td>
                      <div class="chip chip-warning">
                          <div class="chip-body">
                              @if($payment->invoice_url)
                                <div class="chip-text"><a target="_blank" href="{{ $payment->invoice_url }}">Ver Factura</a></div>
                              @elseif($payment->receipt_url)
                                <div class="chip-text"><a target="_blank" href="{{ asset(\Asset::get_file('payment-receipt_file',$payment->receipt_url)) }}">Ver Recibo</a></div>
                              @else
                                <div class="chip-text"><a href="#">-</a></div>
                              @endif
                          </div>
                      </div>
                  </td>
                  <td class="product-price">Bs. {{ $payment->amount }}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
  </div>
  <!-- dataTable ends -->
</section>
@endsection

@section('script')
  <!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection