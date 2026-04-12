@extends('front.layout.layout')
@section('content')
<style>
</style>
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
         <div class="row clearfix clear">
            <!--Content Side-->
            <div class="col-md-12 col-sm-12 col-xs-12 column pull-left">
               <div class="sec-title inquiry-title">
                  <h3 class="font-20 text-black">Legg ut oppdrag</h3>
               </div>
               <div class="form-box p-xs-15 enquery-form-box">
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
                     <div class="row">
                        <div class="form-group enquiry-col-area">
                           <div class="field-label">Tittel<span class="required-star">*</span></div>
                           <input name="title" id="title" type="text" name="title" placeholder="F.eks. unicorn-kake, tapas eller festsminke" @if(isset($_GET['title'])) value="{{ $_GET['title'] }}" @endif required>
                        </div>
                        <div class="form-group enquiry-col-area">
                           <div class="field-label">Kategori <span class="required-star">*</span></div>
                           <select name="category_id" id="category_id" required>
                              <option value="">Velg kategori</option>
                              @foreach($categories as $section)
                              <!-- <optgroup label="{{ $section['name'] }}"></optgroup> -->
                              @foreach($section['categories'] as $category)
                              <?php /* <option value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;--&nbsp;{{ $category['category_name'] }}</option> */ ?>
                              <optgroup label="{{ $category['category_name'] }}"></optgroup>
                              @foreach($category['subcategories'] as $subcategory)
                              <option value="{{ $subcategory['id'] }}" @if(isset($_GET['category_id'])&&$_GET['category_id']==$subcategory['id']) selected @endif>&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                              @endforeach
                              @endforeach
                              <!-- <option value="0">Other</option> -->
                              @endforeach
                           </select>
                        </div>
                        <div class="form-group enquiry-col-area">
                           <div class="field-label">Leveringsdato <span class="required-star">*</span></div>
                           <input class="form-control" placeholder="dd.mm.åååå
                              " type="date" id="assignment_date" name="assignment_date" @if(isset($_GET['assignment_date'])) value="{{ $_GET['assignment_date'] }}" @endif required>
                        </div>
                        <div class="form-group enquiry-col-area">
                           <div class="field-label">Leveringsadresse <span class="required-star">*</span></div>
                           <input type="text" name="address" id="address" placeholder="" @if(isset($_GET['address'])) value="{{ $_GET['address'] }}" @endif required>
                        </div>
                        <div class="form-group enquiry-col-area">
                           <div class="field-label">Postnummer <span class="required-star">*</span></div>
                           <input type="text" name="postcode" id="norway_pincode" placeholder="" required>
                        </div>
                     <div class="enqCont">
                           <div class="form-group  enquiry-col-area rm1">
                                 <div class="field-label">Fylke <span class="required-star">*</span></div>
                                 <select name="state" id="load_state" required>
                                    <option value="">Velg fylke</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state }}">{{ $state }}</option>
                                    @endforeach
                                    <!-- <option value="India">India</option> -->
                                 </select>
                           </div>
                           <div class="form-group enquiry-col-area rm2">
                                 <div class="field-label">Poststed <span class="required-star">*</span></div>
                                 <select name="city" id="load_city" required>
                                    <option value="">Velg poststed</option>
                                    @foreach($cities as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                    @endforeach
                                    <!-- <option value="India">India</option> -->
                                 </select>
                           </div>
                     </div>

                     <div class="form-group enquiry-checkbox-area enquiry-col-area">
                           <span class="space-area"></span>
                           <div class="input-checkbox-area form-group col-sm-4 col-xs-12 ">
                              <div class="field-label">Henter selv</div>
                              <input name="picked_up" type="checkbox" class="mb-0 me-2" value="Yes" >
                           </div>
                           <!-- new col added -->
                           <div class="input-checkbox-area enquiry-checkbox-area form-group col-sm-4 col-xs-12 ">
                              <div class="field-label">Ønsker levering</div>
                              <input name="want_delivery" type="checkbox" class="mb-0 me-2" value="Yes" >
                           </div>
                           <!--  new col end here -->
                        </div>
                         <!-- <div class="form-group enquiry-col-area">
                           <div class="field-label">Poststed <span class="required-star">*</span></div>
                           <select name="city" id="load_city" required>
                              <option value="">Velg Poststed</option>
                              @foreach($cities as $city)
                              <option value="{{ $city }}">{{ $city }}</option>
                              @endforeach
                           </select>
                        </div> -->
                        <!-- <div class="form-group enquiry-col-area">
                        </div> -->
                         <div class="form-group enquiry-col-area">
                           <div class="field-label">Legg til inspirasjonsbilde</div>
                           <input class="form-control" type="file" id="photo" name="photo">
                        </div>
                        <div class="form-group enquiry-col-area">
                           <div class="field-label">Ønsket pris</div>
                           <input type="text" name="desired_price" id="desired_price" placeholder="(f.eks ca 1000,-)">
                        </div>
                          <div class="form-group enquiry-col-area full-col-area">
                           <div class="field-label">Beskrivelse <span class="required-star">*</span></div>
                           <textarea name="description" id="description" class="form-control" placeholder="F.eks. design, smak, allergier, størrelse, antall gjester, osv" required>@if(isset($_GET['description'])) {{ $_GET['description'] }} @endif</textarea>
                        </div>

                        @if(!Auth::check())
                        <div class="form-group enquiry-col-area">
                           <div class="field-label">Fornavn <span class="required-star">*</span></div>
                           <input type="text" name="first_name" placeholder="" required>
                        </div>
                        <div class="form-group enquiry-col-area">
                           <div class="field-label">Etternavn  <span class="required-star">*</span></div>
                           <input type="text" name="last_name" placeholder="" required>
                        </div>
                        <div class="form-group enquiry-col-area">
                           <div class="field-label">E-post <span class="required-star">*</span></div>
                           <input type="email" name="email" placeholder="" required>
                        </div>
                        <div class="form-group enquery-col-select tphone-col enquiry-col-area">
                           <div class="field-label">Telefonnummer <span class="required-star">*</span></div>
                           <select name="country" class="enquire_country" required>
                              <option value="">Select</option>
                              @foreach($countries as $country)
                              <option value="{{ $country }}" @if($country=="NORWAY") selected @endif>{{ $country }}</option>
                              @endforeach
                           </select>
                           <!-- <input type="text" name="username" placeholder=""> -->
                        </div>
                        <div style="width:32%;" class="form-group enqure-tel-area load-code-area enquiry-col-area">
                           <!-- <div class="field-label">Telefonnummer <span class="required-star">*</span></div> -->
                           <input class="load-c-code load_countrycode" type="text" name="countrycode" value="+47" readonly>
                           <input class="t-number-area t-number-area-enquery" type="text" name="phone" <?php /* placeholder="xx xxx xxx" */ ?> required>
                        </div>

                         <!-- new col add here -->
                     <div class="form-group col-sm-6 col-12">
                        <label>Fødselsdato</label>
                        <input type="date" class="form-control" placeholder="" name="birth_date" id="user-birth_date">
                           <p id="register-birth_date"></p>
                     </div>
                     <!-- end here -->
                     <!-- new col add here -->
                     <div class="form-group col-sm-6 col-12">
                        <label>Kjønn</label>
                        <select class="create-account-select form-control" name="gender" id="user-gender">
                           <option value="">Velg kjønn</option>
                           <option value="Mann">Mann</option>
                           <option value="Kvinne">Kvinne</option>
                           <option value="Annet">Annet</option>
                        </select>
                        <p id="register-gender"></p>
                     </div>
                        <?php /* <div class="form-group enquiry-col-area">
                           <div class="field-label">Telefonnummer</div>
                           <input name="phone" type="text" class="form-control mb-2 inptFielsd" id="phone"
                              placeholder="Phone Number" />
                              <input id="country" type="text" name="country">
                        </div> */ ?>
                        @endif
                       
                      
                        <div class="form-group enquiry-butttons col-md-12 col-sm-12 col-xs-12 text-left">
                           <button class="normal-btn theme-btn submit-form-enquiry" type="submit" name="">LEVER INN OPPDRAG</button>
                           <!-- <a href="" class="normal-btn theme-btn enquiry-btn" style="border-radius: 50px;">ENQUIRE MORE</a> -->
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <!--Left Side-->
         </div>
      </div>
   </div>
   <!--Main Footer-->
</div>
@endsection