@extends('front.layout.layout')
@section('content')
<style>
   .assignment-tips {
      border: 1px solid #e5d7c2;
      border-radius: 14px;
      background: linear-gradient(180deg, #fffdf7 0%, #fdf8ee 100%);
      padding: 18px;
      margin: 0 0 16px;
      box-shadow: 0 10px 24px rgba(70, 52, 24, 0.06);
   }
   .assignment-tips h4 {
      margin: 0 0 6px;
      color: #2f2516;
      font-weight: 700;
      font-size: 30px;
      line-height: 1.05;
   }
   .assignment-tips .tips-lead {
      margin: 0 0 12px;
      color: #66553f;
      font-size: 15px;
      line-height: 1.45;
   }
   .tips-steps {
      margin: 0;
      padding: 0;
      list-style: none;
      counter-reset: tip-step;
      display: grid;
      gap: 8px;
   }
   .tips-steps li {
      counter-increment: tip-step;
      display: grid;
      grid-template-columns: 28px 1fr;
      gap: 10px;
      align-items: start;
      color: #4f4334;
      font-size: 14px;
      line-height: 1.5;
      padding: 8px 10px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.76);
      border: 1px solid #f0e4d3;
      opacity: 0;
      transform: translateY(8px);
      animation: tipIn 480ms ease forwards;
   }
   .tips-steps li::before {
      content: counter(tip-step);
      width: 28px;
      height: 28px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: #cf8a3d;
      color: #fff;
      font-weight: 700;
      font-size: 13px;
      margin-top: 1px;
      box-shadow: 0 4px 10px rgba(119, 72, 20, 0.2);
   }
   .tips-steps li:nth-child(1) { animation-delay: 60ms; }
   .tips-steps li:nth-child(2) { animation-delay: 120ms; }
   .tips-steps li:nth-child(3) { animation-delay: 180ms; }
   .tips-steps li:nth-child(4) { animation-delay: 240ms; }
   .tips-steps li:nth-child(5) { animation-delay: 300ms; }
   .tips-example {
      margin-top: 12px;
      padding: 10px 12px;
      border-radius: 10px;
      border: 1px dashed #d8c2a1;
      background: #fff;
   }
   .tips-example strong {
      display: block;
      color: #2f2516;
      font-size: 13px;
      margin-bottom: 4px;
   }
   .tips-example p {
      margin: 0;
      font-size: 13px;
      line-height: 1.5;
      color: #5a4b37;
   }
   @keyframes tipIn {
      to {
         opacity: 1;
         transform: translateY(0);
      }
   }
   @media (max-width: 767px) {
      .assignment-tips h4 {
         font-size: 24px;
      }
      .assignment-tips .tips-lead {
         font-size: 14px;
      }
      .tips-steps li {
         font-size: 13px;
      }
   }
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
               <div class="assignment-tips">
                  <h4>Tips for et tydelig oppdrag</h4>
                  <p class="tips-lead">Fyll ut disse punktene, så får du raskere svar og mer relevante tilbud fra leverandører.</p>
                  <ul class="tips-steps">
                     <li><span>Skriv en konkret tittel som sier hva du trenger, for eksempel "Kake til konfirmasjon, 30 personer".</span></li>
                     <li><span>Beskriv leveringsdato og adresse tydelig, så leverandøren vet når og hvor.</span></li>
                     <li><span>Forklar detaljer som antall gjester, stil, smak, allergier og andre viktige krav.</span></li>
                     <li><span>Legg inn ønsket pris eller budsjett, så blir tilbudene mer treffsikre.</span></li>
                     <li><span>Last gjerne opp inspirasjonsbilde, det gjør kommunikasjonen enklere fra start.</span></li>
                  </ul>
                  <div class="tips-example">
                     <strong>Eksempel på god beskrivelse</strong>
                     <p>"Vi ønsker en rund sjokoladekake til 25 personer, levering lørdag kl. 14:00 i Oslo. Pynt i hvitt og grønt, uten nøtter. Budsjett ca. 1500 kr."</p>
                  </div>
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