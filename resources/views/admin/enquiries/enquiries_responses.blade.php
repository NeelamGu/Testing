<?php 
use App\Models\Product; 
use App\Models\Vendor; 
use App\Models\Enquiry; 
use App\Models\ProductsEnquiry; 
?>
@extends('admin.layout.layout')
@section('content')
<style>
   .enquiries-table td
   {
   white-space: inherit;
   }
   .modal.reply-modal .modal-header
   {
   border: none
   }
   .enquiries-reply-area {
   background-color: #fff3e5;
   margin-left: 2px;
   padding: 20px 30px;
   margin-top: 20px;
   }

      .upload-file-area
      {
      margin-top:10px;
      vertical-align:top;
      margin-left:10px;
      width:100%;
      max-width:220px;
      }

      .msg-reply-img
      {
         width:100%;
         max-width:200px;
         margin-bottom:20px;
      }
   .modal.reply-modal .close
   {
   right: 22px;
   position: absolute;
   color: #000;
   }
   .modal.reply-modal .close span
   {
   font-size: 30px;
   color: #000 !important;
   font-weight: bold;
   }


   .modal.reply-modal h4
   {
   display: block;
   width: 100%;
   font-size: 28px;
   text-transform: uppercase;
   text-align: center;
   color: #E78002;
   }
   .modal.reply-modal .modal-body
   {
   padding-top: 0 !important;
   }
   .modal.reply-modal .normal-btn
   {
   width: 100%;
   position: relative;
   padding: 9px 25px;
   line-height: 24px;
   max-width: 200px;
   text-transform: uppercase;
   background: #000;
   color: #ffffff !important;
   font-size: 14px;
   border: 2px solid #ffffff !important;
   font-family: 'robotoregular', sans-serif;
   display: inline-block;
   margin-top: 19px !important;
   }
   .send-reply textarea
   {
   display:inline-block;
   border:1px solid #e78002;
   width:60%;
   border-radius:4px;
   }
   .send-reply textarea:focus
   {
   border-color:#4b49ac;
   }
   /*.enquiries-reply-area
   {
   border: 1px solid #4b49ac;
   border-radius: 4px;
   margin-left: 2px;
   padding: 20px 0px;
   margin-top: 20px;
   }
   */
   .enquery-msg
   {
   margin-bottom: 10px;
   display: block;
   color:#000;
   }
   .chat-dtime
   {
   text-align: right;
   width: 100%;
   font-style: italic;
   display: block;
   color: #8b8b8b;
   }
   .customermsg
   {
   background-color: #fff;
   padding: 20px;
   width: 70%;
   box-shadow: 0px 7px 9px -8px rgba(0,0,0,0.1);
   border-radius: 4px;
   color: #000;
   margin-bottom:20px;
   padding: 15px 22px;
   float:right;
   border: 1px solid #e6e6e6;
   }
   .vendormsg .chat-dtime
   {
   color:#000;
   }
   .vendormsg .enquery-msg
   {
   color:#000;
   }
   .vendormsg
   {
   background-color: #f2f2f2;
   padding: 20px;
   width: 70%;
   box-shadow: 0px 7px 9px -8px rgba(0,0,0,0.1);
   border-radius: 4px;
   color: #000;
   margin-bottom:20px;
   padding: 15px 22px;
   border: 1px solid #d2d2d2;
   }
   .send-reply .r-btn
   {
   color: #fff;
   display: inline-block;
   border: 1px solid #e78002;
   padding: 10px 30px;
   background-color: #e78002;
   border-radius: 4px;
   font-size: 14px;
   margin-left: 10px;
   vertical-align:top;
   }
   .reply-table
   {
   width:60%;
   margin-top:40px;
   }
   .admin-chat
   {
        max-width: 1200px;
        text-align: left;
        float: left;
        width:100%;
   }    
   .reply-back-btn
    {
    padding: 8px 17px;
    background-color: #e78002;
    color: #fff;
    margin-right: 20px;
}

