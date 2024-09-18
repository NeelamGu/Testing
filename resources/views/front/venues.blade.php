@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
   <!-- Static Banner Parallax Background-->
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         <div class="carousel-inner bg-none" role="listbox">
            <img src="{{ asset('front/images/venue.png') }}" alt="">
         </div>
         <div class="page-title">
            <div class="auto-container">
               <ul class="bread-crumb">
                  <li><a href="{{ url('/')}}">Home</a></li>
                  <li><a href="{{ url('/listing')}}">Venues</a></li>
               </ul>
            </div>
            <!--Go Down Button-->
         </div>
      </div>
   </section>
   <section class="venue-sec">
      <div class="auto-container">
         <div class="row clearfix">
            <!--Column-->
            <div class="col-md-12 col-sm-12 col-xs-12 ">
               <h4 class="title text-black font-weight-700">Banquet Halls</h4>
               <p class="details pt-5 text-black">Showing 21550 results as per your search criteria.</p>
            </div>
         </div>
      </div>
   </section>
   <section class="">
      <div class="auto-container pb-35">
         <div class="sec-content">
            <div class="row">
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/product1.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <div class="" style="display: flex; justify-content:space-between;">
                           <a href="{{ url('/detail')}}">
                              <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                           </a>
                        </div>
                        <address class="text-dark font-14 mb-10">
                           <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                           <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                           Farmhouses</span>
                        </address>
                        <div class="" style="display: flex; justify-content:;">
                           <p class="price">
                              <!-- <i class="fa fa-inr margin-r-5"></i> -->
                              <span style="font-size:20px; color: #000;"> 1,200 kr</span>
                           </p>
                        </div>
                        <!-- <div class="" style="display: flex; justify-content:;">
                           <p class="box">100-700 pax</p>
                           <p class="box ml-20">Indoor</p>
                           <p class="box ml-20">+4More</p>
                        </div> -->
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/product2.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <div class="" style="display: flex; justify-content:space-between;">
                           <a href="{{ url('/detail')}}">
                              <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                           </a>
                        </div>
                        <address class="text-dark font-14 mb-10">
                           <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                           <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                           Farmhouses</span>
                        </address>
                        <div class="" style="display: flex; justify-content:;">
                           <p class="price">
                              <!-- <i class="fa fa-inr margin-r-5"></i> -->
                              <span style="font-size:20px; color: #000;"> 1,200 kr</span>
                           </p>
                           <!-- <p class="pl-30">Non Veg <span
                              style="display: block; font-size: 20px; color: #000;">KR 2299</span></p> -->
                        </div>
                        <!-- <div class="" style="display: flex; justify-content:;">
                           <p class="box">100-700 pax</p>
                           <p class="box ml-20">Indoor</p>
                           <p class="box ml-20">+4More</p>
                        </div> -->
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/product3.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <div class="" style="display: flex; justify-content:space-between;">
                           <a href="{{ url('/detail')}}">
                              <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                           </a>
                        </div>
                        <address class="text-dark font-14 mb-10">
                           <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                           <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                           Farmhouses</span>
                        </address>
                        <div class="" style="display: flex; justify-content:;">
                           <p class="price">
                              <!-- <i class="fa fa-inr margin-r-5"></i> -->
                              <span style="font-size:20px; color: #000;"> 1,200 kr</span>
                           </p>
                        </div>
                        <!-- <div class="" style="display: flex; justify-content:;">
                           <p class="box">100-700 pax</p>
                           <p class="box ml-20">Indoor</p>
                           <p class="box ml-20">+4More</p>
                        </div> -->
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/product4.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <div class="" style="display: flex; justify-content:space-between;">
                           <a href="{{ url('/detail')}}">
                              <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                           </a>
                        </div>
                        <address class="text-dark font-14 mb-10">
                           <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                           <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                           Farmhouses</span>
                        </address>
                        <div class="" style="display: flex; justify-content:;">
                           <p class="price">
                              <i class="fa fa-inr margin-r-5"></i>
                              <span style="font-size:20px; color: #000;"> 1,200</span>
                           </p>
                        </div>
                        <!-- <div class="" style="display: flex; justify-content:;">
                           <p class="box">100-700 pax</p>
                           <p class="box ml-20">Indoor</p>
                           <p class="box ml-20">+4More</p>
                        </div> -->
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/product5.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <div class="" style="display: flex; justify-content:space-between;">
                           <a href="{{ url('/detail')}}">
                              <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                           </a>
                        </div>
                        <address class="text-dark font-14 mb-10">
                           <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                           <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                           Farmhouses</span>
                        </address>
                        <div class="" style="display: flex; justify-content:;">
                          <p class="price">
                              <i class="fa fa-inr margin-r-5"></i>
                              <span style="font-size:20px; color: #000;"> 1,200</span>
                           </p>
                        </div>
                        <!-- <div class="" style="display: flex; justify-content:;">
                           <p class="box">100-700 pax</p>
                           <p class="box ml-20">Indoor</p>
                           <p class="box ml-20">+4More</p>
                        </div> -->
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/product6.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <div class="" style="display: flex; justify-content:space-between;">
                           <a href="{{ url('/detail')}}">
                              <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                           </a>
                        </div>
                        <address class="text-dark font-14 mb-10">
                           <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                           <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                           Farmhouses</span>
                        </address>
                        <div class="" style="display: flex; justify-content:;">
                           <p class="price">
                              <i class="fa fa-inr margin-r-5"></i>
                              <span style="font-size:20px; color: #000;"> 1,200</span>
                           </p>
                        </div>
                        <!-- <div class="" style="display: flex; justify-content:;">
                           <p class="box">100-700 pax</p>
                           <p class="box ml-20">Indoor</p>
                           <p class="box ml-20">+4More</p>
                        </div> -->
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/product7.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <div class="" style="display: flex; justify-content:space-between;">
                           <a href="{{ url('/detail')}}">
                              <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                           </a>
                        </div>
                        <address class="text-dark font-14 mb-10">
                           <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                           <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                           Farmhouses</span>
                        </address>
                        <div class="" style="display: flex; justify-content:;">
                           <p class="price">
                              <i class="fa fa-inr margin-r-5"></i>
                              <span style="font-size:20px; color: #000;"> 1,200</span>
                           </p>
                        </div>
                       <!--  <div class="" style="display: flex; justify-content:;">
                           <p class="box">100-700 pax</p>
                           <p class="box ml-20">Indoor</p>
                           <p class="box ml-20">+4More</p>
                        </div> -->
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/product8.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <div class="" style="display: flex; justify-content:space-between;">
                           <a href="{{ url('/detail')}}">
                              <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                           </a>
                        </div>
                        <address class="text-dark font-14 mb-10">
                           <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                           <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                           Farmhouses</span>
                        </address>
                        <div class="" style="display: flex; justify-content:;">
                           <p class="price">
                              <i class="fa fa-inr margin-r-5"></i>
                              <span style="font-size:20px; color: #000;"> 1,200</span>
                           </p>
                        </div>
                        <!-- <div class="" style="display: flex; justify-content:;">
                           <p class="box">100-700 pax</p>
                           <p class="box ml-20">Indoor</p>
                           <p class="box ml-20">+4More</p>
                        </div> -->
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                  <div class="event-item">
                     <div class="event-thumb">
                        <img class="img-responsive img-fullwidth" src="{{ asset('front/images/product9.jpg') }}" alt="">
                     </div>
                     <div class="event-details bg-white p-20">
                        <div class="" style="display: flex; justify-content:space-between;">
                           <a href="{{ url('/detail')}}">
                              <h4 class="text-thm pb-5 font-weight-700">Hyatt Regency, Norway</h4>
                           </a>
                        </div>
                        <address class="text-dark font-14 mb-10">
                           <i class="fa fa-map-marker text-thm"></i><span class="pl-5">worli,norway…</span>
                           <i class="fa fa-bank text-thm"></i><span class="pl-5">Banquet Halls, Lawns /
                           Farmhouses</span>
                        </address>
                        <div class="" style="display: flex; justify-content:;">
                           <p class="price">
                              <i class="fa fa-inr margin-r-5"></i>
                              <span style="font-size:20px; color: #000;"> 1,200</span>
                           </p>
                        </div>
                       <!--  <div class="" style="display: flex; justify-content:;">
                           <p class="box">100-700 pax</p>
                           <p class="box ml-20">Indoor</p>
                           <p class="box ml-20">+4More</p>
                        </div> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="auto-container text-center">
         <nav aria-label="Page navigation example">
            <ul class="pagination">
               <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                  </a>
               </li>
               <li class="page-item"><a class="page-link" href="#">1</a></li>
               <li class="page-item"><a class="page-link" href="#">2</a></li>
               <li class="page-item"><a class="page-link" href="#">3</a></li>
               <li class="page-item"><a class="page-link" href="#">4</a></li>
               <li class="page-item"><a class="page-link" href="#">5</a></li>
               <li class="page-item">
                  <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  </a>
               </li>
            </ul>
         </nav>
      </div>
   </section>
</div>
@endsection