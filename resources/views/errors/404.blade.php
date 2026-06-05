@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div class="page-title">
            <div class="auto-container">
               <ul class="bread-crumb">
                  <li><a href="\">Home</a></li>
                  <li><a href="javascript:void(0)">404 Page</a></li>
               </ul>
               </div>
               </div>
               <div>
                  <div class="" role="">
                     <h4 class="mt-4 mb-4">Sorry, the page you were looking for doesn't exist.</h4>
                     <img src="{{ asset('front/images/404_image_New.png') }}" alt="">
                     </div>
        
      </div>
   </section>
   <!-- <section class="">
      <div class="container p-0">
         <div class="col-12 text-center pt-5 pb-5">
            <img style="width:300px; margin-top:20px;" src="{{ asset('front/images/404image.png') }}" class="centered__404 mb-3" />
            <h4 class="mt-4 mb-4">Sorry, the page you were looking for doesn't exist.</h4>
		</div>
      </div>
   </section> -->
</div>

@endsection
