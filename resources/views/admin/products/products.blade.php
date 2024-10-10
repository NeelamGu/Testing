<?php use App\Models\Product; ?>
@extends('admin.layout.layout')
@section('content')
<style>
    tfoot {
        display: table-header-group;
    }
    .prosearch th input{
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
    <div class="content-wrapper profile-wrappper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Mine annonser</h4>
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <a style="max-width: 150px; float: right; display: inline-block;" href="{{ url('admin/add-edit-product') }}" class="btn btn-block profile-btn-area btn-primary">Lag ny annonse</a>
                        @if(Session::has('success_message'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table id="products" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            Endre annonse
            
                                        </th>
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <th>
                                            ID
                                        </th>
                                        @endif
                                        <th style="width:12%;">
                                            Annonse
                                        </th>
                                        <!-- <th>
                                            Item Code
                                        </th> -->
                                        <th>
                                            Hovedbilde
                                        </th>
                                        <th>
                                            Kategori
                                        </th>
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <th>
                                            Plassering
                                        </th>
                                        @endif
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <th>
                                            Lagt til av 
                                        </th>
                                        @endif
                                        <th>
                                            Lagt til
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot class="prosearch">
                                    <tr>
                                        <th class="hideColumn">
                                            Endre annonse
                                        </th>
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <th>
                                            ID
                                        </th>
                                        @endif
                                        <th style="width:12%;">
                                            Annonse
                                        </th>
                                        <!-- <th>
                                            Item Code
                                        </th> -->
                                        <th class="hideColumn">
                                            Hovedbilde
                                        </th>
                                        <th>
                                            Kategori
                                        </th>
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <th>
                                            Plassering
                                        </th>
                                        @endif
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <th>
                                            Lagt til av 
                                        </th>
                                        @endif
                                        <th class="hideColumn">
                                            Lagt til
                                        </th>
                                        <th class="hideColumn">
                                            Status
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                  @foreach($products as $product)
                                    
                                    <tr>
                                        <td class="actionOrder">
                                            <a title="Endre annonse" href="{{ url('admin/add-edit-product/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                                            <a title="Annonsebilder" href="{{ url('admin/add-images/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-library-plus"></i></a>
                                            <!-- <a title="Add Attributes" href="{{ url('admin/add-edit-attributes/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-plus-box"></i></a> -->
                                            
                                            <!-- <a title="Product" class="confirmDelete" href="{{ url('admin/delete-product/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a> -->
                                            <a title="Slett" href="javascript:void(0)" class="confirmDelete" module="product" moduleid="{{ $product['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
                                        </td>
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <td>
                                            {{ $product['id'] }}
                                        </td>
                                        @endif
                                        <td>
                                            <?php $getProductURL = Product::productURL($product['product_name']); ?>
                                            {{ $product['product_name'] }}<br><br>
                                            @if($product['status']==1)
                                                <a target="_blank" href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">Vis annonse </a>
                                            @else
                                                <a target="_blank" href="{{ url('product-review/'.$getProductURL.'/'.$product['id']) }}">Vis annonse</a>
                                            @endif
                                        </td>
                                        <!-- <td>
                                            {{ $product['product_code'] }}
                                        </td> -->
                                        <td>
                                            @if(!empty($product['product_image']))
                                                <img style="width: 120px; height: 120px;" src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}">
                                            @else
                                                <img style="width: 120px; height: 120px;" src="{{ asset('front/images/no-image.png') }}">
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($product['category']['category_name']))
                                                {{ $product['category']['category_name'] }}
                                            @endif
                                        </td> 
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <td>
                                            {{ $product['section']['name'] }}
                                        </td>  
                                        @endif 
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <td>
                                            @if($product['admin_type']=="vendor")
                                                {{ ucwords($product['vendor']['name']) }}<br><br>
                                                (<a target="_blank" href="{{ url('admin/view-vendor-details/'.$product['admin_id']) }}">{{ucfirst($product['admin_type'])}}</a>)
                                                
                                            @else
                                                {{ ucfirst($product['admin_type']) }}    
                                            @endif
                                        </td> 
                                        @endif 
                                        <td> {{ date("d.m.y, H:i", strtotime($product['created_at'])); }}</td>
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                            <td class="proActive">
                                                @if($product['status']==1)
                                                  <a class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a><span style="margin-top:0px !important;">Active</span>
                                                @else
                                                  <a class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a><span style="margin-top:0px !important;">Inactive</span>
                                                @endif
                                            </td>
                                        @else
                                            <td class="proActive">
                                                @if($product['status']==1)
                                                    <i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i>  
                                                @else
                                                    <i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i>
                                                @endif
                                            </td>
                                        @endif
                                    
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
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024. All rights reserved.</span>
        </div>
    </footer>
    <!-- partial -->
</div>
@endsection