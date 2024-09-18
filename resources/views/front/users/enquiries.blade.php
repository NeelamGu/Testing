<?php 
use App\Models\Enquiry; 
use App\Models\Product; 
$messagesCountCustomer = messagesCountCustomer();
?>
@extends('front.layout.layout')
@section('content')
<style>
   .modal-backdrop
   {
   z-index:999;
   }
   .reply-btn
   {
   display: inline-block;
   margin-right: 10px;
   background-color:#878585;
   }
   .title-info
   {  
   margin-left:3  px;
   }
   .inquery-info-area
   {
   text-align:center;
   }
   .inquery-info-area li
   {
   margin-bottom:10px;
   width:50%;
   text-align:left;
   }
   .inquery-table-info
   {
   width:100%;
   }
   .inquery-table-info td
   {
   width:30%;
   }
   .inquery-table-info tr
   {
   margin-bottom:10px;
   display: block;
   }
   .border-zero
   {
   border:none !important;
   }
   .titlt-info
   {
   margin-left:100px;
   }
   .info-pop-table td
   {
   text-align:left;
   }
   .firt-row
   {
   border:none;
   }
   .replymodal
   {
     z-index: 9999;
    background-color: transparent;
    bottom: auto;
    top: auto;
    /*margin-top: 400px !important;*/
   }  
   .replymodal .modal-body
   {
      padding-bottom:0;
      padding-top:5px;
   }
   .replymodal .close
   {
      z-index:999;
      position:relative;
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
                           <p class="active-list">@if( isset($messagesCountCustomer) && $messagesCountCustomer>0)<span class="count-number" style="margin-left: -35px; margin-top: -2px;">{{$messagesCountCustomer}}</span> @endif Meldinger</p>
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
                  <h3 class="font-20 text-black account-title">Meldinger</h3>
               </div>
               <div class="row accTabsInfo order-tale-tabs " style="margin-top:12px;">
                  <div class="col-sm-12 col-12 mt-3">
                     <div class="table-responsive table-data">
                        <div id="loadEnqueries">
                           @include('front.users.load_enquiries')
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