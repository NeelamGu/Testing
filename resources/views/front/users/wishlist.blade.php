<?php 
use App\Models\Product; 
use App\Models\Category;
?>
@extends('front.layout.layout')
@section('content')
<div class="">
   <!--End Main Header -->
   <!-- Static Banner Parallax Background-->
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         <!-- <div class="carousel-inner bg-none" role="listbox">
            <img src="images/venue.png" alt="">
            </div> -->
         <div class="page-title">
            <div class="auto-container">
               <ul class="bread-crumb">
                  <li><a href="{{ url('/')}}">Min side</a></li>
                  <li><a href="#">Wishlist</a></li>
               </ul>
            </div>
            <!--Go Down Button-->
         </div>
      </div>
   </section>
   <div class="auto-container wishlist-page">
      <div class="price-tb-title">
         <h2 class="text-thm wishlist-p-title ">Mine favoritter</h2>
         <div class="row">
            @if(count($wishlists) >0)
            @foreach($wishlists as $wishlist)
            <?php // echo "<pre>"; print_r($wishlist); die; ?>
            <!-- loop starts here -->
            <div class="col-lg-3 col-sm-6">
               <div class="wlist-area">
                  <div class="event-item">
                     <div class="event-thumb">
                        @php $getProductURL = Product::productURL($wishlist['product']['product_name']) @endphp
                        <?php $product_image_path = 'front/images/product_images/small/'.$wishlist['product']['product_image']; ?>
                        @if(!empty($wishlist['product']['product_image']) && file_exists($product_image_path))
                        <a href="{{ url('product/'.$getProductURL.'/'.$wishlist['product']['id']) }}"><img
                              class="img-responsive img-fullwidth"
                              src="{{ asset('front/images/product_images/large/'.$wishlist['product']['product_image']) }}"></a>
                        @else
                        <a href="{{ url('product/'.$getProductURL.'/'.$wishlist['product']['id']) }}"><img
                              class="img-responsive img-fullwidth"
                              src="{{ asset('front/images/product_images/small/no-image.png') }}"></a>
                        @endif
                        <a onclick="return confirm('Are you sure?')"
                           href="{{url('user/remove-wishlist/'.$wishlist['id'])}}">
                           <button name="submitbtn" type="button" value="REMOVE" class="wishlist-icon">
                              <i class="fa fa-trash" aria-hidden="true"></i>
                           </button>
                        </a>
                     </div>
                     <div class="event-details">
                        <div class="wishlist-page-title">
                           <a href="">
                              <h4 class="text-thm pb-5 font-weight-700">{{$wishlist['product']['product_name']}}</h4>
                           </a>
                        </div>
                        <!-- <div class="wl-price">
                              <p class="price">
                                 <span  class="wl-price-area"> 
                                 {{$wishlist['product']['product_price']}}
                                 </span>
                                 kr
                              </p>
                           </div> -->
                        <div class="price-area price-other">
                           @if(isset($wishlist['product']['price_range'])&&$wishlist['product']['price_range']!="")
                           @if($wishlist['product']['price_range']=="Low")
                           <div class="price-d-area">
                              <span class="price-dark">$</span>
                              <span>$$</span>
                           </div>
                           @elseif($wishlist['product']['price_range']=="Medium")
                           <div class="price-d-area">
                              <span class="price-dark">$$</span>
                              <span>$</span>
                           </div>
                           @elseif($wishlist['product']['price_range']=="High")
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
                        <!-- <div class="text-left pt-1">
                              <a href="{{ url('product/'.$getProductURL.'/'.$wishlist['product']['id']) }}">
                              <button name="submitbtn" type="button" class="wlist-btn" value="ADD TO CART">View Details</button></a>
                           </div> -->
                        <address class="text-dark font-14 mb-10 detail-adress">
                           <i class="fa fa-map-marker text-thm"></i><span class="pl-5">{{ ucfirst(strtolower($wishlist['product']['city'])) }}&nbsp;&nbsp;</span>
                           <?php $getCategoryImage = Category::getCategoryImage($wishlist['product']['category_id']); ?>
                           <div class="p-detail-category">
                              @if($getCategoryImage!="")
                                 <img class="category-img-icon" src="{{ asset('front/images/category_images/'.$getCategoryImage) }}">
                              @else
                                 <img class="category-img-icon" src="{{ asset('front/images/icons/curtains.png') }}">
                              @endif  
                              @php $getCategoryName = Category::getCategoryName($wishlist['product']['category_id']) @endphp 
                              <span>{{$getCategoryName}}</span>
                           </div>
                        </address>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
            @endif
         </div>
      </div>
   </div>
   <!--Main Footer-->
</div>
@endsection