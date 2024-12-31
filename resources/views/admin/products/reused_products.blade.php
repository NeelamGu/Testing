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
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Re-used Items</h4>
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <!-- <a style="max-width: 150px; float: right; display: inline-block;" href="{{ url('admin/add-edit-product') }}" class="btn btn-block btn-primary">Add Item</a> -->
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
                                            ID
                                        </th>
                                        <th>
                                            Title
                                        </th>
                                        <th>
                                            Item Code
                                        </th>
                                        <th>
                                            Image
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            Section
                                        </th>
                                        <th>
                                            Added by
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot class="prosearch">
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Title
                                        </th>
                                        <th>
                                            Item Code
                                        </th>
                                        <th class="hideColumn">
                                            Image
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            Section
                                        </th>
                                        <th>
                                            Added by
                                        </th>
                                        <th class="hideColumn">
                                            Status
                                        </th>
                                        <th class="hideColumn">
                                            Actions
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                  @foreach($products as $product)
                                    
                                    <tr>
                                        <td>
                                            {{ $product['id'] }}
                                        </td>
                                        <td>
                                            {{ $product['product_name'] }}
                                        </td>
                                        <td>
                                            {{ $product['product_code'] }}
                                        </td>
                                        <td>
                                            @if(!empty($product['product_image']))
                                                <img style="width: 120px; height: 120px;" src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}">
                                            @else
                                                <img style="width: 120px; height: 120px;" src="{{ asset('front/images/no-image.png') }}">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $product['category']['category_name'] }}
                                        </td> 
                                        <td>
                                            {{ $product['section']['name'] }}
                                        </td>  
                                        <td>
                                            @if($product['admin_type']=="vendor")
                                                <a target="_blank" href="{{ url('admin/view-vendor-details/'.$product['admin_id']) }}">{{ ucfirst($product['admin_type']) }}</a>
                                            @else
                                                {{ ucfirst($product['admin_type']) }}    
                                            @endif
                                        </td>  
                                        <td class="proActive">
                                            @if($product['status']==1)
                                              <a class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a></i></a><span style="margin-top:0px !important;">Active</span>
                                            @else
                                              <a class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a><span style="margin-top:0px !important;">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a title="Edit Product" href="{{ url('admin/add-edit-reused-product/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                                            <!-- <a title="Add Attributes" href="{{ url('admin/add-edit-attributes/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-plus-box"></i></a> -->
                                            <a title="Add Images" href="{{ url('admin/add-reused-images/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-library-plus"></i></a>
                                            <?php /* <a title="Product" class="confirmDelete" href="{{ url('admin/delete-product/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a> */ ?>
                                            <a href="javascript:void(0)" class="confirmDelete" module="product" moduleid="{{ $product['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
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