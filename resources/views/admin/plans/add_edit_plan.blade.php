@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h4 class="card-title">Plans</h4>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <!-- <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> -->
                                <!-- <i class="mdi mdi-calendar"></i> Today (<?php echo date('d.m.y');?>) -->
                                <!-- </button> -->
                                <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">{{ $title }}</h4>
                  @if(Session::has('error_message'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong> </strong> {{ Session::get('error_message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  @endif

                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success: </strong> {{ Session::get('success_message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif

                  @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif
                  
                  <form class="forms-sample" @if(empty($plan['id'])) action="{{ url('admin/add-edit-plan') }}" @else action="{{ url('admin/add-edit-plan/'.$plan['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label for="name">Plan Name</label>
                      <input type="text" class="form-control" id="name" placeholder="Enter Plan Name" name="name" @if(!empty($plan['name'])) value="{{ $plan['name'] }}" @else value="{{ old('name') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="price">Plan Price</label>
                      <input type="text" class="form-control" id="price" placeholder="Enter Plan Price" name="price" @if(!empty($plan['price'])) value="{{ $plan['price'] }}" @elseif(!empty(old('price'))) value="{{ old('price') }}" @else value="0" @endif>
                    </div>
                    <div class="form-group">
                      <label for="short_description">Short Description</label>
                      <input type="text" class="form-control" id="short_description" placeholder="Enter Short Description" name="short_description" @if(!empty($plan['short_description'])) value="{{ $plan['short_description'] }}" @else value="{{ old('responses_limit') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="admin_image">Plan Image (120x120)</label>
                      <input type="file" class="form-control" id="plan_image" name="plan_image">
                      @if(!empty($plan['image']))
                        <a target="_blank" href="{{ url('front/images/plan_images/'.$plan['image']) }}">Vis bilde</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" module="plan-image" moduleid="{{ $plan['id'] }}">Slett bilde</a>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="responses_limit">Responses Limit</label>
                      <input type="text" class="form-control" id="responses_limit" placeholder="Enter Responses Limit" name="responses_limit" @if(!empty($plan['responses_limit'])) value="{{ $plan['responses_limit'] }}" @elseif(!empty(old('responses_limit'))) value="{{ old('responses_limit') }}" @else value="0" @endif>
                    </div>
                    <div class="form-group">
                      <label for="products_limit">Profiles Limit</label>
                      <input type="text" class="form-control" id="products_limit" placeholder="Enter Profiles Limit" name="products_limit" @if(!empty($plan['products_limit'])) value="{{ $plan['products_limit'] }}" @else value="{{ old('products_limit') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="description">Plan Description</label>
                      <textarea name="description" id="editor" class="form-control" rows="3">@if(!empty($plan['description'])) {{ $plan['description'] }} @else {{ old('description') }} @endif</textarea>
                    </div>
                    <div class="form-group">
                      <label for="features">Plan Features</label>
                      <textarea name="features" id="editor1" class="form-control" rows="3">@if(!empty($plan['features'])) {{ $plan['features'] }} @else {{ old('features') }} @endif</textarea>
                    </div>
                    <div class="form-group">
                      <label for="is_popular">Popular Plan</label>
                      <input type="checkbox" name="is_popular" id="is_popular" value="Yes" @if(!empty($plan['is_popular']) && $plan['is_popular']=="Yes") checked="" @endif>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <?php /* <button type="reset" class="btn btn-light">Avbryt</button> */ ?>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection