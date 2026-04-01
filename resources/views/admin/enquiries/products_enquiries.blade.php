<?php 
   use App\Models\Vendor;
   use App\Models\Enquiry;
   use App\Models\Product; 
   use App\Models\ProductsEnquiry; 
   use App\Models\EnquiriesResponse; 
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
   .admin-file-icon
   {
   border-radius:0 !important;
   width: 100% !important;
   max-width: 16px;
   height: 16px !important;
   }
   .file-icon-area
   {
   background-color:#e46f01 ;
   border-color:#e46f01 ;
   padding: 6px 10px !important;
   }
   .file-icon-area:focus
   {
   border-color:#4B49AC !important;
   box-shadow:none !important;
   background-color:#4B49AC !important;
   }
   .file-icon-area:hover
   {
   background-color:#e46f01 !important;
   border-color:#e46f01 !important;
   }
   .replymodal .modal-header h4 {
   display: block;
   width: 100%;
   font-size: 28px;
   text-transform: uppercase;
   text-align: center;
   color: #E78002;
   }
   .replymodal .modal-header .close {
   font-size: 35px;
   position: absolute;
   top: 23px;
   right: 30px;
   color: #000;
   opacity: 1;
   z-index: 9;
   }
   .count-number 
   {
   position: absolute;
   left: 3px !important;
   width: 19px;
   top: -1px;
   text-align: center;
   height: 19px;
   background: #e78002;
   border-radius: 30px;
   vertical-align: middle;
   font-weight: bold;
   color: #Fff;
   line-height: 17px;
   font-size: 11px;
   }  
</style>
<style>
   tfoot {
   display: table-header-group;
   }
   .proenqsearch th input{
   width: 100%;
   }
   .hideColumn input{
   display: none;
   }
   .proActive font{
   vertical-align: super !important;
   display: inline-flex;
   }
