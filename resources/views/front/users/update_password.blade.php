@extends('front.layout.layout')
@section('content')
<style>
   .page-wrapper {
      min-height: auto;
   }
   .customer-panel-shell {
      background: #f8f4ed;
      border: 1px solid #ecd9bf;
      border-radius: 14px;
      padding: 16px;
      margin-top: 12px;
   }
   .customer-panel-main {
      background: #fff;
      border: 1px solid #efe1ce;
      border-radius: 12px;
      box-shadow: 0 12px 28px rgba(67, 47, 20, 0.08);
      overflow: hidden;
   }
   .customer-panel-header {
      padding: 16px 18px;
      border-bottom: 1px solid #f0e4d3;
      background: linear-gradient(120deg, #fff6e8, #fff);
   }
   .customer-panel-header h3 {
      margin: 0;
      font-size: 20px;
      color: #2f2516;
      font-weight: 700;
   }
   .customer-panel-header p {
      margin: 6px 0 0;
      color: #746652;
      font-size: 13px;
   }
   .customer-panel-body {
      padding: 14px;
   }
   .form-box {
      border: 1px solid #eedfca;
      border-radius: 10px;
      padding: 14px;
   }
   .form-box .field-label {
      font-size: 12px;
      text-transform: uppercase;
      color: #7b6852;
      margin-bottom: 6px;
      letter-spacing: 0.4px;
   }
   .form-box input {
      border: 1px solid #dbc4a3;
      border-radius: 8px;
      height: 42px;
      padding: 8px 10px;
   }
   .form-box input:focus {
      border-color: #d9851f;
      box-shadow: 0 0 0 3px rgba(217, 133, 31, 0.15);
   }
</style>
<div class="page-wrapper">
   @include('front.users.partials.topbar', ['activeTopTab' => 'profile'])
   <div class="contact-section account-page">
      <div class="auto-container">
         <div class="row clearfix">
            <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
               @include('front.users.partials.sidebar', ['activeTab' => 'password'])
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
               <div class="customer-panel-shell">
               <div class="customer-panel-main">
               <div class="customer-panel-header">
                  <h3>Sikkerhet</h3>
                  <p>Bytt passord for kontoen din.</p>
               </div>
               <div class="customer-panel-body">
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
                           <button style="float:left; margin-left: 0;" class="save-btn" type="submit" name="submit-form">
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
      </div>
   </div>
</div>
@endsection