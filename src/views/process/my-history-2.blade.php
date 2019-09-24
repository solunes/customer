@extends('master::layouts/admin-2')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')

<div class="content-header-left col-md-9 col-12 mb-2">
  <div class="row breadcrumbs-top">
      <div class="col-12">
          <h2 class="content-header-title float-left mb-0">Resumen de Suscripciones</h2>
          <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Home</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#">Data List</a>
                  </li>
                  <li class="breadcrumb-item active">Resumen de Suscripciones
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
                  <th>NOMBRE DEL EVENTO</th>
                  <th>TIPO DE SUSCRIPCIÓN</th>
                  <th>ESTADO DE LA SUSCRIPCIÓN</th>
                  <th>PRECIO</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td></td>
                  <td class="product-img"><img src="http://www.redusers.com/noticias/wp-content/uploads/2017/06/digital_evento_sitio-600x450.jpg" alt="Img placeholder">
                  </td>
                  <td class="product-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi.</td>
                  <td class="product-category">Suscripción anual</td>

                  <td>
                      <div class="chip chip-warning">
                          <div class="chip-body">
                              <div class="chip-text">Realizar pago</div>
                          </div>
                      </div>
                  </td>
                  <td class="product-price">$69.99</td>
              </tr>
              <tr>
                  <td></td>
                  <td class="product-img"><img src="https://www.introspeccion.com/wp-content/uploads/2019/03/2019-03-02-Vigo-mr-1.jpg" alt="Img placeholder">
                  </td>
                  <td class="product-name">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</td>
                  <td class="product-category">Suscripción anual</td>

                  <td>
                      <div class="chip chip-success">
                          <div class="chip-body">
                              <div class="chip-text" data-toggle="modal" data-target="#large">Ver Factura</div>
                          </div>
                      </div>
                      
                  </td>
                  <td class="product-price">$69.99</td>
              </tr>
              <tr>
                  <td></td>
                  <td class="product-img"><img src="https://www.inau.gub.uy/images/stories/flexicontent/mediaman/l_020.jpg" alt="Img placeholder">
                  </td>
                  <td class="product-name">Lorem ipsum dolor sit amet consectetur.</td>
                  <td class="product-category">Suscripción mensual</td>

                  <td>
                      <div class="chip chip-danger">
                          <div class="chip-body">
                              <div class="chip-text">canceled</div>
                          </div>
                      </div>
                  </td>
                  <td class="product-price">$199.99</td>
              </tr>
              <tr>
                  <td></td>
                  <td class="product-img"><img src="http://www.redusers.com/noticias/wp-content/uploads/2015/08/IMG_2044-600x450.jpg" alt="Img placeholder">
                  </td>
                  <td class="product-name">Lorem ipsum dolor sit amet consectetur.</td>
                  <td class="product-category">Suscripción anual</td>

                  <td>
                      <div class="chip chip-warning">
                          <div class="chip-body">
                              <div class="chip-text">Realizar pago</div>
                          </div>
                      </div>
                  </td>
                  <td class="product-price">$29.99</td>
              </tr>
              <tr>
                  <td></td>
                  <td class="product-img"><img src="http://www.cgb.edu.gt/images/Galeria/2019alb08/images/photos/01.jpg" alt="Img placeholder">
                  </td>
                  <td class="product-name">Aluratek - Bluetooth Suscripción mensual Transmitter</td>
                  <td class="product-category">Suscripción mensual</td>

                  <td>
                      <div class="chip chip-danger">
                          <div class="chip-body">
                              <div class="chip-text">canceled</div>
                          </div>
                      </div>
                  </td>
                  <td class="product-price">$199.99</td>
              </tr>

          </tbody>
      </table>
  </div>
  <!-- dataTable ends -->

</section>
<!-- Data list view end -->

    <!-- Modal -->
    <div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel17">Datos de la factura</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="card-content">
                      <div class="card-body">
                          <ul class="activity-timeline timeline-left list-unstyled">
                                  <li>
                                          <div class="timeline-icon bg-success">
                                              <i class="feather icon-check font-medium-2"></i>
                                          </div>
                                          <div class="timeline-info">
                                              <p class="font-weight-bold">Nombres y apellidos:</p>
                                              <span>Juan Perez Valdivia
                                              </span>
                                          </div>
                                          <small class="">Usuario desde 22 de Junio 2019</small>
                                      </li>
                                      <li>
                                              <div class="timeline-icon bg-success">
                                                  <i class="feather icon-check font-medium-2"></i>
                                              </div>
                                              <div class="timeline-info">
                                                  <p class="font-weight-bold">NIT:</p>
                                                  <span>34125t345745673445
                                                  </span>
                                              </div>
                
                                          </li>
                                          <li>
                                                  <div class="timeline-icon bg-success">
                                                      <i class="feather icon-check font-medium-2"></i>
                                                  </div>
                                                  <div class="timeline-info">
                                                      <p class="font-weight-bold">Razón social:</p>
                                                      <span>Perez
                                                      </span>
                                                  </div>
                    
                                              </li>
                                      <li>
                                              <div class="timeline-icon bg-success">
                                                  <i class="feather icon-check font-medium-2"></i>
                                              </div>
                                              <div class="timeline-info">
                                                  <p class="font-weight-bold">Dirección de domicilio:</p>
                                                  <span>Calle 13, Calacoto. La Paz, Bolivia.
                                                  </span>
                                              </div>
                                              <small class="">La Paz - Bolivia</small>
                                          </li>
                                          <li>
                                                  <div class="timeline-icon bg-success">
                                                      <i class="feather icon-check font-medium-2"></i>
                                                  </div>
                                                  <div class="timeline-info">
                                                      <p class="font-weight-bold">Nombre del evento:</p>
                                                      <span>Lorem ipsum dolor sit amet, consectetur adipisicing.
                                                      </span>
                                                  </div>
                                                  <small class="">20 de octubre, 2019</small>
                                              </li>
                                              
                              <li>
                                  <div class="timeline-icon bg-success">
                                      <i class="feather icon-check font-medium-2"></i>
                                  </div>
                                  <div class="timeline-info">
                                      <p class="font-weight-bold">Tipo de Suscripción</p>
                                      <span>Anual
                                      </span>
                                  </div>
                                  <small class="">Vence el 20 de Octubre, 2020</small>
                              </li>
                              <li>
                                      <div class="timeline-icon bg-success">
                                          <i class="feather icon-check font-medium-2"></i>
                                      </div>
                                      <div class="timeline-info">
                                          <p class="font-weight-bold">Numero de Tarjeta Débito/Crédito:</p>
                                          <span>1115-5345-4987-****
                                          </span>
                                      </div>
                                      <small class="">Visa Mastercard</small>
                                  </li>
                          </ul>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
              </div>
          </div>
      </div>
      <style>
          .dt-checkboxes-cell {
              display: none;
          }
          .top {
              display: none !important;
          }
      </style>
  </div>
<!-- END: Content-->
@endsection

@section('script')
  <!--<script>
    new CBPFWTabs(document.getElementById('tabs'));
  </script>-->
@endsection