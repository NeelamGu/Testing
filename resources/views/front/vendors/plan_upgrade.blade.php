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
                  <li><a href="#">Plans</a></li>
               </ul>
            </div>
            <!--Go Down Button-->
         </div>
      </div>
   </section>
   <div class="all-plans">
      <div class="auto-container">
         <div class="price-tb-title">
            <h2 class="text-thm pricing-title">Velg abonnement</h2>
            <div class="row">
               @foreach($plans as $plan)
               <div class="col-sm-3 plans-sec">
                  <div class="plans-section">
                      @if(!empty($plan['image']))
                        <img src="{{ asset('front/images/plan_images/'.$plan['image']) }}">
                       @else
                        <img src="{{ asset('front/images/product_images/small/no-image.png') }}">
                       @endif
                     <div class="plans-text-area">
                        <p class="pack-name">{{ $plan['name'] }}</p>
                        <h4 class="plans-price">{{ $plan['price'] }}kr</h4>
                        <p class="pack-text">{{ $plan['short_description'] }}</p>
                        @if($plan['id']!=$currentPlan['plan_id'])
                        <form method="post" action="{{ url('admin/vendor/upgrade-plan') }}">@csrf
                           <input type="hidden" name="plan_id" value="{{ $plan['id'] }}">
                           <input type="hidden" name="code" value="{{ $code }}">
                           <button type="submit" class="plans-info-btn">Bestill</button>
                        </form>
                        @else
                           <button type="button" class="plans-info-btn" style="background-color:#b8b9ba;">Mitt abonnement</button>
                        @endif
                        <div class="pack-details">
                           <?php echo $plan['features']; ?>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
   <!--Main Footer-->
</div>
@endsection