.reply-ref-btn 
{
    background-color: #383838;
    padding: 8px 15px;
    text-align: center;
    color: #fff;
}
.replysec-btn img
{
    width:100%;
    max-width:15px;
    margin-right: 10px;
}
.replysec-btn .refresh-icon
{
    margin-right:0px !important;
}
.back-btn a:hover
{
    color:#fff;
}

</style>
<script type="text/javascript">
window.setTimeout(function(){ document.location.reload(true); }, 60000);
</script>
<div class="main-panel">
   <div class="content-wrapper">
      <div class="row">
         <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
               <div class="card-body admin-chat">
                  @if(isset($enquiries[0]['enquiry']['product']['product_name']))
                  <?php $getProductURL = Product::productURL($enquiries[0]['enquiry']['product']['product_name']); ?>
                  @endif
                  <h4 class="card-title">Oppdrag @if(isset($enquiries[0]['enquiry']['product']['product_name']))for <a target="_blank" href="{{ url('product/'.$getProductURL.'/'.$enquiries[0]['enquiry']['product']['id']) }}">{{ $enquiries[0]['enquiry']['product']['product_name'] }}</a> @endif</h4>
                  <!-- <p class="card-description">
                     Add class <code>.table-bordered</code>
                  </p> -->

                    <div class="replysec-btn back-btn text-right">
                     <a href="{{ url('admin/products-enquiries') }}" class="reply-back-btn">
                     <img src="{{ asset('front/images/icons/aarow-icon.png')}}" alt="">Back
                     </a>
                     <a href="" class="reply-ref-btn">
                     <img class="refresh-icon" src="{{ asset('front/images/icons/refresh-icon.png')}}" alt="">
                     </a>
                  </div>
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:20px;">
                     <strong>Success: </strong> {{ Session::get('success_message')}}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif

                  @if(Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:20px;">
                    <strong> </strong> {{ $errors->response->first('message') }}<br>
                  {{ $errors->response->first('images') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if(count($errors) > 0 )
                  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:20px;">
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
                @if(Session::has('close_error_message'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:20px;">
                    <strong> </strong> {{ Session::get('close_error_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
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
                              <?php echo $newDate = date("d.m.y, H:i", strtotime($enquiry['created_at'])); ?> 
                              </span>
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
                                 ?> 
                              </span> 
                           </div>
                        </div>
                        @endif
                     </div>
                     @endforeach

                     <?php $getPlanDetails = Vendor::getPlanDetails($enquiry['enquiry']['vendor']['vendor_id']);
                        $enquiriesCount = Enquiry::vendorEnquiriesCount($enquiry['enquiry']['vendor']['vendor_id']);
                        $enquiryStatus = ProductsEnquiry::enquiryStatus($enquiry_id);
                     ?>
                     @if($enquiryStatus==0)
                        <div class="send-reply">
                           <div class="form-group">
                               Oppdraget er avsluttet av kunden
                           </div>
                        </div>
                     @elseif($getPlanDetails['responses_limit']>$enquiriesCount)
                        <div class="send-reply">
                           <div class="form-group">
                              <form id="replyEnquiryForm" method="post" action="{{ url('admin/reply-enquiry') }}" enctype="multipart/form-data">@csrf
                                 <input type="hidden" name="enquiry_id" value="{{ $enquiry_id }}">
                                 <input type="hidden" name="sender_id" value="{{ $enquiries[0]['enquiry']['vendor_id'] }}">
                                 <textarea style="padding:10px;" name="message" placeholder="Send Message to Customer" required></textarea>
                                 <input class="upload-file-area" type="file" name="images[]" multiple>
                                 <button class="r-btn" type="submit">Send</button>
                              </form>
                           </div>
                        </div>
                     @else
                        <div class="send-reply">
                           <div class="form-group">
                              <?php $code = base64_encode($enquiry['enquiry']['vendor']['email']); ?>
                              Please <a href="{{ url('admin/vendor/plans/upgrade/'.$code) }}">upgrade</a> your Plan to reply
                           </div>
                        </div>
                     @endif


                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- content-wrapper ends -->
   <!-- partial:../../partials/_footer.html -->
   <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?php echo date("Y"); ?>. All rights reserved.</span>
        </div>
    </footer>
   <!-- partial -->
</div>
@endsection