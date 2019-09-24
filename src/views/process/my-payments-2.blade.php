@extends('master::layouts/admin-2')
@include('helpers.meta')

@section('css')
  <link rel="stylesheet" href="{{ asset('assets/sales/store.css') }}">
@endsection

@section('content')
            <div class="content-body">             
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

                    <div class="card ecommerce-card">
                        <div class="card-content">
                            <div class="item-img text-center">
                                <img src="https://www.introspeccion.com/wp-content/uploads/2019/03/2019-03-02-Vigo-mr-1.jpg" class="img-fluid" alt="img-placeholder">
                            </div>
                            <div class="card-body">
                                <div class="item-wrapper">
                                    <div>
                                        <h4 class="item-price">
                                            PRECIO: $49.99
                                        </h4>
                                    </div>
                                </div>
                                <div class="item-name">
                                    <span>
                                       Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aut eaque explicabo assumenda.
                                    </span>
                                </div>
                                <div>
                                    <p class="item-description">
                                        Place the sleek form of this ASUS desktop computer tower on your desk, and take your gaming to the next
                                        level. With Intel Core i7 processing inside, this speedy desktop keeps up with even multilayered action
                                        games. Nvidia graphics on this ASUS desktop computer help eliminate ghosting and stutter so you see
                                        every move your enemy makes.
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

                    <div class="card ecommerce-card">
                        <div class="card-content">
                            <div class="item-img text-center">
                                <img src="https://www.inau.gub.uy/images/stories/flexicontent/mediaman/l_020.jpg" class="img-fluid" alt="img-placeholder">
                            </div>
                            <div class="card-body">
                                <div class="item-wrapper">
                                    <div>
                                        <h4 class="item-price">
                                            PRECIO: $44.99
                                        </h4>
                                    </div>
                                </div>
                                <div class="item-name">
                                    <span>
                                        Lorem ipsum dolor sit amet.
                                    </span>
                                </div>
                                <div>
                                    <p class="item-description">
                                        This Sony 4K HDR TV boasts 4K technology for vibrant hues. Its X940D series features a bold 75-inch
                                        screen and slim design. Wires remain hidden, and the unit is easily wall mounted. This television has a
                                        4K Processor X1 and 4K X-Reality PRO for crisp video. This Sony 4K HDR TV is easy to control via voice
                                        commands.
                                    </p>
                                </div>
                            </div>
                            <div class="item-options text-center">
                                <div class="wishlist remove-wishlist">
                                    <i class="feather icon-x align-middle"></i> Cancelar
                                </div>
                                <div class="cart view-cart">
                                    <i class="feather icon-home"></i> <a href="app-ecommerce-checkout.html" class="view-in-cart">Realizar pago</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card ecommerce-card">
                        <div class="card-content">
                            <div class="item-img text-center">
                                <img src="http://www.redusers.com/noticias/wp-content/uploads/2015/08/IMG_2044-600x450.jpg" class="img-fluid" alt="img-placeholder">
                            </div>
                            <div class="card-body">
                                <div class="item-wrapper">
                                    <div>
                                        <h4 class="item-price">
                                            PRECIO: $59.99
                                        </h4>
                                    </div>
                                </div>
                                <div class="item-name">
                                    <span>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                    </span>
                                </div>
                                <div>
                                    <p class="item-description">
                                        Map your adventure with this Garmin Fenix 5 GPS watch. Built-in navigation lets you know where you are
                                        when hiking or camping, and integrated Wi-Fi connects to the Garmin Connect to track your fitness level
                                        and daily steps. This Garmin Fenix 5 GPS watch is water-resistant up to 100m for use in wet conditions.
                                    </p>
                                </div>
                            </div>
                            <div class="item-options text-center">
                                <div class="wishlist remove-wishlist">
                                    <i class="feather icon-x align-middle"></i> Cancelar
                                </div>
                                <div class="cart move-cart">
                                    <i class="feather icon-home"></i> <span class="add-to-cart">Realizar pago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card ecommerce-card">
                        <div class="card-content">
                            <div class="item-img text-center">
                                <img src="http://www.cgb.edu.gt/images/Galeria/2019alb08/images/photos/01.jpg" class="img-fluid" alt="img-placeholder">
                            </div>
                            <div class="card-body">
                                <div class="item-wrapper">
                                    <div>
                                        <h4 class="item-price">
                                            PRECIO: $69.99
                                        </h4>
                                    </div>
                                </div>
                                <div class="item-name">
                                    <span>
                                        Lorem ipsum dolor, sit amet consectetur adipisicing.
                                    </span>
                                </div>
                                <div>
                                    <p class="item-description">
                                        This Garmin fenix 3 Sapphire GPS watch comes with a titanium bezel and band, providing style and
                                        strength. This watch is waterproof up to 100m, and it comes with state-of-the-art fitness training
                                        features such as advanced running dynamics with vertical oscillation and vertical ratio. Track your
                                        activity and stay fit with the Garmin fenix 3 Sapphire GPS watch.
                                    </p>
                                </div>
                            </div>
                            <div class="item-options text-center">
                                <div class="wishlist remove-wishlist">
                                    <i class="feather icon-x align-middle"></i> Cancelar
                                </div>
                                <div class="cart move-cart">
                                    <i class="feather icon-home"></i> <span class="add-to-cart">Realizar pago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card ecommerce-card">
                        <div class="card-content">
                            <div class="item-img text-center">
                                <img src="https://www.ciat.org/wp-content/uploads/photo-gallery/eventos/CT/2015-italia/2015CT004.jpg" class="img-fluid" alt="img-placeholder">
                            </div>
                            <div class="card-body">
                                <div class="item-wrapper">
                                    <div>
                                        <h6 class="item-price">
                                            PRECIO: $19.99
                                        </h6>
                                    </div>
                                </div>
                                <div class="item-name">
                                    <span>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos, cumque.
                                    </span>
                                </div>
                                <div>
                                    <p class="item-description">
                                        Alienware Laptop: Bring video games to life with this 17.3-inch Dell Alienware laptop. It has a powerful
                                        quad-core Intel Core i7 processor and 16GB of DDR4 RAM to run modern games quickly, and its 1TB hard
                                        drive stores plenty of game and other files. This Dell Alienware laptop has a 2.1 speaker configuration
                                        with a subwoofer for a dynamic gaming experience.
                                    </p>
                                </div>
                            </div>
                            <div class="item-options text-center">
                                <div class="wishlist remove-wishlist">
                                    <i class="feather icon-x align-middle"></i> Cancelar
                                </div>
                                <div class="cart move-cart">
                                    <i class="feather icon-home"></i> <span class="add-to-cart">Realizar pago</span>
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