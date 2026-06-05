<?php
  use App\Models\Category;
 $getCategoryName = Category::getCategoryName($vendorDetails['vendor_personal']['category_id']);
?>
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Vendor Details</h3>
                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/admins/vendor') }}">Back to Vendors</a></h6>
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
                  <h4 class="card-title">Personal Information</h4>

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

                    <form class="forms-sample" action="{{ url('admin/view-vendor-details/'.$admin_id) }}" method="post" enctype="multipart/form-data">@csrf
                      <input type="hidden" name="vendor_id" value="{{ $vendorDetails['vendor_personal']['id'] }}">
                    <div class="form-group">
                      <label>Vendor Username/Email</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label>Category</label>
                      <input class="form-control" value="{{ $getCategoryName }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label>Plan</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_personal']['plan']['name'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_name">Name</label>
                      <input type="text" class="form-control" id="vendor_name" placeholder="Enter Name" name="vendor_name" value="{{ $vendorDetails['vendor_personal']['name'] }}">
                    </div>
                    <div class="form-group">
                      <label for="company_name">Company Name</label>
                      <input type="text" class="form-control" id="company_name" placeholder="Enter Company Name" name="company_name" value="{{ $vendorDetails['vendor_personal']['company_name'] }}">
                    </div>
                    <div class="form-group">
                      <label for="organisation_number">Organisation Number</label>
                      <input type="text" class="form-control" id="organisation_number" placeholder="Enter Organisation Number" name="organisation_number" value="{{ $vendorDetails['vendor_personal']['organisation_number'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_address">Address</label>
                      <input type="text" class="form-control" id="vendor_address" placeholder="Enter Address" name="vendor_address" value="{{ $vendorDetails['vendor_personal']['address'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_city">City</label>
                      <input type="text" class="form-control" id="vendor_city" placeholder="Enter City" name="vendor_city" value="{{ $vendorDetails['vendor_personal']['city'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_state">State</label>
                      <input type="text" class="form-control" id="vendor_state" placeholder="Enter State" name="vendor_state" value="{{ $vendorDetails['vendor_personal']['state'] }}">
                    </div>
                    <!-- <div class="form-group">
                      <label for="vendor_country">Country</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['country'] }}" readonly="">
                    </div> -->
                    <div class="form-group">
                      <label for="vendor_pincode">Pincode</label>
                      <input type="text" class="form-control" id="vendor_pincode" placeholder="Enter Pincode" name="vendor_pincode" value="{{ $vendorDetails['vendor_personal']['pincode'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_radius">Radius</label>
                      <input type="text" class="form-control" id="vendor_radius" placeholder="Enter Radius" name="vendor_radius" value="{{ $vendorDetails['vendor_personal']['radius'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_mobile">Mobile</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['mobile'] }}" readonly="">
                    </div>
                    <!-- <div class="form-group">
                      <label for="birth_date">Date Of Birth</label>
                      <input type="text" class="form-control" id="birth_date" placeholder="Enter Date Of Birth" name="birth_date" value="{{ $vendorDetails['vendor_personal']['birth_date'] }}">
                    </div> -->
                    <!-- <div class="form-group">
                      <label for="gender">Gender</label>
                      <select class="form-control" id="gender" name="gender"  style="color: #495057;">
                        <option value="">Select Gender</option>
                          <option value="Male" @if($vendorDetails['vendor_personal']['gender']=="Male") selected @endif>Male</option>
                          <option value="Female" @if($vendorDetails['vendor_personal']['gender']=="Female") selected @endif>Female</option>
                      </select>
                    </div> -->
                    <div class="form-group">
                      <label for="instagram">Instagram</label>
                      <input type="text" class="form-control" id="instagram" placeholder="Enter Instagram Link" name="instagram" value="{{ $vendorDetails['vendor_personal']['instagram'] }}">
                    </div>
                    <div class="form-group">
                      <label for="facebook">Facebook</label>
                      <input type="text" class="form-control" id="facebook" placeholder="Enter Facebook Link" name="facebook" value="{{ $vendorDetails['vendor_personal']['facebook'] }}">
                    </div>
                    <div class="form-group">
                      <label for="tiktok">Tik-tok</label>
                      <input type="text" class="form-control" id="tiktok" placeholder="Enter Tik-tok Link" name="tiktok" value="{{ $vendorDetails['vendor_personal']['tiktok'] }}">
                    </div>
                    <div class="form-group">
                      <label for="youtube">Youtube</label>
                      <input type="text" class="form-control" id="youtube" placeholder="Enter Youtube Link" name="youtube" value="{{ $vendorDetails['vendor_personal']['youtube'] }}">
                    </div>
                    <div class="form-group">
                      <label for="website">Website</label>
                      <input type="text" class="form-control" id="website" placeholder="Enter Website Link" name="website" value="{{ $vendorDetails['vendor_personal']['website'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_image">Photo</label>
                      <input type="file" class="form-control" id="vendor_image" name="vendor_image">
                      @if(!empty($vendorDetails['image']))
                        <a target="_blank" href="{{ url('admin/images/photos/'.$vendorDetails['image']) }}">Vis bilde</a>
                        <input type="hidden" name="current_vendor_image" value="{{ Auth::guard('admin')->user()->image }}">
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                    </form>
                </div>
              </div>
            </div>
            
            <?php /*
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Business Information</h4>
                  
                    
                    <div class="form-group">
                      <label for="vendor_name">Shop Name</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['shop_name'])) value="{{ $vendorDetails['vendor_business']['shop_name'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_address">Shop Address</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['shop_address'])) value="{{ $vendorDetails['vendor_business']['shop_address'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_city">Shop City</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['shop_city'])) value="{{ $vendorDetails['vendor_business']['shop_city'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_state">Shop State</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['shop_state'])) value="{{ $vendorDetails['vendor_business']['shop_state'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_country">Shop Country</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['shop_country'])) value="{{ $vendorDetails['vendor_business']['shop_country'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_pincode">Shop Pincode</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['shop_pincode'])) value="{{ $vendorDetails['vendor_business']['shop_pincode'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_mobile">Shop Mobile</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['shop_mobile'])) value="{{ $vendorDetails['vendor_business']['shop_mobile'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Shop Website</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['shop_website'])) value="{{ $vendorDetails['vendor_business']['shop_website'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Shop Email</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['shop_email'])) value="{{ $vendorDetails['vendor_business']['shop_email'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Business License Number</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['business_license_number'])) value="{{ $vendorDetails['vendor_business']['business_license_number'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>GST Number</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['gst_number'])) value="{{ $vendorDetails['vendor_business']['gst_number'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Pan Number</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['pan_number'])) value="{{ $vendorDetails['vendor_business']['pan_number'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Address Proof</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['address_proof'])) value="{{ $vendorDetails['vendor_business']['address_proof'] }}" @endif readonly="">
                    </div>
                    @if(!empty($vendorDetails['vendor_business']['address_proof_image']))
                    <div class="form-group">
                      <label for="vendor_image">Photo</label>
                      <br><img style="width: 200px;" src="{{ url('admin/images/proofs/'.$vendorDetails['vendor_business']['address_proof_image']) }}">
                    </div>
                   @endif
                   
                </div>
              </div>
            </div>
            */ ?>

            <?php /*
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Bank Information</h4>
                  
                    <div class="form-group">
                      <label>Account Holder Name</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_bank']['account_holder_name'])) value="{{ $vendorDetails['vendor_bank']['account_holder_name'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_name">Bank Name</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_bank']['account_holder_name'])) value="{{ $vendorDetails['vendor_bank']['bank_name'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_address">Account Number</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_bank']['account_holder_name'])) value="{{ $vendorDetails['vendor_bank']['account_number'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_city">IFSC Code</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_bank']['account_holder_name'])) value="{{ $vendorDetails['vendor_bank']['bank_ifsc_code'] }}" @endif readonly="">
                    </div>
                </div>
              </div>
            </div>
            */ ?>
          </div>
        
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection