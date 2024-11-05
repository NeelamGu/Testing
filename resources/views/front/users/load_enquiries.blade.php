<?php 
use App\Models\Enquiry; 
use App\Models\Product; 
use App\Models\EnquiriesResponse; 
?>
<style>
   .count-number 
   {
   position: absolute;
   left: 2px !important;
   width: 19px;
   top: -5px;
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
<table class="table table-hover order-table tbl_res table-responsive">
   <thead>
      <tr class="">
         <!-- <td>ID</td> -->
         <td>Leverandør</td>
         <td>Opprettet den</td>
         <td>Kategori<br>
            <select id="selcatenq" class="seluserenquiries"> <?php /* onchange="document.location.href = '/user/enquiries?cat=' + this.value" */ ?>>
               <option value="">Select</option>
               @foreach($allcategories as $cat)
                  <option value="{{ $cat }}" @if(isset($enqCat)&&$enqCat==$cat) selected @endif>{{ $cat }}</option>
               @endforeach
            </select>
         </td>
         <td></td>
         <td>Pin/Unpin<br>
            <select id="selpinenq"  class="seluserenquiries">
               <option value="">Select</option>
                  <option value="1" @if(isset($pin_unpin)&&$pin_unpin=="1") selected @endif>Pin</option>
                  <option value="0" @if(isset($pin_unpin)&&$pin_unpin=="0") selected @endif>Unpin</option>
            </select>
         </td>
         <td>Avslutt oppdrag<br>
            <select id="selcloseenq"  class="seluserenquiries">
               <option value="">Select</option>
                  <option value="1" @if(isset($active_close)&&$active_close=="1") selected @endif>Aktiv</option>
                  <option value="0" @if(isset($active_close)&&$active_close=="0") selected @endif>Avsluttet</option>
            </select>
         </td>
      </tr>
   </thead>
   <tbody>
      @foreach($enquiries as $key => $enquiry)
      @if(isset($enquiry['product']['category']['category_name']))
      <tr>
         <!-- <td>{{ $enquiry['id'] }}</td> -->
         <td style="width:20%; position: relative;">
            @if(isset($enquiry['product']['product_name']))
               <?php $getProductURL = Product::productURL($enquiry['product']['product_name']); ?>
               <a style="text-decoration:underline;" target="_blank" href="{{ url('product/'.$getProductURL.'/'.$enquiry['product']['id']) }}">{{ $enquiry['product']['product_name'] }}   @if($enquiry['unreadCount']>0)<span class="count-number">{{ $enquiry['unreadCount'] }}</span>@endif</a>
            @else
               NA
            @endif
         </td>
         <td >
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
         <td>{{ $enquiry['product']['category']['category_name'] }}</td>
         <td>
            @if($enquiry['enquiry_detail_id']>0)
               @php
               $enquiryDetails = Enquiry::enquiryDetails($enquiry['enquiry_detail_id'])
               @endphp
               <a class="reply-btn" data-toggle="modal" data-target="#replymodal{{$key}}">
               <i class="fa fa-info" aria-hidden="true"></i>
               </a>
               <!--  modal popup start here -->
               <!-- Modal -->
               <div class="modal replymodal fade" id="replymodal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog">
                     <!-- Modal content-->
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">
                           <span aria-hidden="true">×</span></button>
                           <h4>Forespørselsdetaljer</h4>
                        </div>
                        <div class="modal-body">
                           <div class="inquery-info-area">
                              <table class="table info-pop-table">
                                 <tr class="firt-row">
                                    <td class="border-zero"><b>Tittel</b></td>
                                    <td class="border-zero">{{ $enquiryDetails['title'] }}</td>
                                 </tr>
                                 <tr>
                                    <td><b>Navn</b></td>
                                    <td>{{ $enquiryDetails['name'] }}</td>
                                 </tr>
                                 <tr>
                                    <td><b>Adresse</b></td>
                                    <td>{{ $enquiryDetails['address'] }}</td>
                                 </tr>
                                 <tr>
                                    <td><b>By</b></td>
                                    <td>{{ $enquiryDetails['city'] }}</td>
                                 </tr>
                                 <tr>
                                    <td><b>Pinkode</b></td>
                                    <td>{{ $enquiryDetails['pincode'] }}</td>
                                 </tr>
                                 @if($enquiryDetails['desired_price']>0)
                                 <tr>
                                    <td><b>Ønsket pris</b></td>
                                    <td>{{ $enquiryDetails['desired_price'] }}</td>
                                 </tr>
                                 @endif
                                 @if(isset($enquiryDetails['assignment_date'])&&!empty($enquiryDetails['assignment_date']))
                                 <tr>
                                    <td><b>Oppdragsdato</b></td>
                                    <td>{{ $enquiryDetails['assignment_date'] }}</td>
                                 </tr>
                                 @endif
                                 <tr>
                                    <td><b>Kan hentes? </b></td>
                                    <td>{{ $enquiryDetails['picked_up'] }}</td>
                                 </tr>
                                 <tr>
                                    <td><b>Ønsker du levering?</b></td>
                                    <td>{{ $enquiryDetails['want_delivery'] }}</td>
                                 </tr>
                                 @if(isset($enquiryDetails['photo'])&&!empty($enquiryDetails['photo']))
                                 <tr>
                                    <td><b>Inspiration Image</b></td>
                                    <td><a target="_blank" href="{{ url('front/images/photos/'.$enquiryDetails['photo']) }}"><img style="width:250px;" src="{{ asset('front/images/photos/'.$enquiryDetails['photo']) }}"></a></td>
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
            <a class="view-icon" href="{{ url('user/enquiries/'.$enquiry['id']) }}">
               <span class="fa fa-comment"></span>
            </a>
            </td>

            <td class="text-center">
            @if($enquiry['pin']==1)
                 <a class="updatePinStatus" id="pin-{{ $enquiry['id'] }}" pin_id="{{ $enquiry['id'] }}" href="javascript:void(0)"><i style="font-size:25px; margin-top: 0px;" class="mdi mdi-bookmark-check" status="Active"></i>Pin</a>&nbsp;&nbsp;
               @else
                 <a class="updatePinStatus" id="pin-{{ $enquiry['id'] }}" pin_id="{{ $enquiry['id'] }}" href="javascript:void(0)"><i style="font-size:25px; margin-top: 0px;" class="mdi mdi-bookmark-outline" status="Inactive"></i>Unpin</a>&nbsp;&nbsp;
            @endif
            </td>

            <td class="text-center">
            @if($enquiry['status']==1)
                 <a class="updateEnquiryStatus" id="enquiry-{{ $enquiry['id'] }}" enquiry_id="{{ $enquiry['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i><i class="fa fa-solid fa-toggle-on"></i></a>&nbsp;&nbsp;
               @else
                 <a class="updateEnquiryStatus" id="enquiry-{{ $enquiry['id'] }}" enquiry_id="{{ $enquiry['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i><i class="fa fa-solid fa-toggle-off"></i></a>&nbsp;&nbsp;
            @endif
            </td>

            



            <?php /* 
               <a class="reply-btn" data-toggle="modal" data-target="#replymodal">
               <i class="fa fa-reply" aria-hidden="true"></i>
               </a>
               <!--  modal popup start here -->
               <!-- Modal -->
               <div class="modal fade" id="replymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog">
                     <!-- Modal content-->
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">
                           <span aria-hidden="true">×</span></button>
                           <h4>Reply to Enquiry</h4>
                        </div>
                        <div class="modal-body">
                           <form id="" method="post" action="">
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
               </div>
               <!--  modal popup end here -->
               */ ?>
         
      </tr>
      @endif
      @endforeach

      </tbody>
</table>
                           