</style>
<div class="main-panel">
   <div class="content-wrapper p-enquiries-wrapper">
      <div class="row">
         <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title">Oppdrag</h4>
                  <?php 
                     $getPlanDetails = Vendor::getPlanDetails($vendor_id);
                     $enquiriesCount = Enquiry::vendorEnquiriesCount($vendor_id);
                     $availableResponses = $getPlanDetails['responses_limit'] - $enquiriesCount; 
                     if($availableResponses<0){
                         $availableResponses = 0;
                     }
                     ?>
                  Gjenstående klipp: {{ $availableResponses }}
                  <!-- <p class="card-description">
                     Add class <code>.table-bordered</code>
                     </p> -->
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <strong>Success: </strong> {{ Session::get('success_message')}}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif
                  <form method="get">
                     <button type="submit" style="float:right; margin-left: 5px; border: 0px;">søk</button>
                     <select name="cat" <?php /* onchange="document.location.href = '?cat=' + this.value" */ ?> style="float:right; margin-left: 5px;">
                        <option value="">Velg kategori</option>
                        @foreach($allcategories as $cat)
                        <option value="{{ $cat }}" @if(isset($_GET['cat'])&&$_GET['cat']==$cat) selected @endif>{{ $cat }}</option>
                        @endforeach
                     </select>
                     <select name="pin" <?php /* onchange="document.location.href = '?pin=' + this.value" */ ?> style="float:right; margin-left: 5px;">
                        <option value=""> Velg pinned/unpinned </option>
                        <option value="1" @if(isset($_GET['pin'])&&$_GET['pin']==1) selected @endif>Pinned</option>
                        <option value="0" @if(isset($_GET['pin'])&&$_GET['pin']==0) selected @endif>Unpinned</option>
                     </select>
                     <select name="status" style="float:right; margin-left: 5px;">
                        <option value="">Velg oppdrag</option>
                        <option value="1" @if(isset($_GET['status'])&&$_GET['status']==1) selected @endif>Aktiv</option>
                        <option value="0" @if(isset($_GET['status'])&&$_GET['status']==0) selected @endif>Avsluttet av kunden</option>
                     </select>
                  </form>
                  <div class="table-responsive pt-3">
                     <table <?php /* id="products_enquiries_all" */ ?> class="enquiries-table table table-bordered">
                        <thead>
                           <tr>
                              <!-- <th>
                                 ID
                                 </th> -->
                              <th>
                                 Dato
                              </th>   
                              <th>
                                 Kunde
                              </th>
                              <th>
                                 Kategori
                              </th>
                              <th>
                                 Annonse 
                              </th>
                              <!-- <th>
                                 Vendor Email
                                 </th> -->
                              <th>
                              Pinned/Unpinned
                              </th>
                              <th>
                              Aktiv/Avsluttet
                              </th>
                              <th>
                                 Oppdrag info/Meldinger
                              </th>
                           </tr>
                        </thead>
                        <?php /* <tfoot class="proenqsearch">
                           <tr>
                               <!-- <th class="hideColumn">
                                   ID
                               </th> -->
                               <th class="hideColumn">
                                   User
                               </th>
                               <th <?php // class="proActive" ?> class="hideColumn">
                        Category
                        </th>
                        <th class="hideColumn">
                           Product
                        </th>
                        <!-- <th>
                           Vendor Email
                           </th> -->
                        <th class="hideColumn">
                           Pin
                        </th>
                        <th class="hideColumn">
                           Actions
                        </th>
                        </tr>
                        </tfoot> */ ?>
                        <tbody>
                           @foreach($enquiries as $key => $enquiry)
                           @php $nameArr = explode(" ",$enquiry['user']['name']) @endphp
                           @if(isset($enquiry['product']['product_name']))
                           <tr>
                              <!-- <td>
                                 {{ $enquiry['id'] }}
                                 </td> -->
                                 <td>
                                    <?php
                                       $getlastEnquiryDate = EnquiriesResponse::getlastEnquiryDate($enquiry['id']);
                                       //dd($getlastEnquiryDate);
                                       if($getlastEnquiryDate!=""){
                                          echo $newDate = date("d.m.y, H:i", strtotime($getlastEnquiryDate));
                                       }else{
                                          echo $newDate = date("d.m.y, H:i", strtotime($enquiry['created_at']));   
                                       }
                                    ?>
                              </td>
                              <td style="line-height:20px;">
                                 <!-- <a style="color: #006699;" target="_blank" href="{{ url('admin/users?email='.$enquiry['user']['email']) }}"> -->
                                 {{ ucfirst($nameArr[0]) }}<!-- <br>
                                    {{ $enquiry['user']['email'] }} --><!-- <br>
                                    {{ $enquiry['user']['mobile'] }} -->
                                 <!-- </a> -->
                              </td>
                              
                              <td>
                                 {{ $enquiry['product']['category']['category_name'] }}
                              </td>
                              <td style="position: relative;">
                                 @if(isset($enquiry['product']['product_name']))
                                 <?php $getProductURL = Product::productURL($enquiry['product']['product_name']); ?>
                                 <a style="color: #000; margin-left: 10px;" target="_blank" href="{{ url('product/'.$getProductURL.'/'.$enquiry['product_id']) }}">{{ $enquiry['product']['product_name'] }}@if( isset($enquiry['unreadCount']) && $enquiry['unreadCount']>0)<span class="count-number">{{ $enquiry['unreadCount'] }}</span>@endif</a>
                                 @else
                                 NA
                                 @endif
                              </td>
                              <!-- <td>
                                 <a style="color: #006699;" target="_blank" href="{{ url('admin/view-vendor-details/'.$enquiry['vendor']['id']) }}">{{ $enquiry['vendor']['email'] }}</a>
                                 </td> -->
                              <td>
                                 @if($enquiry['pin']==1)
                                 <a class="updatePinStatus" id="enquiry-{{ $enquiry['id'] }}" enquiry_id="{{ $enquiry['id'] }}" href="javascript:void(0)"><i style="font-size:25px; vertical-align:middle;" class="mdi mdi-bookmark-check" status="Active"></i>Pin</a><span style="margin-top:0px !important;"></span>
                                 @else
                                 <a class="updatePinStatus" id="enquiry-{{ $enquiry['id'] }}" enquiry_id="{{ $enquiry['id'] }}" href="javascript:void(0)"><i style="font-size:25px; vertical-align:middle;" class="mdi mdi-bookmark-outline" status="Inactive"></i>Unpin</a><span style="margin-top:0px !important;"></span>
                                 @endif
                              </td>
                              <td>
                                 @if($enquiry['status']==1)
                                 <i style="font-size:25px; vertical-align:middle;" class="mdi mdi-bookmark-check" status="Active"></i><span style="vertical-align:middle;">Aktiv</span>
                                 @else
                                 <i style="font-size:25px; vertical-align:middle;" class="mdi mdi-bookmark-outline" status="Inactive"></i>Avsluttet av kunden
                                 @endif
                              </td>
                              <td>
                                 <!-- <button style="padding: 6px 14px;" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myResponse{{ $enquiry['id'] }}"><i style="font-size: 17px;" class="icon-reply menu-icon"></i></button> -->
                                 @if($enquiry['enquiry_detail_id']>0)
                                 @php
                                 $enquiryDetails = Enquiry::enquiryDetails($enquiry['enquiry_detail_id'])
                                 @endphp
                                 <a class="reply-btn" data-toggle="modal" data-target="#replymodal{{$key}}">
                                 <button style="background-color:#878585; margin-right:10px; border-color:#878585;" style="padding: 6px 14px;" type="button" class="btn file-icon-area  btn-info btn-lg">
                                 <img class="admin-file-icon" src="{{ asset('front/images/icons/info-icon.png') }}" alt="" >
                                 </button>
                                 </a>
                                 <!--  modal popup start here -->
                                 <!-- Modal -->
                                 <div class="modal fade replymodal" id="replymodal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog">
                                       <!-- Modal content-->
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal">
                                             <span aria-hidden="true">×</span></button>
                                             <h4>Oppdrag info</h4>
                                          </div>
                                          <div class="modal-body">
                                             <div class="inquery-info-area">
                                                <table class="table info-pop-table">
                                                   <tr class="firt-row">
                                                      <td class="border-zero"><b>Tittel</b></td>
                                                      <td class="border-zero">{{ $enquiryDetails['title'] }}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Adresse</b></td>
                                                      <td>{{ $enquiryDetails['address'] }}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Postnummer</b></td>
                                                      <td>{{ $enquiryDetails['pincode'] }}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b> Poststed</b></td>
                                                      <td>{{ $enquiryDetails['city'] }}</td>
                                                   </tr>
                                                   
                                                   <tr>
                                                      <td><b>Ønsket pris</b></td>
                                                      <td>{{ $enquiryDetails['desired_price'] }}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Leveringsdato</b></td>
                                                      <td>{{ $enquiryDetails['assignment_date'] }}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Henter selv?</b></td>
                                                      <td>{{ $enquiryDetails['picked_up'] }}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Ønsker levering?</b></td>
                                                      <td>{{ $enquiryDetails['want_delivery'] }}</td>
                                                   </tr>
                                                   <tr>
                                                      <td><b>Forespørsel</b></td>
                                                      <td>{{ $enquiry['response'] }}</td>
                                                   </tr>
                                                   @if(isset($enquiryDetails['photo'])&&!empty($enquiryDetails['photo']))
                                                   <tr>
                                                      <td><b>Inspiration Image</b></td>
                                                      <td><a target="_blank" href="{{ url('front/images/photos/'.$enquiryDetails['photo']) }}"><img style="width:100px;" src="{{ asset('front/images/photos/'.$enquiryDetails['photo']) }}"></a></td>
                                                   </tr>
                                                   @endif
                                                </table>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <a class="reply-btn" style="visibility: hidden;">
                                 <i class="fa fa-info" aria-hidden="true"></i>
                                 </a>
                                 @endif
                                 <a href="{{ url('admin/products-enquiries/'.$enquiry['id']) }}">
                                 <button style="padding: 6px 14px;" type="button" class="btn file-icon-area btn-info btn-lg">
                                 <img class="admin-file-icon" src="{{ asset('front/images/icons/chat-icon.png') }}" alt="" >
                                 </button></a>
                              </td>
                           </tr>
                           <!-- Modal -->
                           <?php /* <div id="myResponse{{ $enquiry['id'] }}" class="modal reply-modal fade show" role="dialog" aria-modal="true">
                              <div class="modal-dialog">
                                 <!-- Modal content-->
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal">
                                       <span aria-hidden="true">×</span></button>
                                       <h4>Reply to Enquiry</h4>
                                    </div>
                                    <div class="modal-body">
                                       <form id="replyEnquiryForm" method="post" action="{{ url('admin/reply-enquiry') }}">@csrf
                                          <input type="hidden" name="enquiry_id" value="{{ $enquiry['id'] }}">   
                                          <input type="hidden" name="user_id" value="{{ $enquiry['user_id'] }}">
                                          <input type="hidden" name="product_id" value="{{ $enquiry['product_id'] }}">
                                          <input type="hidden" name="vendor_id" value="{{ $enquiry['vendor_id'] }}">
                                          <div class="row clearfix">
                                             <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                <textarea name="response" class="form-control" placeholder="Message *" required=""></textarea>
                                             </div>
                                             <div class="col-md-12  col-sm-12 col-xs-12 form-group text-center">
                                                <button type="submit" class="theme-btn normal-btn">Submit</button>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              </div> */ ?>
                           @endif
                           @endforeach 
                        </tbody>
                     </table>
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