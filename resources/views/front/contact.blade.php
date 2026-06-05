@extends('front.layout.layout')
@section('content')
<div class="page-wrapper contact-wrapper">
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
   <div class="contact-section contact-page-area" id="contact-section">
      <div class="auto-container">
         <div class="row clearfix">
            <!--Content Side-->
            <div class="col-md-8 col-sm-7 col-xs-12 column pull-left">
               <div class="sec-title">
                  <h1 class="font-20 text-black mb-10">Kontakt oss</h1>
               </div>
               <div class="form-box p-xs-15">
                  <form id="SaveContact" method="post" action="javascript:;">@csrf
                     <div class="row clearfix">
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Navn *</div>
                           <input type="text" id="name" name="name" placeholder="" required>
                           <p class="err text-center" id="Contact-name" style="display: none;"></p>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">E-post *</div>
                           <input type="email" name="email" placeholder="" title="Please enter valid email" required>
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
                           <!-- <div class="field-label">Telefonnummer *</div> -->
                           <input class="load-c-code homecontact-code load_countrycode" type="text" name="countrycode" value="+47" readonly>
                           <input class="contact-mobile-area t-number-area" type="text" name="mobile" placeholder="" required style="margin-top:25px;">
                           <p class="err text-center" id="Contact-mobile" style="display: none;"></p>
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           <div class="field-label">Emne *</div>
                           <input type="text" name="subject" placeholder="" required>
                           <p class="err text-center" id="Contact-mobile" style="display: none;"></p>
                        </div>
                       
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                           <div class="field-label">Beskjed *</div>
                           <textarea name="message" id="description" placeholder="" required></textarea>
                           <p class="err text-center" id="Contact-message" style="display: none;"></p>
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12 text-right">
                           <button class="normal-btn theme-btn" type="submit" name="submit-form">SEND</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <!--Left Side-->
            <div class="col-md-4 col-sm-5 col-xs-12 column pull-right">
               <div class="sec-title">
                  <br><br>
                  <h2>Ta kontakt med oss</h2>
                  <div class="line"></div>
               </div>
               <div class="info-box contact-info-box p-xs-15">
                  <ul>
                     <li>
                        <!-- <span class="icon fa fa-phone"></span> -->
                        <!-- <p>(+064)-342-68382</p>
                        <p>(+064)-342-68383</p> -->
                        <!-- <p>Tlf: +47 973 44 447 (10:00-14:00)</p> -->
                     </li>
                     <li>
                        <span class="icon fa fa-envelope"></span>
                        <p>E-post:hei@samling.no
                        </p>
                     </li>
                  </ul>
                  <br>
                  <h3>Sosiale medier</h3>
                  <div class="social-links">
                     <a target="_blank" href="https://www.facebook.com/profile.php?id=61555971146343&sk=about">
                        <span class="fa fa-facebook-f"></span>
                     </a>
                     <a target="_blank" href="https://www.instagram.com/samling.no?igsh=MXgxOTZrZ25sdGNrOQ%3D%3D&utm_source=qr"><span class="fa fa-instagram"></span>
                     </a>
                     <a target="_blank" href="https://www.tiktok.com/@samling.no?_t=8jKC5OhZ9H7&_r=1">
                        <img src="{{ asset('front/images/icons/tiktok.png') }}">
                     </a>
                    <!--  <a href="#"><span class="fa fa-google-plus"></span></a>
                     <a href="#"><span class="fa fa-youtube-play"></span></a> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--Main Footer-->
</div>
@endsection