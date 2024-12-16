<style>
   .close
   {
      font-size: 41px;
      opacity:1;
   }
</style>
<div class="all-modal">
   <div class="modal fade p-0" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header border-bottom-0">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-title text-center">
                  <h4 class="text-dark">KUNDE INNLOGGING</h4>
               </div>
               <div class="d-flex flex-column text-center">
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade in" role="alert">
                     <strong>Suksess: </strong> {{ Session::get('success_message')}}
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
                  <p id="login-error"></p>
                  <p id="login-success"></p>
                  <form id="loginForm" action="javascript:;" method="post">
                     @csrf
                     <div class="form-group">
                        <input type="email" name="email" id="users-email" class="form-control" placeholder="E-post">
                        <p id="login-email"></p>
                     </div>
                     <div class="form-group eye-password-area">
                        <input type="password" name="password" id="users-password" class="form-control eyepassword" placeholder="Passord">
                        <span toggle=".eyepassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        <p id="login-password"></p>
                     </div>
                     <button type="submit" class="btn btn-info btn-block btn-round">Logg Inn</button>
                  </form>
                  <div class="signup-section">
                     <!-- Register as a Vendor?  -->
                     <a href="#" class="text-info signup-text" data-toggle="modal"
                        data-target="#signupModal" data-dismiss="modal" aria-label="Lukk">Registrer ny bruker</a>
                     <a href="#" class="text-info forgot-pass" data-toggle="modal"
                        data-target="#customer-forgot" data-dismiss="modal" aria-label="Lukk">
                     Glemt passord?</a>
                  </div>
               </div>
            </div>
            <!--  <div class="modal-footer d-flex justify-content-center">
               <span>Er du en leverandør?</span>
               <a class="signin-btn" href="" data-toggle="modal"
                  data-target="#customerlogin" data-dismiss="modal" aria-label="Lukk">Leverandør Logg på</a>
               </div> -->
         </div>
      </div>
   </div>
   <div class="modal fade p-0" id="customerlogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header border-bottom-0">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-title text-center">
                  <h4 class="text-dark">Leverandør Logg på</h4>
               </div>
               <div class="d-flex flex-column text-center">
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade in" role="alert">
                     <strong>Suksess: </strong> {{ Session::get('success_message')}}
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
                  <p id="vendor-login-error"></p>
                  <form id="vendorLoginForm" action="javascript:;" method="post">
                     @csrf
                     <div class="form-group">
                        <input type="email" name="email" id="vendor-email" class="form-control" placeholder="E-post">
                        <p id="vendor-login-email"></p>
                     </div>
                     <div class="form-group eye-password-area">
                        <input type="password" name="password" id="vendor-password" class="form-control eyepassword" placeholder="Passord">
                        <p id="vendor-login-password"></p>
                        <span toggle=".eyepassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                     </div>
                     <button type="submit" class="btn btn-info btn-block btn-round">Logg Inn</button>
                  </form>
                  <div class="signup-section">
                     <!-- Register as a Vendor?  -->
                     <a href="{{ url('vendor/register')}}" class="text-info signup-text" aria-label="Lukk"> Leverandørregistrering</a>
                     <a href="#" class="text-info forgot-pass" data-toggle="modal"
                        data-target="#businessforgot" data-dismiss="modal" aria-label="Lukk">
                     Glemt passord?</a>
                  </div>
               </div>
            </div>
            <!-- <div class="modal-footer d-flex justify-content-center">
               <span>Er du kunde?</span>
               <a class="signin-btn"  data-toggle="modal"
                  data-target="#loginModal" data-dismiss="modal" aria-label="Lukk" >Kundelogg på</a>
               </div> -->
         </div>
      </div>
   </div>


   <div class="modal create-account-modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered create-account-form" role="document">
         <div class="modal-content">
            <div class="modal-header border-bottom-0">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-title text-center">
                  <h4 class="text-dark">Opprett brukerkonto</h4>
               </div>
               <div class="d-flex flex-column text-left">
                  <p id="register-success"></p>
                  <form id="registerForm" action="javascript:;" method="post">
                     @csrf
                     <div class="form-group col-sm-6 col-12">
                        <label>Fornavn <span class="required-star">*</span></label>
                        <input type="text" id="user-first_name" name="first_name" class="form-control" placeholder="">
                        <p id="register-first_name"></p>
                     </div>
                     <!-- new col add here -->
                     <div class="form-group col-sm-6 col-12">
                        <label>Etternavn <span class="required-star">*</span></label>
                        <input type="text" id="user-last_name" name="last_name" class="form-control" placeholder="">
                        <p id="register-last_name"></p>
                     </div>
                     <!-- end here -->
                     
                     <div class="form-group phone-contact-col col-sm-3 col-12">
                        <label>Telefonnummer <span class="required-star">*</span></label>
                        <select name="country" class="enquire_country form-control bdrs-0" required>
                           <option value="">Select</option>
                           @foreach($countries as $country)
                           <option value="{{ $country }}" @if($country=="NORWAY") selected @endif>{{ $country }}</option>
                           @endforeach
                        </select>
                        <p id="register-country"></p>
                     </div>
                     <div class="form-group contact-mob-area col-sm-9 col-12">
                        <!-- <label>Telefonnummer <span class="required-star">*</span></label> -->
                        <input class="load-c-code load_countrycode code-n-area " type="text" name="countrycode" value="+47" readonly>
                        <input type="text" id="user-mobile" name="mobile" class="form-control register-mobile-area t-number-area bdrs-0" placeholder="Mobil nummeret ditt...">
                        <p id="register-mobile"></p>
                     </div>
                     <div class="form-group col-sm-12 col-12">
                        <label>E-post <span class="required-star">*</span></label>
                        <input type="email" id="user-email" name="email" class="form-control" placeholder="E-post">
                        <p id="register-email"></p>
                     </div>
                     <div class="form-group eye-password-area eye-password-register col-sm-6 col-12">
                        <label>Velg passord <span class="required-star">*</span></label>
                        <input type="password" id="user-password" name="password" class="form-control eyepassword" placeholder="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Passordet må bestå av minst 1 stor bokstav, 1 liten bokstav og 1 tall. Minst 6 tegn.">
                        <span toggle=".eyepassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        <p id="register-password"></p>
                        
                     </div>
                     <!-- new col add here -->
                     <div class="form-group eye-password-area eye-password-register-two col-sm-6 col-12">
                        <label>Bekreft passord <span class="required-star">*</span></label>
                        <input type="password" id="user-confirm_password" name="confirm_password" class="form-control eyepassword-two"
                           placeholder="">
                           <span toggle=".eyepassword-two" class="fa fa-fw fa-eye field-icon toggle-password-two"></span>
                        <p id="register-confirm_password"></p>
                     </div>
                     <!-- end here -->
                     <!-- new col add here -->
                     <div class="form-group col-sm-6 col-12">
                        <label>Fødselsdato</label>
                        <input <?php /* type="date" */ ?> type="text" class="form-control" placeholder="YYYY-MM-DD" name="birth_date" id="user-birth_date">
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

                     <div class="form-group col-sm-12 col-12 checkbox-term-area">
                         <input id="user-agree" name="agree" type="checkbox" value="Yes" />
                         <label for="checkbox"> I agree to these <a href="{{ url('/terms-conditions')}}">Terms and Conditions</a>.</label>
                         <p id="register-agree"></p>
                     </div>
                     <!-- end here -->
                     <button type="submit" class="btn btn-info btn-block btn-round">Registrer</button>
                  </form>
               </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
               <div class="signup-section">Har allerede konto? <a href="#" class="text-info" data-toggle="modal"
                  data-target="#loginModal" data-dismiss="modal" aria-label="Lukk"> Logg inn</a>.</div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade p-0" id="customer-forgot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header border-bottom-0">
               <button type="button" class="close" data-dismiss="modal" aria-label="Lukk">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-title text-center">
                  <h4 class="text-dark">Glemt passordet?</h4>
               </div>
               <div class="d-flex flex-column text-center">
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
                     <button type="button" class="close" data-dismiss="alert" aria-label="Lukk">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif
                  @if($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <strong> </strong> <?php echo implode('', $errors->all('<div>:message</div>')); ?>
                     <button type="button" class="close" data-dismiss="alert" aria-label="Lukk">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif
                  <p id="forgot-error"></p>
                  <p id="forgot-success"></p>
                  <form id="forgotForm" action="javascript:;" method="post">
                     @csrf
                     <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-post">
                        <p id="forgot-email"></p>
                     </div>
                     <button type="submit" class="btn btn-info btn-block btn-round">Send</button>
                  </form>
               </div>
            </div>
            <!-- <div class="modal-footer d-flex justify-content-center">
               <span>Eksisterende kunde?</span>
               <a class="signin-btn"  data-toggle="modal"
                  data-target="#loginModal" data-dismiss="modal" aria-label="Lukk" >Logg inn nå</a>
            </div> -->
         </div>
      </div>
   </div>
   <div class="modal fade p-0" id="businessforgot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header border-bottom-0">
               <button type="button" class="close" data-dismiss="modal" aria-label="Lukk">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-title text-center">
                  <h4 class="text-dark">Glemt passordet?</h4>
               </div>
               <div class="d-flex flex-column text-center">
                  <p class="forgot-success"></p>
                  <form id="vendorForgotForm" action="javascript:;" method="post">
                     @csrf
                     <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-post">
                        <p class="forgot-email"></p>
                     </div>
                     <button type="submit" class="btn btn-info btn-block btn-round">Send</button>
                  </form>
               </div>
            </div>
            <!-- <div class="modal-footer d-flex justify-content-center">
               <span>Eksisterende leverandør?</span>
               <a class="signin-btn"  data-toggle="modal"
                  data-target="#loginModal" data-dismiss="modal" aria-label="Lukk" >Logg inn nå</a>
            </div> -->
         </div>
      </div>
   </div>
</div>
<!--End pagewrapper-->
<!--Scroll to top-->
<div class="scroll-to-top scroll-to-target" data-target="#main-header"><span class="fa fa-arrow-up"></span></div>