<?php 
   use App\Models\Product; 
   use App\Models\Wishlist;
   use App\Models\Vendor;
   use App\Models\Category;
   ?>
@extends('front.layout.layout')
@section('content')
<style>
   .detail-enquire-form input,
   .detail-enquire-form textarea {
      border: 1px solid #e4e5e6;
      padding: 10px;
      width: 100%;
   }

   .enquire-form-title {
      font-size: 25px;
      text-transform: uppercase;
      text-align: center;
      color: #E78002;
      margin-top: 0px;
      margin-bottom: 10px;
   }

   .detail-enquire-form {
      background-color: #fff;
      padding: 20px;
      margin-top: 30px;
   }

   .detail-enquire-form {
      position: relative;
   }

   .detail-enquire-form .close-e-form {
      position: absolute;
      top: 8px;
      right: 20px;
      font-size: 30px;
      color: #000;
      cursor: pointer;
   }
</style>
<div class="enquire-form">
   <!--Enquire Form Modal  Start Here-->
   <div class="modal fade" id="enquire-form" tabindex="-1" role="dialog" aria-labelledby="enquire-form"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="enquire-form-title">SEND MELDING</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Lukk">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form method="post" action="index.html">
                  <div class="row clearfix">
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <input type="text" name="name" value="" placeholder="Navn *" required="">
                     </div>
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <input type="email" name="email" value="" placeholder="E-post *" required="">
                     </div>
                     <div class="col-md-6 col-sm-6 col-xs-12  form-group">
                        <input type="text" name="phone" value="" placeholder="Telefon *" required="">
                     </div>
                     <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <input type="text" name="subject" value="" placeholder="Emne *" required="">
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <textarea placeholder="Forespørsel *" required=""></textarea>
                     </div>
                     <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 form-group text-center">
                        <button type="submit" class="theme-btn normal-btn">Sende inn</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!--Enquire Form Modal End Here-->
</div>

