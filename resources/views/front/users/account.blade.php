@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
   <div class="contact-section account-page">
      <div class="auto-container">
         <div class="row clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
               <div class="info-box p-xs-15">
                  <ul class="account-sidebar">
                     <li>
                        <a href="{{url('user/account')}}">
                           <span class="fa fa-user"></span>
                           <p class="active-list">Min Profil </p>
                        </a>
                     </li>
                     <!-- <li>
                         <a href="{{url('user/select-category')}}">
                             <span class="fa fa-plus"></span>
                             <p></span>Ny annonse</p>
                         </a>
                     </li>
                     <li>
                          <a href="{{url('/user/add-event')}}">
                              <span class="fa fa-calendar"></span>
                              <p>Legg til hendelse</p>
                          </a>
                      </li> -->
                     <li>
                        <a href="{{url('user/enquiries')}}">
                           <span class="fa fa-comment"></span>
                           <p>Meldinger</p>
                        </a>
                     </li>
                     <li>
                        <a href="{{url('user/update-password')}}">
                           <img src="{{ asset('front/images/icons/change-password.svg') }}" alt="">
                           <p>Bytt passord</p>
                        </a>
                     </li>
                     <li>
                        <a href="{{url('user/logout')}}">
                           <img src="{{ asset('front/images/icons/log-out.svg') }}" alt="">
                           <p>Logg ut</p>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
            <!--Content Side-->
            <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
               <div class="sec-title account-heading">
                  <h3 class="font-20 text-black account-title">Hei {{ Auth::user()->name }} !</h3>
                  <p>Personlige opplysninger</p>
               </div>
               <div class="form-box p-xs-15 account-form">
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Suksess: </strong> {{ Session::get('success_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if(Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
               	<p id="account-error"></p>
                  <p id="account-success"></p>
                  <form id="accountForm" action="javascript:;" method="post">@csrf
                     <div class="row clearfix">
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">E-post</div>
                           <input type="text" placeholder="" value="{{ Auth::user()->email }}" readonly style="background-color: #f9f9f9;">
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Mobil</div>
                           <input type="text" <?php /* pattern="\d*" */ ?> id="user-mobile" name="mobile" placeholder="" value="{{ Auth::user()->mobile }}" <?php /* maxlength="8" minlength="8" */ ?>>
                                <p id="account-mobile"></p>
                        </div>
                        <!-- <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Navn</div>
                           <input type="text" id="user-name" name="name" placeholder="" value="{{ Auth::user()->name }}">
                                <p id="account-name"></p>
                        </div> -->
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Fornavn</div>
                           <input type="text" id="user-first_name" name="first_name" placeholder="" value="{{ Auth::user()->first_name }}">
                                <p id="account-first_name"></p>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Etternavn</div>
                           <input type="text" id="user-last_name" name="last_name" placeholder="" value="{{ Auth::user()->last_name }}">
                                <p id="account-last_name"></p>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Adresse</div>
                           <input type="text" id="user-address" name="address" placeholder="" value="{{ Auth::user()->address }}">
                                <p id="account-address"></p>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Poststed</div>
                           <input type="text" id="user-city" name="city" placeholder="" value="{{ Auth::user()->city }}">
                           <p id="account-city"></p>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Fylke</div>
                           <input type="text" id="user-state" name="state" value="{{ Auth::user()->state }}">
                           <p id="account-state"></p>
                        </div>
                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Postnummer</div>
                           <input type="text" id="user-pincode" name="pincode" value="{{ Auth::user()->pincode }}">
                           <p id="account-pincode"></p>
                        </div>
                        <!-- <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Country</div>
                           <select class="account-state" id="" name="" class="form-control valid" data-height="40px" required="">
                              <option value="">India</option>
                              <option value="">Australia</option>
                              <option value="">Brazil</option>
                           </select>
                        </div> -->
                        <!--  <div class="form-group col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Message *</div>
                           <textarea name="message" placeholder=""></textarea>
                           </div> -->
                        <!-- <div class="form-group input-radio col-md-6 col-sm-12 col-xs-12">
                           <div class="radio-check">
                              <input type="radio" name="role" value="ONE" id="one">
                              <label class="role" for="one">Men</label>
                              <input type="radio" name="role" value="TWO" id="two">
                              <label class="role" for="two">Women</label>
                           </div>
                        </div> -->
                        <div class="form-group col-md-12 col-sm-12 col-xs-12 text-right">
                           <!-- <button class="cancel-btn" type="submit" name="submit-form">Avbryt</button> -->
                           <button style="float:left; margin-left: -5px;" class="save-btn" type="submit" name="submit-form">
                           Lagre endringer</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection