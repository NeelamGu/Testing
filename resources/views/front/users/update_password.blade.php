@extends('front.layout.layout')
@section('content')
<style>
   .page-wrapper
   {
      min-height:auto;
   }
</style>
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
                           <p >Profil</p>
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
                           <p class="active-list">Bytt passord</p>
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
            <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
               <div class="sec-title account-heading">
                  <h3 class="font-20 text-black account-title">Hei!</h3>
                  <p>Bytt passord</p>
               </div>
               <div class="form-box p-xs-15">
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
                  <p id="password-success"></p>
                  <p id="password-error"></p>
                  <form id="passwordForm" action="javascript:;" method="post">@csrf 
                     <div class="row clearfix">
                        <div class="form-group eye-password-area current-password-area eye-password-update col-md-6 col-sm-12 col-xs-12">
                           <div class="field-label">Nåværende passord</div>
                           <input class="eyepassword" type="password" id="current-password" name="current_password" placeholder="">
                           <p id="password-current_password"></p>
                           <span toggle=".eyepassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group col-md-6 eye-password-area eye-password-update col-sm-12 col-xs-12">
                           <div class="field-label">Nytt passord</div>
                           <input class="eye-password-update" type="password" id="new-password" name="new_password" placeholder="">
                           <p id="password-new_password"></p>
                           <span toggle=".eye-password-update" class="fa fa-fw fa-eye field-icon toggle-password-two"></span>
                        </div>
                        <div class="form-group col-md-6 eye-password-area current-password-area col-sm-12 col-xs-12">
                           <div class="field-label">bekreft passord</div>
                           <input class="eyepasswordthree" type="password" id="confirm-password" name="confirm_password" placeholder="">
                           <span toggle=".eyepasswordthree" class="fa fa-fw fa-eye field-icon toggle-password-three"></span>
                           <p id="password-confirm_password"></p>
                        </div>
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