<div class="page-wrapper">
   <section class="main-slider default-banner">
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         @if(!empty($productDetails['product_banner']) &&
         file_exists('front/images/product_banners/'.$productDetails['product_banner']))
         <div class="carousel-inner bg-none" role="listbox">
            <img class="detail-bg-banner"
               src="{{ asset('front/images/product_banners/'.$productDetails['product_banner']) }}" alt="">
         </div>
         @else
         <div class="carousel-inner bg-none" role="listbox">
            <img class="detail-bg-banner" src="{{ asset('front/images/detail-bg.jpg') }}" alt="">
         </div>
         @endif
         <!-- <div class="page-title">
            <div class="auto-container">
               <ul class="bread-crumb">
                  <li><a href="\">Hjem</a></li>
                  <li><a href="{{ url($categoryDetails['categoryDetails']['url']) }}">{{ $categoryDetails['categoryDetails']['name'] }}</a></li>
                  <li><a href="javascript:void(0)">{{ $productDetails['product_name'] }}</a></li>
               </ul>
            </div>
            </div> -->
      </div>
   </section>
   <section class="detail-bg">
      <div class="detail-top-area home-top-border">
         <div class="container p-0">
            @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible" style="margin-top: 30px; margin-bottom: -10px;">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong>Suksess!</strong> {{ Session::get('success_message')}}
            </div>
            @endif
            @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible" style="margin-top: 30px; margin-bottom: -10px;">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong>Feil!</strong> {{ Session::get('error_message')}}
            </div>
            @endif
            @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible" style="margin-top: 30px; margin-bottom: -10px;">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong>Feil!</strong> {!!$error!!}
            </div>
            @endforeach
            <!--Section Title-->
            <div class="product-details-page-content">
               <div class="detail-page-section">
                  <div class="row">
                     <div class="col-sm-7">
                        <div class="image-detail-area">
                           <div class="d-image">
                              @if(!empty($productDetails['product_image']) &&
                              file_exists('front/images/product_images/large/'.$productDetails['product_image']))
                              <img class="img-responsive"
                                 src="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}">
                              @else
                              <img class="img-responsive img-fullwidth" style="width: 300px;"
                                 src="{{ asset('front/images/no-image.jpg') }}">
                              @endif
                           </div>
                           @if($productDetails['vendor_id']>0)
                           @php $getVendorDetails = Vendor::getVendorDetails($productDetails['vendor_id']); @endphp
                           @if($getVendorDetails['plan_id']>1)
                           <div class="detail-social-links">
                              <ul>
                                 @if($getVendorDetails['facebook']!="")
                                 <li><a target="_blank" href="{{ $getVendorDetails['facebook'] }}"><span
                                          class="fa fa-facebook-f"></span></a></li>
                                 @endif
                                 @if($getVendorDetails['instagram']!="")
                                 <li><a target="_blank" href="{{ $getVendorDetails['instagram'] }}"><span
                                          class="fa fa-instagram"></span></a></li>
                                 @endif
                                 @if($getVendorDetails['tiktok']!="")
                                 <li>
                                    <a target="_blank" href="{{ $getVendorDetails['tiktok'] }}">
                                       <img class="tiktok-icon" src="{{ asset('front/images/icons/tiktok-icon.png') }}">
                                    </a>
                                 </li>
                                 @endif
                                 @if($getVendorDetails['youtube']!="")
                                 <li><a target="_blank" href="{{ $getVendorDetails['youtube'] }}"><span
                                          class="fa fa-youtube-play"></span></a></li>
                                 @endif
                                 @if($getVendorDetails['website']!="")
                                 <li><a target="_blank" href="{{ $getVendorDetails['website'] }}"><span
                                          class="fa fa-globe"></span></a></li>
                                 @endif
                              </ul>
                           </div>
                           @endif
                           @endif
                           <div class="share-detail-items">
                              <ul>
                                 <li>
                                    <a class="gallery-area" href="#gallery">
                                       <i class="fa fa-picture-o"
                                          aria-hidden="true"></i><span>{{count($productDetails['images'])}}
                                          Bilder</span>
                                    </a>
                                 </li>
                                 <li class="shortlist-icon">
                                    <?php $checkwish =0; ?>
                                    @if(Auth::check())
                                    <?php $checkwish = Wishlist::checkwishlist($productDetails['id']); ?>
                                    @endif
                                    @if($checkwish > 0)
                                    <a href="javascript:void(0);" data-productid="{{$productDetails['id']}}"
                                       class="wishlist addWishList"><span><i class="fa fa-heart fill-heart"
                                             aria-hidden="true"></i></span></a>
                                    @else
                                    <a href="javascript:void(0);" data-productid="{{$productDetails['id']}}"
                                       class="wishlist addWishList"><span><i class="fa fa-heart-o"
                                             aria-hidden="true"></i></span></a>
                                    @endif
                                    <span>Favoritt</span>
                                 </li>
                                 @if(!isset(Auth::guard('admin')->user()->type))
                                 <!-- <li>
                                    <a class="write-review-area" href="#review-section"><i class="fa fa-pencil-square-o"
                                          aria-hidden="true"></i> Gi en vurdering </a>
                                 </li> -->
                                 @endif
                                 <li class="share-icon">
                                    <!-- <i class="fa fa-share" aria-hidden="true"></i> --> <!-- ShareThis BEGIN -->
                                    <div class="sharethis-inline-share-buttons"></div>
                                    <!-- ShareThis END -->
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-5">
                        <div class="detail-text-area">
                           <div class="detail-area">
                              <h1 class="text-thm pb-5 font-weight-700">{{ $productDetails['product_name'] }}</h1>
                              <div class="review-detail">
                                 <!-- <div class="review-star">
                                    <span class="review-rating">
                                       <i class="fa fa-star"></i>{{ $avgRating }}
                                    </span>
                                    <span class="rating-view">{{$ratingCount}} vurderinger</span>
                                 </div> -->
                              </div>
                              <div class="price-area">
                                 @if(isset($productDetails['price_range'])&&$productDetails['price_range']!="")
                                 @if($productDetails['price_range']=="Low")
                                 <div class="price-d-area">
                                    <span class="price-dark">$</span>
                                    <span>$$</span>
                                 </div>
                                 @elseif($productDetails['price_range']=="Medium")
                                 <div class="price-d-area">
                                    <span class="price-dark">$$</span>
                                    <span>$</span>
                                 </div>
                                 @elseif($productDetails['price_range']=="High")
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
                           </div>
                           <div class="detail-location-area">
                              <div class="p-location">
                                 <i class="fa fa-map-marker font-18 mt-5"></i><span
                                    class="pl-5 mt-0"><!-- {{ $productDetails['city'] }} -->
                                    {{ ucfirst(strtolower($productDetails['city'])) }}</span>
                              </div>
                           </div>
                           <?php /* @if(!isset(Auth::guard('admin')->user()->type)) */ ?>
                           <div class="detail-mobile-area">
                              @if($productDetails['vendor_id']>0)
                              @if(Auth::check())
                              <a class="asknow-btn ask-detail-btn">SEND MELDING</a>
                              @else
                              <a class="asknow-btn" data-toggle="modal" data-target="#loginModal">
                                 <i class="fa fa-envelope-o" style="font-size:20px;margin-right:10px"></i> SEND
                                 MELDING</a>
                              @endif
                              @endif

                              @if($productDetails['vendor_id']>0)
                              @php
                              $getVendorDetails = Vendor::getVendorDetails($productDetails['vendor_id']);
                              @endphp
                              @if($getVendorDetails['plan_id']==4)
                              @if(Auth::check())
                              <div class="d-mobile-sec">
                                 <?php /* <i class="fa fa-phone font-18 mt-5"></i><span class="pl-5 mt-0">{{ substr($productDetails['vendor']['mobile'],0,4) }}******</span> */ ?>
                                 <i class="fa fa-phone font-18 mt-5"></i><span class="pl-5 mt-0"><a
                                       href="tel:{{ $productDetails['vendor']['mobile'] }}">{{
                                       $productDetails['vendor']['mobile'] }}</a></span>
                              </div>
                              @else
                              <a href="#" class="d-mobile-sec" data-toggle="modal" data-target="#loginModal">
                                 <i class="fa fa-phone font-18 mt-5"></i><span class="pl-5 mt-0">{{
                                    substr($productDetails['vendor']['mobile'],0,4) }}******</span>
                              </a>
                              @endif
                              @endif
                              @endif
                              <div class="locMarker">
                                 <h4 class="text-thm pb-5 font-weight-700">Leverer til:</h4>
                                 <h4 class="text-thm pb-5 font-weight-700"></h4>
                                 @if(isset($productDetails['all_norway'])&&$productDetails['all_norway']=="all")
                                 <span class="location"> <i class="fa fa-map-marker"></i>Hele Norge</span>
                                 @else
                                 @if(isset($productStates))
                                 @foreach($productStates as $state)
                                 <span class="location"> <i class="fa fa-map-marker"></i>{{$state}}</span>
                                 @endforeach
                                 @endif
                                 @if(isset($productCities))
                                 @foreach($productCities as $city)
                                 <span class="location"> <i class="fa fa-map-marker"></i>{{$city['city']}},
                                    {{$city['state']}}</span>
                                 @endforeach
                                 @endif
                                 @endif
                              </div>
                           </div>
                           <?php /* @endif */ ?>
                           <!-- <div class="d-price-div">
                              <p class="price">
                              <h4 class="text-black"></h4>
                              Pris 
                              <?php $getDiscountPrice = Product::getDiscountPrice($productDetails['id']); ?>
                              @if($getDiscountPrice>0)
                              <span style="font-size:20px;display:inline-block;color: #000; text-decoration: line-through;"> 
                              {{ $productDetails['product_price'] }}</span>
                              <span style="font-size:20px;display:inline-block;color: #000;"> 
                              {{ $getDiscountPrice }}</span> 
                              @if($productDetails['product_discount']>0)
                              <span style="font-size:15px;">&nbsp;({{ $productDetails['product_discount'] }}% Av)</span>
                              @endif
                              @else
                              <span style="font-size:20px;display:inline-block;color: #000;"> 
                              {{ $productDetails['product_price'] }}</span>
                              @endif
                              kr
                              </p>
                              </div> -->
                           <!-- <div class="link-area">
                              <img src="{{ asset('front/images/link.png') }}">
                              <a href="#">www.samling.com</a>
                              </div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="detail-profile-area">
               @if($productDetails['vendor_id']>0)
               <div class="detail-enquire-form">
                  <h5 class="enquire-form-title">SEND MELDING</h5>
                  <p id="enquiry-success"></p>
                  <form id="productEnquiryForm" method="post" action="javascript:void(0)">
                     <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                     <input type="hidden" name="vendor_id" value="{{ $productDetails['vendor_id'] }}">
                     <div class="row clearfix">
                        <!-- <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                           <input type="text" name="name" value="" placeholder="Name *" required="">
                           </div>
                           <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                           <input type="email" name="email" value="" placeholder="Email *" required="">
                           </div>
                           <div class="col-md-6 col-sm-6 col-xs-12  form-group">
                           <input type="text" name="phone" value="" placeholder="Phone *" required="">
                           </div>
                           <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                           <input type="text" name="subject" value="" placeholder="Subject *" required="">
                           </div> -->
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                           <textarea maxlength="300" rows="5" id="message" name="message" placeholder="Melding *"
                              required=""></textarea>
                        </div>
                        <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 form-group text-center">
                           <button type="submit" class="theme-btn normal-btn">SEND</button>
                        </div>
                     </div>
                  </form>
                  <span class="close-e-form">×</span>
               </div>
               @endif
            </div>
         </div>
      </div>
      <div class="detail-products home-top-border">
         <div class="auto-container detail-products-area">
            <div class="" id="" style="display: block; ">
               <div class="about-detail-area">
                  <h3 class="profile-title-area mb-0">Om {{ $productDetails['product_name'] }}</h3>
                  <ul class="badge-detail-area">
                     @if($productDetails['keywords']!="")
                     @php $keywords = explode(",",$productDetails['keywords']) @endphp

                     @foreach($keywords as $keyword)
                     <li><span class="badge">{{$keyword}}</span></li>
                     @endforeach
                     @endif
                  </ul>
                  <p class="d-detail-text" id="product-description">
                     <?php echo nl2br($productDetails['description']); ?>
                  </p>
                  <button id="read-more-btn" class="btn-read-more">Les mer</button>
               </div>
            </div>
         </div>
      </div>
      <div id="gallery" class="product-details-tab-title  home-top-border row7 gallery-section">
         <div class="auto-container">
            <div class="col-lg-12 m-10" style="display: block;">
               <div class="card gallery-tabs detail-tabs">
                  <div class="card-body g-video-tabs">
                     <h3 class="profile-title-area gallery-title">Galleri</h3>
                     <div class="tab-content mt-3">
                        <div class="tab-pane  active" id="galleryimg" role="tabpanel">
                           <!--  @foreach($productDetails['images'] as $image)
                              <div class="detail-images">
                                 <img src="{{ asset('front/images/product_images/small/'.$image['image']) }}" alt=""
                                    class="detail-img">
                                 <span>{{$image['title']}}</span>
                              </div>
                              @endforeach   -->
                           <div class="row">
                              <div class='list-group gallery six-images'>
                                 @foreach($productDetails['images'] as $key => $image)
                                 <div class="gslidebox">
                                    <a class="glightbox" data-gallery="gallery1"
                                       href="{{ asset('front/images/product_images/large/'.$image['image']) }}">
                                       <img class="img-responsive" alt=""
                                          src="{{ asset('front/images/product_images/large/'.$image['image']) }}" />
                                       <div class="text-left galleryimg-title">
                                          <small class="text-muted">{{ ucfirst(strtolower($image['title'])) }}</small>
                                       </div>
                                    </a>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      @if($productDetails['product_video'])
      <div class="video-section-area home-top-border">
         <div class="container">
            <div id="video-sec" class="v-section-area">
               <h3 class="profile-title-area video-gallery-title">Video</h3>
               <br>
               @if($productDetails['product_video'])
               <video width="100%" controls>
                  <source src="{{ url('front/videos/product_videos/'.$productDetails['product_video']) }}"
                     type="video/mp4">
               </video>
               @else
               Produktvideo finnes ikke
               @endif
            </div>
         </div>
      </div>
      @endif
      <div id="review-section" class="review-section">
         <div class="auto-container">
            @if(!isset(Auth::guard('admin')->user()->type))
            <div class="row">
               <div class="col-sm-12">
                  <div class="review-form-area">
                     <form method="POST" action="{{ url('/write-a-review') }}" name="frmReview" id="frmReview"
                        class="text-left comment-from review-form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="fHsqYOpaJh8bD7D5NBXuy5c92kAPClwlMRjijXeI">
                        <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                        <div class="star-rating rating-box" style="margin-left: -10px;">
                           <input type="radio" id="5-stars" name="rating" value="5">
                           <label style="font-size: 28px;" for="5-stars" class="star">★</label>
                           <input type="radio" id="4-stars" name="rating" value="4">
                           <label style="font-size: 28px;" for="4-stars" class="star">★</label>
                           <input type="radio" id="3-stars" name="rating" value="3">
                           <label style="font-size: 28px;" for="3-stars" class="star">★</label>
                           <input type="radio" id="2-stars" name="rating" value="2">
                           <label style="font-size: 28px;" for="2-stars" class="star">★</label>
                           <input type="radio" id="1-star" name="rating" value="1">
                           <label style="font-size: 28px;" for="1-star" class="star">★</label>
                        </div>
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="mb-3 mt-3">
                                 <label for="comment" class="text-left review-title">GJENNOMGÅ TITTEL *</label>
                                 <input type="text" class="form-control" rows="5" id="review_title" name="review_title"
                                    required="">
                              </div>
                           </div>
                           <div class="col-sm-12">
                              <div class="mb-3 mt-3">
                                 <label for="comment" class="text-left review-title">GJENNOMGANG BESKRIVELSE *</label>
                                 <textarea class="form-control" rows="5" id="review_description"
                                    name="review_description"></textarea>
                              </div>
                           </div>
                           <div class="col-sm-12">
                              <div class="mb-3 mt-3">
                                 <label for="image" class="text-left review-title">Upload File</label>
                                 <input type="file" name="image" id="fileToUpload">
                              </div>
                           </div>
                        </div>
                        <div class="text-center">
                           @if(Auth::check())
                           <button type="submit" class="btn buy-btn">SENDE</button>
                           @else
                           <a class="buy-now-btn buy-btn showLoginModal" data-toggle="modal"
                              data-target="#loginModal">SENDE INN</a>
                           @endif
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            @endif
            <!-- <div class="row">
               <div class="col-lg-4 col-md-5 col-12">
                  @php
                  $average = 4.3;
                  $total_reviews = 21;
                  $breakdown = [
                  5 => 17,
                  4 => 1,
                  3 => 3,
                  2 => 0,
                  1 => 1
                  ];
                  $last_updated = '1 Nov 2025';

                  $total = array_sum($breakdown);
                  @endphp

                  <div class="rating-summary">
                     <div class="rating-header">
                        <div class="rating-box">
                           <span class="star"><i class="fa fa-star" style="color: #fff;"></i></span>
                           <span class="rating-value">{{ number_format($average, 1) }}</span>
                        </div>
                        <div class="total-reviews">
                           {{ $total_reviews }} {{ Str::plural('review', $total_reviews) }}
                        </div>
                     </div>

                     <h4 class="rating-title">Rating Distribution</h4>

                     @foreach([5,4,3,2,1] as $star)
                     @php
                     $count = $breakdown[$star] ?? 0;
                     $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                     $barColor = match($star) {
                     5 => '#4caf50',
                     4 => '#8bc34a',
                     3 => '#cddc39',
                     2 => '#ffc107',
                     1 => '#f44336',
                     default => '#ddd'
                     };
                     @endphp

                     <div class="rating-bar">
                        <span>{{ $star }} ★</span>
                        <div class="bar">
                           <div class="fill" style="width: {{ $percentage }}%; background: {{ $barColor }}"></div>
                        </div>
                        <span>{{ $count }} {{ Str::plural('review', $count) }}</span>
                     </div>
                     @endforeach

                     <p class="last-update">Last Review Updated on {{ $last_updated }}</p>
                  </div>
               </div>

               <div class="col-lg-8 col-md-7 col-12">
                  @if(isset($reviews) && count($reviews) )
                  @foreach($reviews as $review)
                  <div class="c-review">

                     <div class="review-img">
                        <img class="review-image" src="{{ asset('front/images/profile.png') }}">
                        <div class="">
                           <h4>{{ $review['user']['name'] }}</h4>
                           <span class="review-s">{{ $review['star_rating'] }} <i class="fa fa-star"></i></span>
                        </div>
                        <p class="review-s date"> ({{ date("j. F Y", strtotime($review['created_at'])); }})</p>

                     </div>
                     <div class="review-col review-col-area">
                        <div class="review-detail">
                           <div class="text-left review">
                              <h4>{{ $review['review_title'] }} </h4>
                              <p>{{ $review['review_description'] }}</p>
                           </div>
                           <div class="uploadedImg">
                              @if (!empty($review['image']))
                              <a target="_blank" href="{{ url('front/images/reviews_images/'.$review['image']) }}">
                                 <img class="review-image"
                                    src="{{ url('front/images/reviews_images/'.$review['image']) }}">
                              </a>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  @else
               </div>
               <div class="col-sm-12 no-review-area text-center">
                  <div class="review-detail">
                     <div class="text-left review">
                        <h4>Ingen anmeldelser ennå </h4>
                     </div>
                  </div>
                  @endif
               </div>
            </div> -->
         </div>
      </div>
      <!-- <div class="container temp-container pb-0">
         <div class="row best-seller bseller-title">
            <div class="sec-title detail-sec-title style-three">
               <h2 class="text-left other-p-title">Bla gjennom lignende elementer</h2>
               <div class="line"></div>
            </div>
         </div>
         </div> -->
      <div id="scroll-form" class="bottomMenu hide">
         @if(!isset(Auth::guard('admin')->user()->type))
         <div class="">
            <div class="enquery-form">
               <a href="{{ url('enquire-us') }}">Legg ut oppdrag</a>
            </div>
         </div>
         @endif
      </div>
      <div class="detail-other-product home-top-border">
         <div class="container temp-container  detail-o-product relate-prodduct">
            <div class="row">
               <div class="sec-title detail-sec-title style-three">
                  <h3 class="font-24 text-black mb-20 mt-30">Lignenede annonser</h3>
               </div>
               <!-- <div class="sec-title detail-sec-title style-three">
                  <div class="line mt-0 mb-5"></div>
               </div> -->
               <div class="owl-carousel Sponsored-vendors other-p-products similar-slider owl-theme">
                  @foreach($similarProducts as $product)
                  <div class="item">
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="event-item">
                           <div class="event-thumb">
                              <?php $getProductURL = Product::productURL($product['product_name']); ?>
                              <a href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">
                                 <?php $product_image_path = 'front/images/product_images/large/'.$product['product_image']; ?>
                                 @if(!empty($product['product_image']) && file_exists($product_image_path))
                                 <img class="img-responsive img-fullwidth" src="{{ asset($product_image_path) }}"
                                    alt="Product">
                                 @else
                                 <img class="img-responsive img-fullwidth"
                                    src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="Product">
                                 @endif
                              </a>
                           </div>
                           <div class="event-details p-14">
                              <div class="" style="display: flex; justify-content:space-between;">
                                 <h4 class="text-thm pb-5 font-weight-700">
                                    <a class="p-url-link"
                                       href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">{{
                                       $product['product_name'] }}</a>
                                 </h4>
                                 <!-- <p class=""><i class="fa fa-star"></i>4.0</p> -->
                              </div>
                              <div class="price-area price-other">
                                 @if(isset($product['price_range'])&&$product['price_range']!="")
                                 @if($product['price_range']=="Low")
                                 <div class="price-d-area">
                                    <span class="price-dark">$</span>
                                    <span>$$</span>
                                 </div>
                                 @elseif($product['price_range']=="Medium")
                                 <div class="price-d-area">
                                    <span class="price-dark">$$</span>
                                    <span>$</span>
                                 </div>
                                 @elseif($product['price_range']=="High")
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
                              <address class="text-dark font-14 mb-10 detail-adress">
                                 <i class="fa fa-map-marker text-thm"></i><span class="pl-5">{{
                                    ucfirst(strtolower($product['city'])) }}, Norge&nbsp;&nbsp;</span>
                                 <!-- <span class="hall-area">
                                 <i class="fa fa-list text-thm" aria-hidden="true"></i><span class="pl-5">{{ $categoryDetails['categoryDetails']['name'] }}</span>
                                 </span> -->
                                 <?php $getCategoryImage = Category::getCategoryImage($product['category_id']); ?>
                                 <div class="p-detail-category">
                                    @if($getCategoryImage!="")
                                    <img class="category-img-icon"
                                       src="{{ asset('front/images/category_images/'.$getCategoryImage) }}">
                                    @else
                                    <img class="category-img-icon" src="{{ asset('front/images/icons/curtains.png') }}">
                                    @endif
                                    @php $getCategoryName = Category::getCategoryName($product['category_id']) @endphp
                                    <span>{{$getCategoryName}}</span>
                                 </div>
                              </address>
                              <!-- <div class="d-price-area" style="display: flex; justify-content:;">
                                 <p class="price">
                                    <span style="font-size:20px; color: #000;"> {{ $product['product_price'] }} kr</span>
                                 </p>
                              </div> -->
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
</div>
</section>
</div>
@stop
@section('javascript')
@parent
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script>
   $(document).ready(function () {
      $(".fancybox").fancybox({
         openEffect: "none",
         closeEffect: "none",
         loop: true,
         helpers: {
            title: {
               type: 'inside'
            },
            overlay: {
               css: {
                  'background': 'rgba(0, 0, 0, 1)'
               }
            },
            buttons: {}
         }
      });
   });
</script>
<script>
   <?php if (Auth:: check()) { ?>
      $(".detail-enquire-form").show();
   <?php } ?>
      /*  $(".close-e-form").click(function(){
      $(".detail-enquire-form").hide();
      });*/

      $(".detail-eform").click(function () {
         $(".detail-enquire-form").toggle();
      });

   //  $(document).ready(function(){
   //  //FANCYBOX
   //  //https://github.com/fancyapps/fancyBox
   //  $(".fancybox").fancybox({
   //      openEffect: "none",
   //      closeEffect: "none"
   //  });
   // });


   $(".write-review-area").click(function () {
      $(".review-form-area").show();
   });



</script>
@stop