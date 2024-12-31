<?php use App\Models\Product; ?>
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ratings/Reviews</h4>
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <!-- <a style="max-width: 150px; float: right; display: inline-block;" href="{{ url('admin/add-edit-section') }}" class="btn btn-block btn-primary">Add Section</a> -->
                        @if(Session::has('success_message'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table id="ratings" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>User</th>
                                        <th>Review</th>
                                        <th>Star Rating</th>
                                        <th>Image</th>
                                        <th>Added on</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($ratings as $rating)
                                    <tr>
                                    <td>
                                      <?php $getProductURL = Product::productURL($rating['product']['product_name']); ?>
                                    <a target="_blank" href="{{ url('product/'.$getProductURL.'/'.$rating['product']['id']) }}">{{ $rating['product']['product_name'] }}</a>
                                  </td>
                                    <td>{{ $rating['user']['name'] }}<br>
                                    {{ $rating['user']['email'] }}</td>
                                    <td><strong>{{ $rating['review_title'] }}</strong><br>
                                      {{ $rating['review_description'] }}

                                    </td>
                                    <td>{{ $rating['star_rating'] }}</td>
                                    <td>
                                        @if(isset($rating['image']) && $rating['image']!="")
                                            <a target="_blank" href="{{ url('images/reviews_images/'.$rating['image']) }}"><img src="{{ url('front/images/reviews_images/'.$rating['image']) }}"></a>
                                        @endif
                                    </td>
                                    <td>{{ date("d.m.y, H:i", strtotime($rating['created_at'])); }}</td>
                                    <td>
                                          @if($rating['status']==1)
                                              <a class="updateRatingStatus" id="rating-{{ $rating['id'] }}" rating_id="{{ $rating['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>
                                            @else
                                              <a class="updateRatingStatus" id="rating-{{ $rating['id'] }}" rating_id="{{ $rating['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="confirmDelete" module="rating" moduleid="{{ $rating['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
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