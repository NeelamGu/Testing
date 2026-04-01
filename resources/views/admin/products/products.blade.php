<?php use App\Models\Product; ?>
@extends('admin.layout.layout')
@section('content')
<style>
    tfoot {
        display: table-header-group;
    }

    .prosearch th input {
        width: 100%;
    }

    .hideColumn input {
        display: none;
    }

    .proActive font {
        vertical-align: super !important;
        display: inline-flex;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper profile-wrappper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div @if(Auth::guard('admin')->user()->type=="vendor") class="card-body d-flex justify-content-between" @else class="card-body" @endif>
                        <h4 class="card-title">Mine annonser</h4>
                        <a style="max-width: 150px;" href="{{ url('admin/add-edit-product') }}"
                            class="btn btn-block profile-btn-area btn-primary">Lag ny annonse</a>
                        @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(Auth::guard('admin')->user()->type!="vendor")
                        <div class="table-responsive pt-3">
                            <table id="products" class="table table-bordered">
                                <thead>
                                    <tr>
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <th>
                                            ID
                                        </th>
                                        @endif
                                        <th style="width:12%;">
                                            Annonse
                                        </th>
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
                                        <th>
                                            Endre annonse
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot class="prosearch">
                                    <tr>
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <th>
                                            ID
                                        </th>
                                        @endif
                                        <th style="width:12%;">
                                            Annonse
                                        </th>
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
                                        <th class="hideColumn">
                                            Endre annonse
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($products as $product)

                                    <tr>
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <td>
                                            {{ $product['id'] }}
                                        </td>
                                        @endif
                                        <td>
                                            <?php $getProductURL = Product::productURL($product['product_name']); ?>
                                            {{ $product['product_name'] }}<br><br>
                                            @if($product['status']==1)
                                            <a class="btn btn-block profile-btn-area btn-primary" target="_blank"
                                                href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">Vis
                                                annonse </a>
                                            @else
                                            <a class="btn btn-block profile-btn-area btn-primary" target="_blank"
                                                href="{{ url('product-review/'.$getProductURL.'/'.$product['id']) }}">Vis
                                                annonse</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($product['product_image']))
                                            <img style="width: 120px; height: 120px;"
                                                src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}">
                                            @else
                                            <img style="width: 120px; height: 120px;"
                                                src="{{ asset('front/images/no-image.png') }}">
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
                                            (<a target="_blank"
                                                href="{{ url('admin/view-vendor-details/'.$product['admin_id']) }}">{{ucfirst($product['admin_type'])}}</a>)

                                            @else
                                            {{ ucfirst($product['admin_type']) }}
                                            @endif
                                        </td>
                                        @endif
                                        <td> {{ date("d.m.y, H:i", strtotime($product['created_at'])); }}</td>
                                        @if(Auth::guard('admin')->user()->type!="vendor")
                                        <td class="proActive">
                                            @if($product['status']==1)
                                            <a class="updateProductStatus" id="product-{{ $product['id'] }}"
                                                product_id="{{ $product['id'] }}" href="javascript:void(0)"><i
                                                    style="font-size:25px;" class="mdi mdi-bookmark-check"
                                                    status="Active"></i></a><span
                                                style="margin-top:0px !important;">Active</span>
                                            @else
                                            <a class="updateProductStatus" id="product-{{ $product['id'] }}"
                                                product_id="{{ $product['id'] }}" href="javascript:void(0)"><i
                                                    style="font-size:25px;" class="mdi mdi-bookmark-outline"
                                                    status="Inactive"></i></a><span
                                                style="margin-top:0px !important;">Inactive</span>
                                            @endif
                                        </td>
                                        @else
                                        <td class="proActive">
                                            @if($product['status']==1)
                                            <i style="font-size:25px;" class="mdi mdi-bookmark-check"
                                                status="Active"></i>
                                            @else
                                            <i style="font-size:25px;" class="mdi mdi-bookmark-outline"
                                                status="Inactive"></i>
                                            @endif
                                        </td>
                                        @endif
                                        <td class="actionOrder">
                                            <a title="Endre annonse"
                                                href="{{ url('admin/add-edit-product/'.$product['id']) }}"><i
                                                    style="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                                            <a title="Annonsebilder"
                                                href="{{ url('admin/add-images/'.$product['id']) }}"><i
                                                    style="font-size:25px;" class="mdi mdi-library-plus"></i></a>
                                            <!-- <a title="Add Attributes" href="{{ url('admin/add-edit-attributes/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-plus-box"></i></a> -->

                                            <!-- <a title="Product" class="confirmDelete" href="{{ url('admin/delete-product/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a> -->
                                            <a title="Slett" href="javascript:void(0)" class="confirmDelete"
                                                module="product" moduleid="{{ $product['id'] }}"><i
                                                    style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>


                    @if(Auth::guard('admin')->user()->type=="vendor")

                    <div class="userListGrid">
                        <div class="userGridInner">
                            <div class="row">
                                @foreach($products as $product)
                                <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-412">
                                    <div class="profileOuter">
                                        <div class="slab">
                                            <div class="slabOne">
                                                <?php $getProductURL = Product::productURL($product['product_name']); ?>
                                                <span class="miniHead">Annonse</span>
                                                <h5>{{ $product['product_name'] }}</h5>
                                                @if($product['status']==1)
                                                    <a class="btn btn-block profile-btn-area btn-primary" target="_blank"
                                                    href="{{ url('product/'.$getProductURL.'/'.$product['id']) }}">Vis annonse</a>
                                                @else
                                                    <a class="btn btn-block profile-btn-area btn-primary" target="_blank"
                                                    href="{{ url('product-review/'.$getProductURL.'/'.$product['id']) }}">Vis annonse</a>
                                                @endif    
                                            </div>
                                            <div class="slabImg">
                                                @if(!empty($product['product_image']))
                                                    <img src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}">
                                                @else
                                                    <img src="{{ asset('front/images/no-image.png') }}">
                                                @endif
                                            </div>
                                            <div class="slabEnd topper">
                                                <span class="miniHead">
                                                    Lagt til
                                                </span>
                                                <h5>{{ date("d.m.y", strtotime($product['created_at'])); }} <br>
                                                    {{ date("H:i", strtotime($product['created_at'])); }}</h5>
                                            </div>
                                        </div>
                                        <div class="slab">
                                            <div class="slabOne">
                                                <span class="miniHead">Kategori</span>
                                                <h5>@if(isset($product['category']['category_name']))
                                                        {{ $product['category']['category_name'] }}
                                                    @endif
                                                </h5>
                                            </div>
                                            <div class="slabEnd">
                                                <div class="iconWrap">
                                                    <span class="miniHead">
                                                        Status
                                                    </span>
                                                    @if($product['status']==1)
                                                    <i style="font-size:25px;" class="mdi mdi-bookmark-check"
                                                        status="Active"></i>
                                                    @else
                                                    <i style="font-size:25px;" class="mdi mdi-bookmark-outline"
                                                        status="Inactive"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="slab">
                                            <div class="slabOne">
                                                <h5>Endre Annonse</h5>
                                            </div>
                                            <div class="slabEnd">
                                                <div class="iconWrap">
                                                    <span class="miniHead">
                                                        Rediger
                                                    </span>
                                                    <a href="{{ url('admin/add-edit-product/'.$product['id']) }}" class="icon">
                                                        <img src="{{ asset('front/images/icons/edit.png')}}" alt="icon">
                                                    </a>
                                                </div>
                                                <div class="iconWrap">
                                                    <span class="miniHead">
                                                        Annonsebilder
                                                    </span>
                                                    <a href="{{ url('admin/add-images/'.$product['id']) }}" class="icon">
                                                        <img src="{{ asset('front/images/icons/imgAdd.png')}}" alt="icon">
                                                    </a>
                                                </div>
                                                <div class="iconWrap">
                                                    <span class="miniHead">
                                                        Slett
                                                    </span>
                                                    <a href="javascript:void(0)" class="icon confirmDelete" module="product" moduleid="{{ $product['id'] }}">
                                                        <img src="{{ asset('front/images/icons/cancel.png')}}" alt="icon">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @endif

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