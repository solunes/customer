@extends('master::layouts/admin-2')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')

<div class="content-header-left col-md-9 col-12 mb-2">
  <div class="row breadcrumbs-top">
      <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Suscripciones</h2>
          <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ url(config('customer.redirect_after_login')) }}">Inicio</a></li>
                  <li class="breadcrumb-item active">Suscripciones
                  </li>
              </ol>
          </div>
      </div>
  </div>
</div>
<!-- Data list view starts -->
<section id="data-thumb-view bg-variants" class="data-thumb-view-header">
  <div class="row">
    @foreach($items as $item)
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card border-info text-center bg-transparent">
            <div class="card-content d-flex">
                <div class="card-body">
                  @if($type=='subscription-plan'||($type=='subscription'&&count($item->subscription_plans)==1))
                    <?php if($type=='subscription'&&count($item->subscription_plans)==1){ $item = $item->subscription_plan; } ?>
                    <h4 class="card-title">{{ $item->parent->name }}: {{ $item->name }}</h4>
                    <div class="price">
                      <h2>USD {{ $item->price }}</h2>
                      @if($item->type=='custom')
                      <span>{{ $item->custom_days }} días</span>
                      @else
                      <span>{{ trans('customer::admin.'.$item->type) }}</span>
                      @endif
                    </div>
                    <p class="card-text">
                      <ul class="list-group list-group-flush">
                        @foreach($item->parent->subscription_benefits as $subscription_benefit)
                          <li class="list-group-item">
                              <i class="feather icon-{{ $subscription_benefit->icon }}"></i>&nbsp; {{ $subscription_benefit->name }}
                          </li>
                        @endforeach
                      </ul>
                    </p>
                    <a class="btn btn-info waves-effect waves-light btn-block" href="{{ url('account/accept-subscription/'.$item->parent_id.'/'.$item->id) }}">Contratar</a>
                  @else
                    <h4 class="card-title">{{ $item->name }}</h4>
                    <div class="price">
                      <h2>{{ count($item->subscription_plans) }}</h2>
                      <span>Planes</span>
                    </div>
                    <p class="card-text">
                      <ul class="list-group list-group-flush">
                        @foreach($item->subscription_benefits as $subscription_benefit)
                          <li class="list-group-item">
                              <i class="feather icon-{{ $subscription_benefit->icon }}"></i>&nbsp; {{ $subscription_benefit->name }}
                          </li>
                        @endforeach
                      </ul>
                    </p>
                    <a class="btn btn-info waves-effect waves-light btn-block" href="{{ url('account/subscriptions/'.$item->id.'/1354351278') }}">Ver Planes</a>
                  @endif
                </div>
            </div>
          </div>
      </div>
    @endforeach
  </div>
</section>
<!-- Data list view end -->
@endsection

@section('script')
  <!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection