@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
   <!--End Main Header -->
   <!-- Static Banner Parallax Background-->
   <section class="main-slider default-banner">
      <!--Carousel-->
      <div id="default-slider" class="carousel" data-ride="carousel" data-interval="7000" data-pause="false"
         data-wrap="true">
         <div class="carousel-inner bg-none" role="listbox">
            <img src="images/venue.png" alt="">
         </div>
         <div class="page-title">
            <div class="auto-container">
               <ul class="bread-crumb">
                  <li><a href="{{ url('/')}}">Min side</a></li>
                  <li><a href="#">Kontakt</a></li>
               </ul>
            </div>
            <!--Go Down Button-->
         </div>
      </div>
   </section>
   <div class="contact-section inquiry-form" id="contact-section">
      <div class="auto-container">
         <div class="row clearfix">
            <!--Content Side-->
            <div class="col-md-12 col-sm-12 col-xs-12 column pull-left">
               <div class="sec-title inquiry-title">
                  <h3 class="font-20 text-black">Ditt oppdrag er registrert og sendt til alle aktuelle leverandører.</h3>
                  <h3 class="font-20 text-black">Vil du legge ut flere oppdrag ?</h3>
               </div>
               <div class="">
                     <div class="row clearfix">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12 text-left">
                           @if(isset($_GET['assignment_date'])&&isset($_GET['address']))
                              <a href="{{ url('enquire-us?assignment_date='.$_GET['assignment_date'].'&address='.$_GET['address']) }}" class="normal-btn theme-btn enquiry-btn" style="border-radius: 50px;">Legg ut flere oppdrag</a>
                           @else
                              <a href="{{ url('enquire-us') }}" class="normal-btn theme-btn enquiry-btn" style="border-radius: 50px;">Legg ut flere oppdrag</a>
                           @endif
                        </div>
                     </div>
                  
               </div>
            </div>
            <!--Left Side-->
         </div>
      </div>
   </div>
   <!--Main Footer-->
</div>
@endsection