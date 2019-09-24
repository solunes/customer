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


            <div class="content-body ecommerce-application">             
                <!-- Wishlist Starts -->
                <section id="wishlist" class="grid-view wishlist-items">
                    @foreach($customer->payments as $payment)
                    <div class="card ecommerce-card">
                        <div class="card-content">
                            <div class="item-img text-center">
                                <img src="http://www.redusers.com/noticias/wp-content/uploads/2017/06/digital_evento_sitio-600x450.jpg" class="img-fluid" alt="img-placeholder">
                            </div>
                            <div class="card-body">
                                <div class="item-wrapper">
                                    <div>
                                        <h4 class="item-price">
                                            Monto: Bs. {{ $payment->amount }}
                                        </h4>
                                    </div>
                                </div>
                                <div class="item-name">
                                    <span>{{ $payment->name }}</span>
                                </div>
                                <div>
                                    <p class="item-description">
                                        {{ $payment->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="item-options text-center">
                                <div class="wishlist remove-wishlist">
                                    <i class="feather icon-x align-middle"></i> Cancelar
                                </div>
                                <div class="cart move-cart">
                                  <a href="{{ url('pagostt/make-single-payment/'.$customer->id.'/'.$payment->id) }}">
                                    <i class="feather icon-home"></i> <span class="move-to-cart">Realizar pago</span>
                                  </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </section>
                <!-- Wishlist Ends -->            
            </div>
@endsection

@section('script')
  <!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection