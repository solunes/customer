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

                    <div class="card ecommerce-card">
                        <div class="card-content">
                            <div class="item-img text-center">
                                <img src="http://www.redusers.com/noticias/wp-content/uploads/2017/06/digital_evento_sitio-600x450.jpg" class="img-fluid" alt="img-placeholder">
                            </div>
                            <div class="card-body">
                                <div class="item-wrapper">
                                    <div>
                                        <h4 class="item-price">
                                            PRECIO: $19.99
                                        </h4>
                                    </div>
                                </div>
                                <div class="item-name">
                                    <span>Lorem ipsum dolor sit amet consectetur adipisicing.</span>
                                </div>
                                <div>
                                    <p class="item-description">
                                        These Sony ZX Series MDRZX110/BLK headphones feature neodymium magnets and 30mm drivers for powerful,
                                        reinforced sound. Enjoy your favorite songs with lush bass response thanks to the Acoustic Bass Booster
                                        technology.
                                    </p>
                                </div>
                            </div>
                            <div class="item-options text-center">
                                <div class="wishlist remove-wishlist">
                                    <i class="feather icon-x align-middle"></i> Cancelar
                                </div>
                                <div class="cart move-cart">
                                    <i class="feather icon-home"></i> <span class="move-to-cart">Realizar pago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
                <!-- Wishlist Ends -->            
            </div>
@endsection

@section('script')
  <!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection