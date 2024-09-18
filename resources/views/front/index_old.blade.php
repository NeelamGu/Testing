<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
    <!-- Static Banner Parallax Background-->
    <?php /* <section class="main-slider default-banner">
       <!--Carousel-->
       <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
          data-wrap="true">
          <div class="carousel-inner" role="listbox">
             <img src="{{ asset('front/images/banner2.png') }}" alt="" class="banner">
          </div>
          <div class="lower-content">
             <div class="auto-container">
                <div class="content-box shadow-lg p-3 mb-5 bg-body rounded">
                   <div class="row clearfix">
                      <div class="col-md-12">
                         <h4 class="text-thm title-border font-weight-700 mt-0 text-center">Your Wedding,
                            Your Way
                         </h4>
                         <p class="mb-10 text-center">Find the best wedding vendors with thousands of trusted
                            reviews.
                         </p>
                         <!-- Appointment Form Sart-->
                         <form id="appointment_form" name="appointment_form" class="form-transparent mt-30"
                            method="post" action="inc/rsvp.php">
                            <div class="row">
                               <div class="col-sm-5 border">
                                  <div class="styled-select">
                                     <select id="rsvp_category" name="rsvp_category" class="form-control"
                                        data-height="45px" required=""
                                        style="height: 45px; border-radius: 0px; border: 1px solid #e1e1e1;">
                                        <option value="All events">Select vendor type</option>
                                        <option value="Wedding Day">Wedding Day</option>
                                        <option value="Ceremony Day">Ceremony Day</option>
                                        <option value="Final Party">Final Party</option>
                                     </select>
                                  </div>
                               </div>
                               <div class="col-sm-5 rounded-0">
                                  <div class="styled-select2">
                                     <select id="rsvp_guest" name="rsvp_guest" class="form-control"
                                        data-height="45px" required=""
                                        style="height: 45px; border-radius: 0px; border: 1px solid #e1e1e1;">
                                        <option value="All events">Select city</option>
                                        <option value="one">1</option>
                                        <option value="Two">2</option>
                                        <option value="Three">3</option>
                                        <option value="Four">4</option>
                                        <option value="Five">5</option>
                                        <option value="Five-plus">5+</option>
                                     </select>
                                  </div>
                               </div>
                               <div class="col-sm-2">
                                  <input id="form_botcheck" name="form_botcheck"
                                     class="form-control bdrs-0" type="hidden" value="">
                                  <button type="submit" class="btn thm-btn btn-flat"
                                     data-loading-text="Please wait...">Get Started</button>
                               </div>
                            </div>
                         </form>
                         <!-- Appointment Form Validation-->
                         <!-- Appointment Form Ends -->
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </section> */ ?>
    <!--Get Quote Section-->
    <section class="get-quote">
       <div class="container p-0">
          <div class="row clearfix">
             <!--Column-->
             <div class="col-md-6 col-sm-12 col-xs-12 wow slideInLeft p-0" data-wow-delay="0ms"
                data-wow-duration="1500ms">
                <img class="img-intrest " src="{{ asset('front/images/intrest.jpg') }}" alt="">
             </div>
             <!--Column-->
             <div class="col-md-6 col-sm-12 col-xs-12 wow slideInRight p-sm-20">
                <br>
                <div class="sec-title style-three  mt-60">
                   <h2 class="text-thm">ARE YOU INTERESTED</h2>
                </div>
                <div class="form wow fadeInRight mt-20" data-wow-delay="0ms" data-wow-duration="1500ms">
                   <form method="post" action="index.html">
                      <div class="row clearfix">
                         <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <input type="text" name="fname" value="" placeholder="First Name *" required>
                         </div>
                         <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <input type="text" name="lname" value="" placeholder="Last Name *" required>
                         </div>
                         <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <input type="email" name="email" value="" placeholder="Email *" required>
                         </div>
                         <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <input type="text" name="phone" value="" placeholder="Phone *" required>
                         </div>
                         <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <textarea placeholder="Describe Your Needs to Us" required></textarea>
                         </div>
                         <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 form-group text-center">
                            <button type="submit" class="theme-btn normal-btn">I AM ATTENDING</button>
                         </div>
                      </div>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </section>
    <br><br><br>
    <!--Start Our Department Areas-->
    <section class="pop-category-sec">
       <div class="container-fluid popular-cat pb-35 pt-0">
          <div class="sec-title text-center">
             <div class="row">
                <div class="col-md-6 col-md-offset-3">
                   <h2 class="text-thm">Popular Categories</h2>
                </div>
             </div>
          </div>
          <div class="sec-content popular-cat-mar mt-50">
             <div class="auto-container">
                <div class="row">
                   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                      <div class="department">
                         <div class="department-details">
                            <div class="round-style"></div>
                            <i class="icon flaticon-roses-bouquet"></i>
                            <h4 class="title">Flowers</h4>
                            <p class="details pt-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                               elit.
                               Repudiandae quia eligendi libero, laborum quaerat hic.
                            </p>
                         </div>
                      </div>
                   </div>
                   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                      <div class="department">
                         <div class="department-details">
                            <div class="round-style"></div>
                            <i class="icon flaticon-wedding-cake-3"></i>
                            <h4 class="title">Cakes</h4>
                            <p class="details pt-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                               elit.
                               Repudiandae quia eligendi libero, laborum quaerat hic.
                            </p>
                         </div>
                      </div>
                   </div>
                   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                      <div class="department">
                         <div class="department-details">
                            <div class="round-style"></div>
                            <i class="icon flaticon-knife-fork-and-plate"></i>
                            <h4 class="title">Catering</h4>
                            <p class="details pt-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                               elit.
                               Repudiandae quia eligendi libero, laborum quaerat hic.
                            </p>
                         </div>
                      </div>
                   </div>
                   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                      <div class="department">
                         <div class="department-details">
                            <div class="round-style"></div>
                            <i class="icon flaticon-curtains"></i>
                            <h4 class="title">Decoration</h4>
                            <p class="details pt-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                               elit.
                               Repudiandae quia eligendi libero, laborum quaerat hic.
                            </p>
                         </div>
                      </div>
                   </div>
                   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                      <div class="department">
                         <div class="department-details">
                            <div class="round-style"></div>
                            <i class="icon flaticon-wedding-video"></i>
                            <h4 class="title">Photos & Videos</h4>
                            <p class="details pt-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                               elit.
                               Repudiandae quia eligendi libero, laborum quaerat hic.
                            </p>
                         </div>
                      </div>
                   </div>
                   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                      <div class="department">
                         <div class="department-details">
                            <div class="round-style"></div>
                            <i class="icon flaticon-balloons-3"></i>
                            <h4 class="title">Entertainmeint</h4>
                            <p class="details pt-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                               elit.
                               Repudiandae quia eligendi libero, laborum quaerat hic.
                            </p>
                         </div>
                      </div>
                   </div>
                   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                      <div class="department">
                         <div class="department-details">
                            <div class="round-style"></div>
                            <i class="icon flaticon-wedding-car"></i>
                            <h4 class="title">Car Support</h4>
                            <p class="details pt-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                               elit.
                               Repudiandae quia eligendi libero, laborum quaerat hic.
                            </p>
                         </div>
                      </div>
                   </div>
                   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                      <div class="department">
                         <div class="department-details">
                            <div class="round-style"></div>
                            <i class="icon flaticon-wedding-invitation-3"></i>
                            <h4 class="title">Invitation</h4>
                            <p class="details pt-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                               elit.
                               Repudiandae quia eligendi libero, laborum quaerat hic.
                            </p>
                         </div>
                      </div>
                   </div>
                   <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                      <div class="department">
                         <div class="department-details">
                            <div class="round-style"></div>
                            <img src="{{ asset('front/images/wedding.png') }}" alt="" class="bride">
                            <h4 class="title">Bridel</h4>
                            <p class="details pt-5">Lorem ipsum dolor sit amet, consectetur adipisicing
                               elit.
                               Repudiandae quia eligendi libero, laborum quaerat hic.
                            </p>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </section>
    @if(count($featuredItems)>0)
    <!--Featured Items Section-->
    <section class="team-section pt-0">
       <div class="auto-container">
          <div class="sec-title text-center">
             <h2 class="text-thm featured-title  pb-50">Featured Items</h2>
          </div>
          <div class="row clearfix">
             <!--Column-->
             @foreach($featuredItems as $product)
             <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
             <div class="col-md-3 col-sm-6 col-xs-12 column wow fadeInRight" data-wow-delay="1ms"
                data-wow-duration="1500ms">
                <article class="inner-box   p-xs-20">
                   <figure class="image">
                     <?php $getProductURL = Product::getProductURL($product['product_name']); ?>
                     <a href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">
                        @if(!empty($product['product_image']) && file_exists($product_image_path))
                           <img class="img-responsive" src="{{ asset($product_image_path) }}" alt="Product">
                        @else
                           <img class="img-responsive" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="Product">
                        @endif
                     </a>
                     </figure>
                      <div class="content">
                         <div class="title-box">
                            <h4>{{ $product['product_name'] }}</h4>
                         </div>
                         <div class="text">
                            <p><?php echo substr($product['description'],0,70); ?>...</p>
                         </div>
                         <div class="more-link"><a href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}" class="read-more"><span
                            class="fa fa-caret-right"></span> More Info </a></div>
                      </div>
                </article>
             </div>
             @endforeach
          </div>
       </div>
    </section>
    @endif
    @if(count($bestSellers)>0)
    <!--Best Sellers Section-->
    <section class="blog-section style-two">
       <div class="auto-container blog-sec  pt-40 pb-50">
          <div class="sec-title text-center">
             <h2 class="text-thm pb-50">Best Sellers</h2>
          </div>
          <div class="row">
             <!--Post-->
             @foreach($bestSellers as $product)
             <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
             <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 blog-post wow fadeInRight" data-wow-delay="600ms"
                data-wow-duration="1500ms">
                <article class="inner-box featured-posts p-xs-20">
                   <div class="image">
                     <?php $getProductURL = Product::getProductURL($product['product_name']); ?>
                     <a href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">
                        @if(!empty($product['product_image']) && file_exists($product_image_path))
                           <img class="img-responsive" src="{{ asset($product_image_path) }}" alt="Product">
                        @else
                           <img class="img-responsive" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="Product">
                        @endif
                     </a>
                  </div>
                   <div class="post-title text-center">
                      <h2><a href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">{{ $product['product_name'] }}</a></h2>
                   </div>
                   <div class="post-desc text-center">
                      <p><?php echo substr($product['description'],0,70); ?>...
                      </p>
                   </div>
                   <div class="more-link text-center"><a class="thm-btn btn-sm read-more text-black"
                      href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">READ MORE</a></div>
                </article>
             </div>
             @endforeach
          </div>
       </div>
    </section>
    @endif
    
    <!--Gallery Section-->
    <section class="gallery-section parallax pt-40">
       <div class="container">
          <div class="sec-title style-two">
             <h2 class="text-thm">Follow us on Instagram</h2>
          </div>
          <div class="sec-content mt-50">
             <div class="row clearfix">
                <!--Column-->
                <div class="col-md-3 col-sm-4 col-xs-12 column wow fadeIn" data-wow-delay="0ms"
                   data-wow-duration="1500ms">
                   <figure class="image mr-5">
                      <a href="#" class="lightbox-image"><img class="img-responsive" src="{{ asset('front/images/feature1.jpg') }}"
                         alt=""></a>
                      <div class="overlay-box"><a href="#" class="link lightbox-image"
                         title="Gallery Photos"><span class="txt font-30"><i
                         class="fa fa-camera"></i></span></a></div>
                   </figure>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12 column wow fadeIn" data-wow-delay="300ms"
                   data-wow-duration="1500ms">
                   <figure class="image mr-5">
                      <a href="#" class="lightbox-image"><img class="img-responsive" src="{{ asset('front/images/feature2.jpg') }}"
                         alt=""></a>
                      <div class="overlay-box"><a href="#" class="link lightbox-image"
                         title="Gallery Photos"><span class="txt font-30"><i
                         class="fa fa-camera"></i></span></a></div>
                   </figure>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12 column wow fadeIn" data-wow-delay="600ms"
                   data-wow-duration="1500ms">
                   <figure class="image mr-5">
                      <a href="#" class="lightbox-image"><img class="img-responsive" src="{{ asset('front/images/feature3.jpg') }}"
                         alt=""></a>
                      <div class="overlay-box"><a href="#" class="link lightbox-image"
                         title="Gallery Photos"><span class="txt font-30"><i
                         class="fa fa-camera"></i></span></a></div>
                   </figure>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12 column wow fadeIn" data-wow-delay="900ms"
                   data-wow-duration="1500ms">
                   <figure class="image">
                      <a href="#" class="lightbox-image"><img class="img-responsive" src="{{ asset('front/images/feature4.jpg') }}"
                         alt=""></a>
                      <div class="overlay-box"><a href="#" class="link lightbox-image"
                         title="Gallery Photos"><span class="txt font-30"><i
                         class="fa fa-camera"></i></span></a></div>
                   </figure>
                </div>
             </div>
          </div>
          <br><br>
          <div class="link-box"><a href="#" class="default-btn theme-btn">View Project</a></div>
       </div>
    </section>
    <!--Default Two Column Section-->
    <section class="default-two-column padd-bott-20">
       <div class="auto-container">
          <div class="row clearfix">
             <!--Column-->
             <!--Column-->
             <div class="col-md-12 col-sm-6 col-xs-12 column">
                <div class="inner-box">
                   <div class="sec-title style-three">
                      <h3 class="text-left">Our happy clients</h3>
                      <h2 class="text-left text-thm">Wedding Gifts Registry</h2>
                   </div>
                   <div class="clients-column">
                      <div class="clearfix">
                         <div class="col-md-2 col-sm-6 col-xs-6 image"><a href="#"><img
                            class="img-responsive" src="{{ asset('front/images/clients/logo-1.png') }}" alt=""></a></div>
                         <div class="col-md-2 col-sm-6 col-xs-6 image"><a href="#"><img
                            class="img-responsive" src="{{ asset('front/images/clients/logo-2.png') }}" alt=""></a></div>
                         <div class="col-md-2 col-sm-6 col-xs-6 image"><a href="#"><img
                            class="img-responsive" src="{{ asset('front/images/clients/logo-3.png') }}" alt=""></a></div>
                         <div class="col-md-2 col-sm-6 col-xs-6 image"><a href="#"><img
                            class="img-responsive" src="{{ asset('front/images/clients/logo-4.png') }}" alt=""></a></div>
                         <div class="col-md-2 col-sm-6 col-xs-6 image"><a href="#"><img
                            class="img-responsive" src="{{ asset('front/images/clients/logo-5.png') }}" alt=""></a></div>
                         <div class="col-md-2 col-sm-6 col-xs-6 image"><a href="#"><img
                            class="img-responsive" src="{{ asset('front/images/clients/logo-6.png') }}" alt=""></a></div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </section>
    <section class="blog-section style-two pt-40">
       <div class="auto-container pt-60 pb-30">
          <div class="sec-title text-center">
             <h3>VISIT OUR LATEST POST</h3>
             <h2 class="text-thm pb-50">DON'T MISS OUR BLOG</h2>
          </div>
          <div class="row">
             <!--Post-->
             <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 blog-post wow fadeInRight animated"
                data-wow-delay="600ms" data-wow-duration="1500ms"
                style="visibility: visible; animation-duration: 1500ms; animation-delay: 600ms; animation-name: fadeInRight;">
                <article class="inner-box p-xs-20">
                   <div class="image"><a href="blog-detail.html"><img class="img-responsive"
                      src="{{ asset('front/images/resource/blog-image-4.jpg') }}" alt=""></a></div>
                   <div class="post-title">
                      <h2><a href="blog-detail.html">Etiam accumsan purus magna, et viverra neque</a></h2>
                   </div>
                   <div class="post-info"><a href="#"><span class="fa fa-user"></span>John Doe</a>    <a
                      href="#"><span class="fa fa-clock-o"></span>June 8, 2015</a></div>
                   <div class="post-desc">
                      <p>Nullam ut mauris vitae tortor sodales efficitur. Quisque ac orci ante. Proin sit amet
                         turpis lobortis, imperdiet nisi ut, viverra lorem.
                      </p>
                   </div>
                   <div class="more-link"><a class="thm-btn btn-sm read-more text-black"
                      href="blog-detail.html">READ MORE</a></div>
                </article>
             </div>
             <!--Post-->
             <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 blog-post wow fadeInRight animated"
                data-wow-delay="300ms" data-wow-duration="1500ms"
                style="visibility: visible; animation-duration: 1500ms; animation-delay: 300ms; animation-name: fadeInRight;">
                <article class="inner-box p-xs-20">
                   <div class="image"><a href="blog-detail.html"><img class="img-responsive"
                      src="{{ asset('front/images/resource/blog-image-5.jpg') }}" alt=""></a></div>
                   <div class="post-title">
                      <h2><a href="blog-detail.html">Etiam accumsan purus magna, et viverra neque</a></h2>
                   </div>
                   <div class="post-info"><a href="#"><span class="fa fa-user"></span>John Doe</a>    <a
                      href="#"><span class="fa fa-clock-o"></span>June 8, 2015</a></div>
                   <div class="post-desc">
                      <p>Nullam ut mauris vitae tortor sodales efficitur. Quisque ac orci ante. Proin sit amet
                         turpis lobortis, imperdiet nisi ut, viverra lorem.
                      </p>
                   </div>
                   <div class="more-link"><a class="thm-btn btn-sm read-more text-black"
                      href="blog-detail.html">READ MORE</a></div>
                </article>
             </div>
             <!--Post-->
             <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 blog-post wow fadeInRight animated"
                data-wow-delay="0ms" data-wow-duration="1500ms"
                style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInRight;">
                <article class="inner-box p-xs-20">
                   <div class="image"><a href="blog-detail.html"><img class="img-responsive"
                      src="{{ asset('front/images/resource/blog-image-6.jpg') }}" alt=""></a></div>
                   <div class="post-title">
                      <h2><a href="blog-detail.html">Etiam accumsan purus magna, et viverra neque</a></h2>
                   </div>
                   <div class="post-info"><a href="#"><span class="fa fa-user"></span>John Doe</a>    <a
                      href="#"><span class="fa fa-clock-o"></span>June 8, 2015</a></div>
                   <div class="post-desc">
                      <p>Nullam ut mauris vitae tortor sodales efficitur. Quisque ac orci ante. Proin sit amet
                         turpis lobortis, imperdiet nisi ut, viverra lorem.
                      </p>
                   </div>
                   <div class="more-link"><a class="thm-btn btn-sm read-more text-black"
                      href="blog-detail.html">READ MORE</a></div>
                </article>
             </div>
             <!--Post-->
          </div>
       </div>
    </section>
</div>
@endsection