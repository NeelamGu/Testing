<?php 
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
</style>
<script type="text/javascript">
window.setTimeout(function(){ document.location.reload(true); }, 60000);
</script>
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
                           <p class="active-list">Profil</p>
                        </a>
                     </li>
                     <!-- <li>
                         <a href="{{url('user/select-category')}}">
                             <span class="fa fa-plus"></span>
                             <p></span>Ny annonse</p>
                         </a>
                     </li> -->
                     <!-- <li>
                          <a href="{{url('/user/add-event')}}">
                              <span class="fa fa-calendar"></span>
                              <p>Legg til hendelse</p>
                          </a>
                      </li> -->
                     <li>
                        <a href="{{url('user/enquiries')}}">
                           <span class="fa fa-comment"></span>
                           <p>@if( isset($messagesCountCustomer) && $messagesCountCustomer>0)<span class="count-number">{{$messagesCountCustomer}}</span> @endif Meldinger</p>
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
               <div class="sec-title account-heading reply-table-section">
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade in" role="alert" style="margin-top:20px;">
                     <strong>Success: </strong> {{ Session::get('success_message')}}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif
                  @if(Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <span style="font-weight: bold; float:left;"> </span> {{ $errors->response->first('message') }}<br>
                  {{ $errors->response->first('image') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if(count($errors) > 0 )
                  <div class="alert alert-danger alert-dismissible fade in" role="alert" style="margin-top:20px;">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      <ul class="p-0 m-0" style="list-style: none;">
                          @foreach($errors->all() as $error)
                          <li>{{$error}}</li>
                          @endforeach
                      </ul>
                  </div>
               @endif
                @if(isset($enquiries[0]['enquiry']['product']['product_name']))
                  <?php $getProductURL = Product::productURL($enquiries[0]['enquiry']['product']['product_name']); ?>
                  <h3 class="font-20 text-black account-title">Samtale med <a target="_blank" href="{{ url('product/'.$getProductURL.'/'.$enquiries[0]['enquiry']['product']['id']) }}">{{ $enquiries[0]['enquiry']['product']['product_name'] }}</a></h3>
               @else
                  <h3 class="font-20 text-black account-title">Samtale med</h3>
               @endif
                  <div class="replysec-btn text-right">
                     <a href="{{ url('user/enquiries/') }}" class="reply-back-btn">
                     <i class="fa fa-arrow-left" aria-hidden="true"></i>Back
                     </a>
                     <a href="" class="reply-ref-btn">
                     <i class="fa fa-refresh" aria-hidden="true"></i>
                     </a>
                  </div>
               </div>
               <div class="chat-area-sec enquiries-reply-area">
                  @foreach($enquiries as $enquiry)
                  <div class="row accTabsInfo order-tale-tabs ">
                     @if($enquiry['sender_type']=="Customer")
                     <div class="col-sm-12">
                        <div class="customermsg">
                           <span class="enquery-msg">
                           {{ $enquiry['message'] }}
                           </span>
                           @if($enquiry['images']!="")
                              @php $imagesArr = explode(",",$enquiry['images']) @endphp
                              @foreach($imagesArr as $image)
                                 @if($image!="")
                                 <a href="{{ url('front/images/enquiries_images/'.$image)}}" target="_blank">
                                    <img style="max-width: 130px; margin-right:10px; " class="msg-reply-img" src="{{ asset('front/images/enquiries_images/'.$image)}}">
                                 </a>
                                 @endif
                              @endforeach
                           @endif
                           <span class="chat-dtime">
                              <?php
                              echo $newDate = date("d.m.y, H:i", strtotime($enquiry['created_at']));
                              ?></span>
                        </div>
                     </div>
                     @endif
                     @if($enquiry['sender_type']=="Vendor")
                     <div class="col-sm-12">
                        <div class="vendormsg">
                           
                           <span class="enquery-msg">
                           {{ $enquiry['message'] }}
                        </span>
                           @if($enquiry['images']!="")
                              @php $imagesArr = explode(",",$enquiry['images']) @endphp
                              @foreach($imagesArr as $image)
                                 @if($image!="")
                                 <a href="{{ url('front/images/enquiries_images/'.$image)}}" target="_blank">
                                    <img style="max-width: 130px; margin-right:10px; " class="msg-reply-img" src="{{ asset('front/images/enquiries_images/'.$image)}}">
                                 </a>
                                 @endif
                              @endforeach
                           @endif
                        <span class="chat-dtime">
                              <?php
                              echo $newDate = date("d.m.y, H:i", strtotime($enquiry['created_at']));
                              ?></span> 
                        </div>
                     </div>
                     @endif
                  </div>
                  @endforeach
                  <div class="send-reply">
                     <div class="form-group">
                        <form id="replyEnquiryForm" method="post" action="{{ url('user/enquiry/response') }}" enctype="multipart/form-data">@csrf
                           <input type="hidden" name="enquiry_id" value="{{ $enquiry_id }}">
                           <textarea style="padding:10px;" name="message" placeholder="Send melding til leverandøren" required></textarea>
                           <input class="upload-file-area" type="file" name="images[]" multiple>
                           <button class="r-btn">Send</button>
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

@section('javascript')

<script>
    $(document).ready(function () {
       $("#replyEnquiryForm").submit(function (event) {
           event.preventDefault(); // Prevent default form submission

           var form = $(this);
           var formData = new FormData(this);

           $.ajax({
               url: form.attr("action"),
               type: form.attr("method"),
               data: formData,
               processData: false,
               contentType: false,
               success: function (response) {
                   // Scroll back to the form after submission
                   $("html, body").animate({ 
                       scrollTop: $(".send-reply").offset().top - 100 // Adjusting for footer height
                   }, 1000);

                   // Optionally, reset the form
                   form[0].reset();
               },
               error: function () {
                   alert("Something went wrong. Please try again.");
               }
           });
       });
   });
</script>
@yield('javascript')
@endsection         