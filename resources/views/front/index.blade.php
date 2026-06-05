<?php 
   use App\Models\Product;
   use App\Models\Section;
   use App\Models\Category;
   $sections = Section::sections();
   ?>
@extends('front.layout.layout')
@section('content')
<style>
   .get-quote
   {
   width:100%;
   max-width:475px;
   width: 100%;
   position: fixed;
   max-width: 475px;
   bottom: 15px;
   right: 30px;
   padding: 24px;
   z-index: 999;
   border:1px solid #d5d5d5;
   }
   .form-detail-area .get-quote form button
   {
   padding: 8px 30px;
   }
   .form-detail-area
   {
   position:relative;
   }  
   .form-detail-area .get-quote  .close-e-form
   {
   position: absolute;
   top: 17px;
   right: 20px;
   font-size: 30px;
   color: #000;
   cursor:pointer;
   }
   .get-quote .form
   {
   margin-bottom:0;
   }
   .enquery-form-button 
   {
   background: #E78002;
   border-radius: 0;
   color: #fff;
   display: inline-block;
   font-size: 22px !important;
   line-height: 32px;
   font-weight: 500;
   text-align: center;
   padding: 5px;
   text-decoration: none;
   font-size: 16px;
   text-transform: uppercase;
   width: 232px;
   text-align: center;
   z-index: 1;
   position: absolute;
   left: 0;
   top: auto;
   bottom: 18px;
   right: 0;
   margin: 0 auto;
   }
   a.enquery-form-button:hover
   {
   color:#fff !important;
   }
   .enquery-form-button:focus
   {
   box-shadow:none;
   border:none;
   color:#fff;
   }
   .get-quote
   {
   display:none;
   }
   .main-banner
   {
   position:relative;
   }
   @media only screen and (max-width: 768px) {
   .get-quote form textarea
   {
   height:80px;
   }
   .get-quote
   {
   right:0;
   max-width:320px;
   }
   .get-quote form input[type="text"]
   {
   height:35px;
   }
   }
