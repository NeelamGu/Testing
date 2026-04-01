<?php 
use App\Models\Product; 
use App\Models\Category;
?>
@foreach($categoryProducts as $product)
<div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
   <div class="event-item">
      <div class="event-thumb">
         <?php $getProductURL = Product::productURL($product['product_name']); ?>
         <a href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">
            <?php $product_image_path = 'front/images/product_images/large/'.$product['product_image']; ?>
            @if(!empty($product['product_image']) && file_exists($product_image_path))
               <img class="img-responsive img-fullwidth" src="{{ asset($product_image_path) }}">
              @else
               <img class="img-responsive img-fullwidth" src="{{ asset('front/images/product_images/large/no-image.png') }}">
              @endif
          </a>
      </div>
      <div class="event-details p-20">
         <div class="product-heading">
            <a href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">
               <h4 class="text-thm pb-5 font-weight-700 notranslate" translate="no">{{ $product['product_name'] }}
               </h4>
            </a>
         </div>
         <div class="price-area price-other listing-price">
            @if(isset($product['price_range'])&&$product['price_range']!="")
            @if($product['price_range']=="Low")
            <div class="price-d-area price-other">
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
            <i class="fa fa-map-marker text-thm"></i><span class="pl-5 notranslate" translate="no">{{ ucfirst(strtolower($product['city'])) }}&nbsp;&nbsp;</span>
             <?php $getCategoryImage = Category::getMainCategoryImage($product['category_id']); ?>
                     <div class="p-detail-category">
                        @if($getCategoryImage!="")
                           <img class="category-img-icon" src="{{ asset('front/images/category_images/'.$getCategoryImage) }}">
                        @else
                           <img class="category-img-icon" src="{{ asset('front/images/icons/curtains.png') }}">
                        @endif
                        @php $getCategoryName = Category::getCategoryName($product['category_id']) @endphp
                        <span>{{$getCategoryName}}</span>
                     </div>
         </address>
          
        <!--  <div class="" style="display: flex; justify-content:;">
            <p class="price">
              
               <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
               @if($getDiscountPrice>0)
                  <span style="font-size:20px; color: #000; text-decoration: line-through;">{{ $product['product_price'] }}</span>
                  <span style="font-size:20px; color: #000;"> 
                  {{ $getDiscountPrice }}
                  </span>
               @else
                  <span style="font-size:20px; color: #000;"> 
                  {{ $product['product_price'] }}
                  </span>
               @endif
               kr
            </p>
         </div> -->
         <!-- <div class="" style="display: flex; justify-content:;">
            <p class="box">100-700 pax</p>
            <p class="box ml-20">Indoor</p>
            <p class="box ml-20">+4More</p>
         </div> -->
      </div>
   </div>
</div>
@endforeach