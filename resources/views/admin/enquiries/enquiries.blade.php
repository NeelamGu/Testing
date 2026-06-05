<?php 
use App\Models\Category; 
use App\Models\Product; 
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
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Enquiries</h4>
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
                        <div class="table-responsive pt-3">
                            <table id="all_enquiries" class="enquiries-table table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                         Dato
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            User Details
                                        </th>
                                        <!-- <th>
                                            City/Pincode
                                        </th> -->
                                        <th>
                                            Inspiration<br>Image
                                        </th>
                                        <th>
                                            Assignment<br>Details
                                        </th>
                                        <th>
                                            Enquiry<br>Details
                                        </th>
                                        <th>
                                            Enquiry<br>Type
                                        </th>
                                        <th>
                                            Assigned<br>Vendors
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($enquiries as $enquiry)
                                    <tr>
                                        <td>
                                            {{ $enquiry['id'] }}
                                        </td>
                                        <td>
                                            {{ date("d.m.y, H:i", strtotime($enquiry['created_at'])); }}
                                        </td>
                                        <td>
                                            @if($enquiry['category_id']>0)
                                                {{ $getCategoryName = Category::getCategoryName($enquiry['category_id']) }}
                                            @else
                                                Other
                                            @endif
                                        </td>
                                        <td style="line-height: 20px;">
                                            {{ $enquiry['name'] }}<br>
                                            <!-- {{ $enquiry['address'] }}, {{ $enquiry['city'] }}<br> -->
                                            {{ $enquiry['phone'] }}<br>
                                            {{ $enquiry['email'] }}
                                        </td>
                                        <!-- <td style="line-height: 20px;">
                                            {{ $enquiry['city'] }}<br>{{ $enquiry['pincode'] }}
                                        </td>  -->
                                        <td>
                                            @if(isset($enquiry['photo'])&&!empty($enquiry['photo']))
                                                <img src="{{ asset('front/images/photos/'.$enquiry['photo']) }}">
                                            @endif
                                        </td>        
                                        <td style="line-height: 20px;">
                                            Address: {{ $enquiry['address'] }}, {{ $enquiry['city'] }}-{{ $enquiry['pincode'] }}, {{ $enquiry['state'] }}<br>
                                            Date: {{ $enquiry['assignment_date'] }}<br>
                                            Desired Price: {{ $enquiry['desired_price'] }}
                                        </td>                         
                                        <td style="line-height: 20px;">
                                            <strong>{{ $enquiry['title'] }}</strong><br>
                                            {{ $enquiry['description'] }}
                                        </td>
                                        <td style="line-height: 20px;">
                                            @if($enquiry['address']!="")
                                                Oppdrag
                                            @else
                                                Direkte melding
                                            @endif
                                        </td>
                                        <td style="line-height: 20px;">
                                            @php 
                                                $enquiry['vendors'] = array_map("unserialize", array_unique(array_map("serialize", $enquiry['vendors'])))
                                            @endphp
                                            @if(count($enquiry['vendors'])>0)
                                                @foreach($enquiry['vendors'] as $vendor)
                                                @if(isset($vendor['admin']['id']))
                                                    
                                                    <a target="_blank" href="{{ url('admin/view-vendor-details/'.$vendor['admin']['id']) }}">{{ $vendor['vendor']['name']}}</a><br>
                                                    <a target="_blank" href="{{ url('admin/view-vendor-details/'.$vendor['admin']['id']) }}">{{ $vendor['vendor']['email']}}</a><br>
                                                    @if(isset($vendor['product']['product_name']))
                                                    @php $getProductURL = Product::productURL($vendor['product']['product_name']); @endphp
                                                    <a target="_blank" href="{{ url('product/'.$getProductURL.'/'.$vendor['product']['id']) }}">{{ $vendor['product']['product_name']}}</a>
                                                    <hr>
                                                    @endif
                                                @endif
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>

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