</style>
<div class="page-wrapper home-wrapper">
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
    <!-- <section>
      <div class="owl-carousel video-slider owl-theme">
         <div class="item">
            <video src="{{ asset('front/videos/video.mp4') }}" muted="" autoplay="true" preload="auto" loop="" height="630px" width="100%" id="VideoHomePage1" class="videoHome" data-videoheighter="true" style="object-fit: cover; object-position: center;">
               <source type="video/mp4" src="{{ asset('front/videos/video.mp4') }}">
            </video>
         </div>
      </div>
      </section>
      <br><br><br> -->
   <section class="home-banner">
      <img class="desktop-banner" src="{{ asset('front/videos/video.png') }}">
      <img class="mobile-banner" src="{{ asset('front/videos/videoMob.png') }}">
      <!-- <video src="{{ asset('front/videos/video.mp4') }}" muted="" autoplay="true" preload="auto" loop="" height="630px" width="100%" id="VideoHomePage1" class="videoHome" data-videoheighter="true" style="object-fit: cover; object-position: center;">
               <source type="video/mp4" src="{{ asset('front/videos/video.mp4') }}">
            </video> -->
      <div class="auto-container">
         <div class="banner-text">
            <h1>Trenger du noe  <br> til ditt neste arrangement?</h1>
            <p>Beskriv dine ønsker og få leverandører fra hele landet til å kontakte deg.<br> Helt gratis og uforpliktende!</p>
            @if(!isset(Auth::guard('admin')->user()->type))<a class="banner-enquery-btn" href="{{ url('/enquire-us')}}">Legg ut oppdrag</a>@endif
         </div>
      </div>
   </section>
   <!--Get Quote Section-->
   <div class="form-detail-area">
      <div class="get-quote">
         <!--Column-->
         <div class="sec-title style-three">
            <h2 class="text-thm">ER DU INTERESSERT</h2>
         </div>
         <div class="form">
            @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
               <strong> </strong> {{ Session::get('error_message')}}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            @endif
            @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade in" role="alert">
               <strong>Success: </strong> {{ Session::get('success_message')}}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            @endif
            <form method="post" action="{{ url('user/submit-enquiry')}}" enctype="multipart/form-data">
               @csrf
               <div class="row clearfix">
                  <div class="form-group" style="padding: 0px 15px; margin-bottom: 28px;">
                     <select name="category_id" id="category_id" class="form-control text-dark" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $section)
                        <!-- <optgroup label="{{ $section['name'] }}"></optgroup> -->
                        @foreach($section['categories'] as $category)
                        <option value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;--&nbsp;{{ $category['category_name'] }}</option>
                        @foreach($category['subcategories'] as $subcategory)
                        <option value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;{{ $subcategory['category_name'] }}</option>
                        @endforeach
                        @endforeach
                        <option value="0">Other</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-md-6 col-sm-6  form-group">
                     <input type="text" name="fname" value="" placeholder="First Name *" required>
                  </div>
                  <div class="col-md-6 col-sm-6  col-6 form-group">
                     <input type="text" name="lname" value="" placeholder="Last Name *" required>
                  </div>
                  <div class="col-md-6 col-sm-6  col-6 form-group">
                     <input type="text" name="address" value="" placeholder="Address *" required>
                  </div>
                  <div class="col-md-6 col-sm-6  col-6 form-group">
                     <input type="text" name="city" value="" placeholder="City *" required>
                  </div>
                  <div class="col-md-6 col-sm-6  col-6 form-group">
                     <select name="radius">
                        <option value="">Select Radius</option>
                        <option value="0-5 Km">0-5 Km</option>
                        <option value="5-10 Km">5-10 Km</option>
                        <option value="10-15 Km">10-15 Km</option>
                        <option value="15-20 Km">15-20 Km</option>
                        <option value="20-25 Km">20-25 Km</option>
                        <option value="25-30 Km">25-30 Km</option>
                        <option value="30-35 Km">30-35 Km</option>
                        <option value="35+ Km">35+ Km</option>
                     </select>
                  </div>
                  <div class="col-md-6 col-sm-6 col-6 form-group">
                     Photo<input style="margin-bottom: 0px;" type="file" name="photo" value="" placeholder="Photo *" required><br>
                  </div>
                  <div class="col-md-6 col-sm-6 col-6 form-group">
                     <input type="email" name="email" value="" placeholder="Email *" required>
                  </div>
                  <div class="col-md-6 col-sm-6 col-6 form-group">
                     <input type="text" name="phone" value="" placeholder="Phone *" required>
                  </div>
                  <div class="col-md-12 col-sm-12  col-6 form-group">
                     <textarea name="message" style="height:55px;" placeholder="Describe Your Needs to Us" required></textarea>
                  </div>
                  <div class="col-md-6 col-md-offset-3 mb-0  col-sm-12  form-group text-center">
                     <button type="submit" class="theme-btn normal-btn">SUBMIT</button>
                  </div>
               </div>
            </form>
         </div>
         <span class="close-e-form" aria-hidden="true">×</span>
      </div>
   </div>
   <!--Start Our Department Areas-->
   <section class="pop-category-sec">
      <div class="container-fluid popular-cat pb-25 pt-20">
         <div class="sec-title text-center">
         </div>
         <div class="sec-content popular-cat-mar  popular-cat-sec">
            <div class="auto-container">
               <div class="row">
                  @foreach($popularCategories as $cat)
                  <a href="{{$cat['url']}}">
                     <div class="col categories-col">
                        <div class="department">
                           <div class="department-details">
                              <div class="round-style"></div>
                              <div class="img-border-area">
                              <img src="{{ asset('front/images/category_images/'.$cat['category_image']) }}">
                              </div>
                              <h4 class="title">{{$cat['category_name']}}</h4>
                              <p class="details pt-5">{{$cat['description']}}
                              </p>
                           </div>
                        </div>
                     </div>
                  </a>
                  @endforeach

              <!--  <a href="">
                     <div class="col categories-col">
                        <div class="department">
                           <div class="department-details">
                              <div class="round-style"></div>
                              <div class="img-border-area">
                              <img class="reuse-icon-img" src="{{ asset('front/images/icons/reuse-icon.png') }}">
                           </div>
                              <h4 class="title">Reuse</h4>
                           </div>
                        </div>
                     </div>
                  </a>  -->

               </div>
            </div>
         </div>
      </div>
   </section>
   <!--  how Samling works Section start here -->
   <section class="howitswork home-top-border">
      <div class="container">
         <div class="sec-title style-two">
            <h2 class="text-thm">Slik <span class="small-title">fungerer</span> Samling </h2>
         </div>
         <div class="row">
            <div class="col-sm-4">
               <div class="how-work-section">
                  <img src="{{ asset('front/images/icons/describe-icon.png') }}" alt="Image-2">
                  <h4>1. Beskriv hva du trenger</h4>
                  <p>
                     Fortell oss hva du trenger, og vi sender ut oppdraget til relevante leverandører.
                  </p>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="how-work-section">
                  <img src="{{ asset('front/images/icons/chat.png') }}" alt="Image-2">
                  <h4>2. Motta tilbud</h4>
                  <p>
                     Du vil snart motta uforpliktende tilbud fra leverandører som er klare til å hjelpe deg.
                  </p>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="how-work-section last-section">
                  <img src="{{ asset('front/images/icons/cake.png') }}" alt="Image-2">
                  <h4>3. Fullfør avtale</h4>
                  <p>
                     Sammenlign tilbudene og velg den riktige leverandøren for deg. Når tjenesten er mottatt, kan du legge inn en vurdering!
                  </p>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- end here -->
   <!-- Sponsored vendors section start here -->
   <div class="sponsored-section-bg">
   <section class="Sponsored-vendors    home-sec-border s-slider-area sponsored-s-border pt-40">
      <div class="auto-container">
         <div class="sec-title style-two">
            <h2 class="text-thm Sponsored-title">Sponsede <span class="small-title">leverandører</span></h2>
         </div>
         <div class="owl-carousel sponsored-slider owl-theme" id="sponsored-slider">
            @foreach($featuredItems as $item)
            @php $getCategoryName = Category::getCategoryName($item['category_id']) @endphp
            @php $getProductURL = Product::productURL($item['product_name']) @endphp
            <div class="item">
               <a href="{{ url('product/'.$getProductURL.'/'.$item['id']) }}">
               <?php $product_image_path = 'front/images/product_images/large/'.$item['product_image']; ?>
               @if(!empty($item['product_image']) && file_exists($product_image_path))
               <img src="{{ asset('front/images/product_images/large/'.$item['product_image']) }}">
               @else
               <img src="{{ asset('front/images/product_images/large/no-image.png') }}">
               @endif
            </a>
               <div class="event-details detail-t-data ">
                  <div class="">
                     <a href="{{ url('product/'.$getProductURL.'/'.$item['id']) }}">
                        <h4 class="text-thm pb-5 font-weight-700 notranslate" translate="no">{{$item['product_name']}}</h4>
                     </a>
                  </div>
                  <div class="price-area price-other">
                                 @if(isset($item['price_range'])&&$item['price_range']!="")
                                 @if($item['price_range']=="Low")
                                 <div class="price-d-area">
                                    <span class="price-dark">$</span>
                                    <span>$$</span>
                                 </div>
                                 @elseif($item['price_range']=="Medium")
                                 <div class="price-d-area">
                                    <span class="price-dark">$$</span>
                                    <span>$</span>
                                 </div>
                                 @elseif($item['price_range']=="High")
                                 <div class="price-d-area">
                                    <span class="price-dark">$$$</span>
                                 </div>
                                 @endif 
                                 @else
                                 <div class="price-d-area">
                                    <span>$$$</span>
                                 </div>
                                 @endif
                              </div>
                  <address class="text-dark font-14  mb-0 detail-adress">
                     <i class="fa fa-map-marker text-thm"></i>
                     <span class="pl-5 notranslate" translate="no"> <?php /* @if($item['address']!=""){{$item['address']}},@endif */ ?> 
                     <!-- {{$item['city']}} -->

                     {{ ucfirst(strtolower($item['city'])) }}&nbsp;&nbsp;</span>
                     <?php $getCategoryImage = Category::getMainCategoryImage($item['category_id']); ?>
                     <div class="p-detail-category">
                        @if($getCategoryImage!="")
                           <img class="category-img-icon" src="{{ asset('front/images/category_images/'.$getCategoryImage) }}">
                        @else
                           <img class="category-img-icon" src="{{ asset('front/images/icons/curtains.png') }}">
                        @endif
                        <span>{{$getCategoryName}}</span>
                     </div>
                  </address>
                  
                  <!-- <div class="">
                     <p class="price">
                        <span class="price-title"> 
                        {{$item['product_price']}}
                        </span>
                        kr
                     </p>
                  </div> -->
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </section>
</div>
   <!-- end here -->
   <!-- Popular suppliers section start here -->
   <section class="Sponsored-vendors  home-top-border   s-slider-area  pt-40">
      <div class="auto-container">
         <div class="sec-title style-two">
            <h2 class="text-thm">Populære <span class="small-title">leverandører</span></h2>
         </div>
         <div class="owl-carousel sponsored-slider owl-theme" id="sponsored-slider">
            @foreach($popularItems as $item)
            @php $getCategoryName = Category::getCategoryName($item['category_id']) @endphp
            @php $getProductURL = Product::productURL($item['product_name']) @endphp
            <div class="item">
               <a href="{{ url('product/'.$getProductURL.'/'.$item['id']) }}">
               <?php $product_image_path = 'front/images/product_images/large/'.$item['product_image']; ?>
               @if(!empty($item['product_image']) && file_exists($product_image_path))
               <img src="{{ asset('front/images/product_images/large/'.$item['product_image']) }}">
               @else
               <img src="{{ asset('front/images/product_images/large/no-image.png') }}">
               @endif
            </a>
               <div class="event-details detail-t-data ">
                  <div class="">
                     <a href="{{ url('product/'.$getProductURL.'/'.$item['id']) }}">
                        <h4 class="text-thm pb-5 font-weight-700 notranslate" translate="no">{{$item['product_name']}}</h4>
                     </a>
                  </div>
                  <div class="price-area price-other">
                                 @if(isset($item['price_range'])&&$item['price_range']!="")
                                 @if($item['price_range']=="Low")
                                 <div class="price-d-area">
                                    <span class="price-dark">$</span>
                                    <span>$$</span>
                                 </div>
                                 @elseif($item['price_range']=="Medium")
                                 <div class="price-d-area">
                                    <span class="price-dark">$$</span>
                                    <span>$</span>
                                 </div>
                                 @elseif($item['price_range']=="High")
                                 <div class="price-d-area">
                                    <span class="price-dark">$$$</span>
                                 </div>
                                 @endif 
                                 @else
                                 <div class="price-d-area">
                                    <span>$$$</span>
                                 </div>
                                 @endif
                              </div>
                  <address class="text-dark font-14 mb-0 detail-adress">
                     <i class="fa fa-map-marker text-thm"></i><span class="pl-5 notranslate" translate="no"> <?php /* @if($item['address']!=""){{$item['address']}},@endif */ ?> {{ ucfirst(strtolower($item['city'])) }}&nbsp;&nbsp;</span>
                     <?php $getCategoryImage = Category::getMainCategoryImage($item['category_id']); ?>
                     <div class="p-detail-category">
                        @if($getCategoryImage!="")
                           <img class="category-img-icon" src="{{ asset('front/images/category_images/'.$getCategoryImage) }}">
                        @else
                           <img class="category-img-icon" src="{{ asset('front/images/icons/curtains.png') }}">
                        @endif
                        <span>{{$getCategoryName}}</span>
                     </div>
                  </address>
                  
                  <!-- <div class="">
                     <p class="price">
                        <span class="price-title"> 
                        {{$item['product_price']}}
                        </span>
                        kr
                     </p>
                  </div> -->
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </section>
   <!-- end here -->
   <!-- Latest suppliers section start here -->
   <section class="Sponsored-vendors sponsored-s-border  s-slider-area new-post-vender  pt-40">
      <div class="auto-container">
         <div class="sec-title style-two">
            <h2 class="text-thm">Nyeste <span class="small-title">leverandører</span> </h2>
         </div>
         <div class="owl-carousel sponsored-slider owl-theme" id="sponsored-slider">
            @foreach($newItems as $item)
            @php $getCategoryName = Category::getCategoryName($item['category_id']) @endphp
            @php $getProductURL = Product::productURL($item['product_name']) @endphp
            <div class="item">
               <a href="{{ url('product/'.$getProductURL.'/'.$item['id']) }}">
               <?php $product_image_path = 'front/images/product_images/large/'.$item['product_image']; ?>
               @if(!empty($item['product_image']) && file_exists($product_image_path))
               <img src="{{ asset('front/images/product_images/large/'.$item['product_image']) }}">
               @else
               <img src="{{ asset('front/images/product_images/large/no-image.png') }}">
               @endif
            </a>
               <div class="event-details detail-t-data ">
                  <div class="">
                     <a href="{{ url('product/'.$getProductURL.'/'.$item['id']) }}">
                        <h4 class="text-thm pb-5 font-weight-700 notranslate" translate="no">{{$item['product_name']}}</h4>
                     </a>
                  </div>
                  <div class="price-area price-other">
                                 @if(isset($item['price_range'])&&$item['price_range']!="")
                                 @if($item['price_range']=="Low")
                                 <div class="price-d-area">
                                    <span class="price-dark">$</span>
                                    <span>$$</span>
                                 </div>
                                 @elseif($item['price_range']=="Medium")
                                 <div class="price-d-area">
                                    <span class="price-dark">$$</span>
                                    <span>$</span>
                                 </div>
                                 @elseif($item['price_range']=="High")
                                 <div class="price-d-area">
                                    <span class="price-dark">$$$</span>
                                 </div>
                                 @endif 
                                 @else
                                 <div class="price-d-area">
                                    <span>$$$</span>
                                 </div>
                                 @endif
                              </div>
                  <address class="text-dark font-14 mb-0 detail-adress">
                     <i class="fa fa-map-marker text-thm"></i><span class="pl-5 notranslate" translate="no"> <?php /* @if($item['address']!=""){{$item['address']}},@endif */ ?> {{ ucfirst(strtolower($item['city'])) }}&nbsp;&nbsp;</span>
                     <?php $getCategoryImage = Category::getMainCategoryImage($item['category_id']); ?>
                     <div class="p-detail-category">
                        @if($getCategoryImage!="")
                           <img class="category-img-icon" src="{{ asset('front/images/category_images/'.$getCategoryImage) }}">
                        @else
                           <img class="category-img-icon" src="{{ asset('front/images/icons/curtains.png') }}">
                        @endif
                        <span>{{$getCategoryName}}</span>
                     </div>
                  </address>

                  
                  <!-- <div class="">
                     <p class="price">
                        <span class="price-title"> 
                        {{$item['product_price']}}
                        </span>
                        kr
                     </p>
                  </div> -->
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </section>
   <!-- end here -->
   <!-- About Collection section start here -->
   <!--  <section class="Sponsored-vendors  pt-40">
      <div class="auto-container">
         <div class="sec-title style-two">
            <h2 class="text-thm">Om Samling </h2>
         </div>
         <div class="owl-carousel about-collection owl-theme">
            <div class="item">
               <img src="{{ asset('front/images/popular-suppliers/1.jpg') }}">
               <div class="event-details detail-t-data ">
                  <div class="">
                     <a href="">
                        <h4 class="text-thm pb-5 font-weight-700">RG event planner</h4>
                     </a>
                  </div>
                  <address class="text-dark font-14 mb-10">
                     <i class="fa fa-map-marker text-thm"></i><span class="pl-5"> ldh, Norge&nbsp;&nbsp;</span>
                     <i class="fa fa-bank text-thm"></i><span class="pl-5"> Underholdning</span>
                  </address>
                  <div class="" style="display: flex; justify-content:center;">
                     <p class="price">
                        <span class="price-title"
                        > 
                        450
                        </span>
                        kr
                     </p>
                  </div>
               </div>
            </div>
            <div class="item">
               <img src="{{ asset('front/images/popular-suppliers/2.jpg') }}">
               <div class="event-details detail-t-data ">
                  <div class="">
                     <a href="">
                        <h4 class="text-thm pb-5 font-weight-700">Drammen Photo</h4>
                     </a>
                  </div>
                  <address class="text-dark font-14 mb-10">
                     <i class="fa fa-map-marker text-thm"></i><span class="pl-5"> ldh, Norge&nbsp;&nbsp;</span>
                     <i class="fa fa-bank text-thm"></i><span class="pl-5"> Underholdning</span>
                  </address>
                  <div class="" style="display: flex; justify-content:center;">
                     <p class="price">
                        <span class="price-title"> 
                        450
                        </span>
                        kr
                     </p>
                  </div>
               </div>
            </div>
            <div class="item">
               <img src="{{ asset('front/images/popular-suppliers/3.jpg') }}">
               <div class="event-details detail-t-data ">
                  <div class="">
                     <a href="">
                        <h4 class="text-thm pb-5 font-weight-700">Decor Norway</h4>
                     </a>
                  </div>
                  <address class="text-dark font-14 mb-10">
                     <i class="fa fa-map-marker text-thm"></i><span class="pl-5"> ldh, Norge&nbsp;&nbsp;</span>
                     <i class="fa fa-bank text-thm"></i><span class="pl-5"> Underholdning</span>
                  </address>
                  <div class="" style="display: flex; justify-content:center;">
                     <p class="price">
                        <span class="price-title"> 
                        450
                        </span>
                        kr
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </section> -->
   <!-- end here -->
   <!--About page section start here -->
   <section class="about-us home-top-border home-sec-border">
      <div class="container">
         <div class="sec-title style-two">
            <h2 class="text-thm about-title">Om Samling</h2>
            <div class="welcome-grids">
               <div class="col-md-5 wel-grid1">
                  <div class="port-7 effect-2">
                     <div class="image-box">
                        <img src="{{ asset('front/images/ab.jpg') }}" alt="Image-2">
                     </div>
                  </div>
               </div>
               
               <div class="col-md-7 wel-grid text-left">
                  <p class="about-title-area"><b>GJØR DET UFORGLEMMELIG</b></p>
                  <p>
                     Velkommen til Samling, din fremste destinasjon for alle dine behov innen arrangementstjenester. Med en lidenskap for å skape uforglemmelige opplevelser, er vi dedikert til å hjelpe deg med å omskape din visjon til virkelighet.
                  </p>
                  <P>
                     Vi skal være førstevalget og en “one-stop-shop” for ethvert arrangement. Enten du planlegger en bedriftskonferanse, et bryllup, en bursdagsfest eller en annen spesiell begivenhet, har vi deg dekket.
                  </P>
                  <a target="_blank" href="{{ url('/about') }}" class="readmore-text">Les mer</a>
                 <!--  <div class="content">
                     <p>
                        Alt fra kaker til konfetti, fra blomster til ballonger, finner du her. Om du er en brud som ser etter din drømmekjole, en far som ønsker å overraske din datter med hennes favoritt bursdagskake eller om du skal holde en minnestund for en nær, vil vi være en del av din begivenhet. 
                        Vi tilbyr deg et bredt spekter av tjenester for å hjelpe deg med å skape en sømløs og uforglemmelig begivenhet.
                        Planlegg din store dag med oss. Start med å beskrive dine behov i oppdragsskjemaet, motta deretter flere tilbud fra dyktige, lokale leverandører, sammenlign tilbudene og finn den rette leverandøren som passer din stil og budsjett. Slik sparer du både tid og penger. Det er gratis og uforpliktende.
                        Ved å velge lokale tilbydere, vil du få helt unike produkter og samtidig bidra til et mer bærekraftig samfunn ved å redusere behov for langtransport.
                        Du kan også finne den rette leverandøren ved å søke i ønsket kategorifelt. Eller finn inspirasjon og skap et "moodboard" ved å samle alle dine favoritter på ett sted.
                     </p>
                     <p class="supplier-text"><b>For leverandører: </b></p>
                     <p>
                        Samling vil løfte frem lokale bedrifter i hele landet.  Vi ønsker å samle alt fra hobbybakeren som ikke har egen nettside til det store veletablerte selskapslokalet, under ett tak.
                     </p>
                     <p>
                        Leverer du tjenester eller produkter som kan brukes ved samlinger? Ønsker du mer synlighet og flere potensielle kunder uten å bruke en formue på markedsføring? Vår anbudstjeneste videreSendr kun relevante kunder som trenger hjelp/varer i ditt dekningsområde.Høres interessant ut? <a class="about-p-link" href="{{ url('/vendor/register') }}">Registrer deg som leverandør her.</a>
                     </p>
                  </div> -->
               </div
                  >
            </div>
         </div>
      </div>
   </section>
   <!-- end here -->
   <!-- Testimonal Start here -->
   <!-- TESTIMONIALS -->
   <!-- <section class="testimonials">
      <div class="container">
         <div class="row">
            <div class="col-sm-12">
               <div id="customers-testimonials" class="owl-carousel">
                  <div class="item">
                     <div class="shadow-effect">
                        <div class="row">
                           <div class="col-sm-12 border-right slider-btm-details">
                              <p class="big-title">Samling is an exceptional events company in Norway! Their attention to detail, creativity, and professionalism made our event a huge success. Thank you for your outstanding service and for creating unforgettable memories. Highly recommended!<br>
                                 <span>- Emma</span>
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="item">
                     <div class="shadow-effect">
                        <div class="row">
                           <div class="col-sm-12 border-right slider-btm-details">
                              <p class="big-title">Samling made our event in Norway absolutely unforgettable! Their attention to detail, impeccable organization, and friendly staff exceeded our expectations. Thank you for creating such a memorable experience!<br>
                                 <span>- Emma</span>
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="item">
                     <div class="shadow-effect">
                        <div class="row">
                           <div class="col-sm-12 border-right slider-btm-details">
                              <p class="big-title">Samling's events are truly exceptional! The attention to detail, friendly staff, and incredible atmosphere made my experience unforgettable. Thank you for creating such memorable moments. Highly recommend!<br>
                                 <span>- Emily</span>
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section> -->
   <!-- END OF TESTIMONIALS -->
   <!-- end here -->
   <!-- Sign up section start here -->
   <section class="sign-up-sec text-center">
      <div class="">
         <div class="auto-container">
            <div class="row ">
               <div class="col-sm-12">
                  <h2>Er du en leverandør?</h2>
                  <p>Bli med flere andre leverandører og få mer eksponering av bedriften din.<br> Meld deg på og få flere kunder allerede i dag.</p>
                  <a class="signup-btn" href="{{ url('/vendor/register')}}">Bli leverandør</a>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- end here -->
   <!--Instagram Section-->
   <!-- <section class="gallery-section home-top-border Instagram-section parallax">
      <div class="container">
         <div class="sec-title style-two">
            <h2 class="text-thm">Følg oss på Instagram</h2>
         </div>
         <div class="sec-content mt-50">
            <div class="row clearfix">
               <div class="col-md-2 col-sm-2 col-xs-12 column wow fadeIn" data-wow-delay="0ms"
                  data-wow-duration="1500ms">
                  <figure class="image mr-5">
                     <a href="#" class="lightbox-image">
                     <img class="img-responsive" src="{{ asset('front/images/feature1.jpg') }}"
                        alt=""></a>
                     <div class="overlay-box"><a href="#" class="link lightbox-image"
                        title="Gallery Photos"><span class="txt font-30"><i
                        class="fa fa-camera"></i></span></a></div>
                  </figure>
               </div>
               <div class="col-md-2 col-sm-2 col-xs-12 column wow fadeIn" data-wow-delay="300ms"
                  data-wow-duration="1500ms">
                  <figure class="image mr-5">
                     <a href="#" class="lightbox-image"><img class="img-responsive" src="{{ asset('front/images/feature2.jpg') }}"
                        alt=""></a>
                     <div class="overlay-box"><a href="#" class="link lightbox-image"
                        title="Gallery Photos"><span class="txt font-30"><i
                        class="fa fa-camera"></i></span></a></div>
                  </figure>
               </div>
               <div class="col-md-2 col-sm-2 col-xs-12 column wow fadeIn" data-wow-delay="600ms"
                  data-wow-duration="1500ms">
                  <figure class="image mr-5">
                     <a href="#" class="lightbox-image"><img class="img-responsive" src="{{ asset('front/images/feature3.jpg') }}"
                        alt=""></a>
                     <div class="overlay-box"><a href="#" class="link lightbox-image"
                        title="Gallery Photos"><span class="txt font-30"><i
                        class="fa fa-camera"></i></span></a></div>
                  </figure>
               </div>
               <div class="col-md-2 col-sm-2 col-xs-12 column wow fadeIn" data-wow-delay="900ms"
                  data-wow-duration="1500ms">
                  <figure class="image">
                     <a href="#" class="lightbox-image"><img class="img-responsive" src="{{ asset('front/images/feature4.jpg') }}"
                        alt=""></a>
                     <div class="overlay-box"><a href="#" class="link lightbox-image"
                        title="Gallery Photos"><span class="txt font-30"><i
                        class="fa fa-camera"></i></span></a></div>
                  </figure>
               </div>
               <div class="col-md-2 col-sm-2 col-xs-12 column wow fadeIn" data-wow-delay="900ms"
                  data-wow-duration="1500ms">
                  <figure class="image">
                     <a href="#" class="lightbox-image"><img class="img-responsive" src="{{ asset('front/images/feature5.jpg') }}"
                        alt=""></a>
                     <div class="overlay-box"><a href="#" class="link lightbox-image"
                        title="Gallery Photos"><span class="txt font-30"><i
                        class="fa fa-camera"></i></span></a></div>
                  </figure>
               </div>
               <div class="col-md-2 col-sm-2 col-xs-12 column wow fadeIn" data-wow-delay="900ms"
                  data-wow-duration="1500ms">
                  <figure class="image">
                     <a href="#" class="lightbox-image"><img class="img-responsive" src="{{ asset('front/images/feature6.jpg') }}"
                        alt=""></a>
                     <div class="overlay-box"><a href="#" class="link lightbox-image"
                        title="Gallery Photos"><span class="txt font-30"><i
                        class="fa fa-camera"></i></span></a></div>
                  </figure>
               </div>
            </div>
         </div>
      </div>
   </section> -->

   <!-- <section class="home-contact">
      <div class="container">
         <div class="row">
            <div class="col-sm-6">
               <div class="sec-title style-two">
            <h2 class="text-thm contact-title-home">Lurer <span class="small-title">Du På Noe?</span></h2>
         </div>
               <p>
                 Fyll ut skjemaet for å komme i kontakt med oss. Vi ser frem til å besvare dine spørsmål.
               </p>
            </div>
            <div class="col-sm-6">
               <div class="home-contact-form">
                @if(isset($_GET['s']))
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong>Your details has been submitted successfully. We will get back to you soon.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                     </div>
                  @endif
                  @if(isset($_GET['e']))
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! </strong>  Please enter valid details
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                     </div>
                  @endif
                <form id="SaveContact" method="post" action="javascript:;">@csrf
                     <div class="row clearfix">
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Navn *</div>
                           <input type="text" id="name" name="name"  required>
                           <p class="err text-center" id="Contact-name" style="display: none;"></p>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">E-post *</div>
                           <input type="email" name="email"  title="Please enter valid email" required>
                           <p class="err text-center" id="Contact-email" style="display: none;"></p>
                        </div>
                        <div class="form-group phone-contact-col col-md-3 col-sm-3 col-xs-12">
                           <div class="field-label">Telefonnummer *</div>
                           <select name="country" class="enquire_country" required>
                              <option value="">Select</option>
                              @foreach($countries as $country)
                              <option value="{{ $country }}" @if($country=="NORWAY") selected @endif>{{ $country }}</option>
                              @endforeach
                           </select>
                           <p class="err text-center" id="Contact-country" style="display: none;"></p>
                        </div>
                        <div class="form-group contact-mob-area col-md-9 col-sm-9 col-xs-12">
                           <div class="field-label"></div>
                           <input class="load-c-code homecontact-code load_countrycode" type="text" name="countrycode" value="+47" readonly>
                           <input class="t-number-area" type="text" id="mobile" name="mobile"  required>
                           <p class="err text-center" id="Contact-mobile" style="display: none;"></p>
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           <div class="field-label">Emne *</div>
                           <input type="text" name="subject"  required>
                           <p class="err text-center" id="Contact-mobile" style="display: none;"></p>
                        </div>

                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           <div class="field-label">Beskjed *</div>
                           <textarea name="message" id="description"  required></textarea>
                           <p class="err text-center" id="Contact-message" style="display: none;"></p>
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12 text-right">
                           <button class="normal-btn theme-btn" type="submit" name="submit-form">Send</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section> -->

   
@if(!isset(Auth::guard('admin')->user()->type))
<div class="enquery-form" id="enqueryForm">
   <a class="enquery-btn-area"  href="{{ url('enquire-us') }}">Legg ut oppdrag</a>
</div>
@endif
@endsection