<?php
use App\Models\Section;
$sections = Section::sections();
?>
@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
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
                  <li><a href="#">Leverandører</a></li>
               </ul>
            </div>
            <!--Go Down Button-->
         </div>
      </div>
   </section>
   <div class="lower-content">
      <div class="auto-container">

         <div class="ventor-form vender-register register-bg">
            <div class="row clearfix">
               <div class="col-md-7">
                  <div class="vendor-register-page">
                @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade in" role="alert">
                    {{ Session::get('success_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if(Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <strong> </strong> {{ Session::get('error_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> </strong> <?php echo implode('', $errors->all('<div>:message</div>')); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if($errors->any())
				    {{ implode('', $errors->all('<div>:message</div>')) }}
				@endif
				@if(isset($_GET['s']))
                <div role="alert" class="alert alert-success alert-dismissible"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button">X<span aria-hidden="true"></span></button>Takk for at du registrerte deg. Vi vil snart godkjenne kontoen din. Vennligst sjekk e-posten din for mer informasjon.</div>
                @endif
                @if(Session::has('flash_message_error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Feil! </strong>  {!! session('flash_message_error') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="alert alert-success print-success-msg" style="display:none">
                    <ul></ul>
                  </div>
                  <h4 class="text-thm title-border font-weight-700 mt-0 mb-10">Registreringsskjema for leverandør</h4>
                  <p class="mb-20" id="register-success" style="color:green"></p>

                  <!-- Mobile resister pop up start here only for mobile view -->
                  <div class="vendor-rpop">
                     <h4 class="r-login-area"><span>Allerede leverandør?</span><br><a data-toggle="modal" data-target="#customerlogin" href="">LOGG INN</a></h4>
                  
                   
                </div>

                  <!-- end here -->
                  <!-- Appointment Form Sart-->
                  <form id="vendorRegisterForm" name="vendorRegisterForm" class="form-transparent mt-30"
                     method="post"action="javascript:;">@csrf 
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group mb-20">
                              <!-- <div class="field-label">Bedriftsnavn <span class="required-star">*</span></div> -->
                              <input data-height="45px" id="vendorcompany" name="company_name"
                                 class="form-control bdrs-0" type="text"
                                 placeholder="*Virksomhetens navn" aria-required="true"
                                 style="height: 45px;" required="">
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="organisation_number" name="organisation_number"
                                 class="form-control bdrs-0" type="text"
                                 placeholder="Organisasjonsnummer (om bedriften er registrert)" aria-required="true"
                                 style="height: 45px;">
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="address" name="address"
                                 class="form-control bdrs-0" type="text"
                                 placeholder="*Bedriftsadresse" aria-required="true"
                                 style="height: 45px;" required="">
                           </div>
                        </div>
                     </div>
                     
                     
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="norway_pincode" name="pincode"
                                 class="form-control bdrs-0 required" type="text"
                                 placeholder="*Postnummer" aria-required="true" style="height: 45px;" title="Vennligst skriv inn gyldig postnummer" required>
                                 <p id="Register-pincode"></p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <!-- <input data-height="45px" id="city" name="city"
                                 class="form-control bdrs-0 required" type="text"
                                 placeholder="By" aria-required="true" style="height: 45px;" title="Vennligst skriv inn gyldig by" required> -->
                              <select name="city" id="load_city" class="form-control text-dark" required>
                              <option value="">*Poststed</option>
                              @foreach($cities as $city)
                                 <option value="{{ $city }}">{{ $city }}</option>
                              @endforeach
                              <!-- <option value="India">India</option> -->
                              </select>   
                                 <p id="Register-city"></p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <!-- <input data-height="45px" id="state" name="state"
                                 class="form-control bdrs-0 required" type="text"
                                 placeholder="Stat" aria-required="true" style="height: 45px;" title="Vennligst skriv inn gyldig stat" required> -->
                                 <select name="state" id="load_state" class="form-control text-dark" required>
                                 <option value="">*Fylke</option>
                                 @foreach($states as $state)
                                    <option value="{{ $state }}">{{ $state }}</option>
                                 @endforeach
                                 </select>  
                                 <p id="Register-state"></p>
                           </div>
                        </div>
                        
                     <!-- </div> -->
                     <!-- <div class="row"> -->
                        
                     <?php /*   <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="radius" name="radius"
                                 class="form-control bdrs-0 required radiusAll" type="number"
                                 placeholder="*Kan levere innen (radius i km)" aria-required="true" style="height: 45px;" title="Vennligst skriv inn gyldig stat" required min="1">
                                 <p id="Register-radius"></p>

                                 <input id="deliverToAll" name="deliverToAll" type="checkbox" value="Yes" />
                                 <label for="checkbox"><span class="reg-checkbox-text">Leverer til hele Norge (km)</span></label>
                           </div>
                        </div> */ ?>

                        <!-- <div class="col-sm-6">
                           <div class="form-group mb-20">
                             <select name="city" id="load_city" class="form-control text-dark" required>
                              <option value="">Innen byene</option>
                              @foreach($cities as $city)
                                 <option value="{{ $city }}">{{ $city }}</option>
                              @endforeach
                            <option value="India">India</option> 
                           </select> 
                           </div>
                        </div> -->
                        <div class="col-sm-3 phone-contact-col">
                           <div class="form-group mb-20 ">
                              <select name="country" class="enquire_country form-control bdrs-0" required>
                                 <option value="">Select</option>
                                 @foreach($countries as $country)
                                 <option value="{{ $country }}" @if($country=="NORWAY") selected @endif>{{ $country }}</option>
                                 @endforeach
                              </select>
                                 <p style="color:red !important;" id="Register-country"></p>
                           </div>
                        </div>
                        <?php /* <div class="col-sm-9 contact-mob-area">
                           <div class="form-group mb-20">
                              <input class="load-c-code  load_countrycode " type="text" name="countrycode" value="+47" readonly>
                              <input   data-height="45px" id="vendormobile" name="mobile"
                                 class="form-control t-number-area bdrs-0" type="text" pattern="\d*" required=""
                                 placeholder="*Telefonnummer" aria-required="true"
                                 style="height: 45px;" maxlength="8" minlength="8">
                                 <p style="color:red !important;" id="Register-mobile"></p>
                           </div>
                        </div> */ ?>
                        <div class="col-sm-9 contact-mob-area">
                           <div class="form-group mb-20" style="margin-left:16px;">
                              <input class="load-c-code  load_countrycode " type="text" name="countrycode" value="+47" readonly>
                              <input   data-height="45px" id="vendormobile" name="mobile"
                                 class="form-control t-number-area bdrs-0" type="text" required=""
                                 placeholder="*Telefonnummer" aria-required="true" style="height: 45px;">
                                 <p style="color:red !important;" id="Register-mobile"></p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="vendorname" name="name"
                                 class="form-control bdrs-0" type="text" required=""
                                 placeholder="*Kontaktperson fullt navn" aria-required="true"
                                 style="height: 45px;">
                                 <p id="Register-name"></p>
                           </div>
                        </div>
                        
                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="vendoremail" name="email"
                                 class="form-control bdrs-0 required email" type="email"
                                 placeholder="*Brukernavn (e-post)" aria-required="true" style="height: 45px;" title="Vennligst skriv inn gyldig e-post" required="">
                                 <p id="Register-email"></p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group eye-password-area eye-password-vendor mb-20">
                              <input data-height="45px" id="vendorpassword" name="password"
                                 class="form-control eyepassword bdrs-0 required" type="password"
                                 placeholder="*Passord" aria-required="true" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Passordet må bestå av minst 1 stor bokstav, 1 liten bokstav og 1 tall. Minst 6 tegn." style="height: 45px;" required="">
                                 <span toggle=".eyepassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                           </div>
                        </div>
                     </div>
                     
                     <!-- <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="birth_date" name="birth_date"
                                 class="form-control bdrs-0 textbox-n" type="text"
                                 placeholder="Fødselsdato" aria-required="true"
                                 style="height: 45px;" title="Fødselsdato" onfocus="(this.type='date')" onblur="(this.type='text')">
                                 <p style="color:red !important;" id="Register-birth_date"></p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="styled-select mb-20">
                              <select id="gender" name="gender" class="form-control"
                                 data-height="45px" style="height: 45px;">
                                 <option value="">Velg kjønn</option>
                                 <option value="Mann">Mann</option>
                                 <option value="Kvinne">Kvinne</option>
                                 <option value="Annet">Annet</option>
                              </select>
                           </div>
                        </div>
                     </div> -->
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="styled-select mb-20">
                              <font color="#E78002">Flere kategorier kan legges til senere</font><br>
                              <select id="vendorcategoryid" name="category_id" class="form-control"
                                 data-height="45px" required="" style="height: 45px;">
                                 <option value="">*Velg kategori</option>
                                 @foreach($categories as $section)
                                 @foreach($section['categories'] as $category)
                                 @if(count($section['categories'])>0)
                                 <optgroup label="{{ $category['category_name'] }}">
                                    <?php /* <option value="{{ $category['id'] }}">&nbsp;{{ $category['category_name'] }}</option> */ ?>
                                 	@foreach($category['subcategories'] as $subcategory)
                                    	<option value="{{ $subcategory['id'] }}">{{ $subcategory['category_name'] }}</option>
                                    @endforeach
                                 <?php /* </optgroup> */ ?>
                                 @endif
                                 @endforeach
                                @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                     
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="website" name="website"
                                 class="form-control bdrs-0 required" type="text"
                                 placeholder="Nettside-lenke" aria-required="true" style="height: 45px;" title="Vennligst skriv inn gyldig nettstedslink">
                                 <p id="Register-website"></p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="instagram" name="instagram"
                                 class="form-control bdrs-0 required" type="text"
                                 placeholder="Instagram-lenke" aria-required="true" style="height: 45px;" title="Vennligst skriv inn en gyldig Instagram-lenke">
                                 <p id="Register-instagram"></p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="facebook" name="facebook"
                                 class="form-control bdrs-0 required" type="text"
                                 placeholder="Facebook-lenke" aria-required="true" style="height: 45px;" title="Vennligst skriv inn en gyldig Facebook-lenke">
                                 <p id="Register-facebook"></p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="tiktok" name="tiktok"
                                 class="form-control bdrs-0 required" type="text"
                                 placeholder="Tiktok-lenke" aria-required="true" style="height: 45px;" title="Vennligst skriv inn gyldig Tik-tok-lenke">
                                 <p id="Register-tiktok"></p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group mb-20">
                              <input data-height="45px" id="youtube" name="youtube"
                                 class="form-control bdrs-0 required" type="text"
                                 placeholder="Youtube-lenke" aria-required="true" style="height: 45px;" title="Vennligst skriv inn gyldig Youtube-lenke">
                                 <p id="Register-youtube"></p>
                           </div>
                        </div>
                     </div>
                     <div class="form-group mb-0 mt-20">
                        <input id="form_botcheck" name="form_botcheck" class="form-control bdrs-0"
                           type="hidden" value="">
                        <button type="submit" class="btn thm-btn btn-flat"
                           data-loading-text="Vennligst vent...">REGISTRER</button>
                     </div>
                  </form>
                  <p class="vendor-rlink vendorlinkd ">
                  Are you located outside Norway and wish to deliver your services in Norway? Please 
                  <a href="{{ url('/contact')}}">click here.</a>
                  </p>
               </div>
            </div>
               <div class="col-md-5">
                  <br><br><br>
                  <!-- only view in mobile view -->
                  <a class="v-plans-btn dm-block" href="{{ url('/plans')}}">Se priser</a>
                  <!-- end here -->
                  <!-- <img alt="" src="images/resource/image-forlift2.png" class="img-responsive img-fullwidth"> -->
                  <h4 class="r-login-area vendorlinkd"><span>Allerede leverandør?</span><br><a data-toggle="modal" data-target="#customerlogin" href="">LOGG INN</a></h4>
                  <div class="register-img">
                  <img src="{{ asset('front/images/vender-register-img.jpg') }}"
                        alt="">
                     </div>
                      <!-- only view in mobile view -->
                     <a class="v-plans-btn d-m-none" href="{{ url('/plans')}}">Se priser</a>
                    <!--  end here -->
               </div>
            </div>
         </div>
         <br><br><br>
      </div>
   </div>
</div>
@endsection