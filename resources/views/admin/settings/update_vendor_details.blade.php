<?php
  use App\Models\Category;
 $getCategoryName = Category::getCategoryName($vendorDetails['category_id']);
?>
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 div-mobile-margin mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Konto-informasjon </h3>
                        <!-- <h6 class="font-weight-normal mb-0">Update Admin Password</h6> -->
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
        @if($slug=="personal")
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 style="text-transform: none;" class="card-title">Rediger leverandør-opplysninger</h4>
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
                  
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}" method="post" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Brukernavn (Epost)</label>
                      <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label>Kategori</label>
                      <input class="form-control" value="{{ $getCategoryName }}" readonly="">
                    </div>
                    <div class="form-group">
                      <?php $code = base64_encode(Auth::guard('admin')->user()->email); ?>
                      <label>Pakke (<a class="admin-p-link" href="{{ url('admin/vendor/plans/upgrade/'.$code) }}">(oppgrader)</a>)</label>
                      <input class="form-control" value="{{ $vendorDetails['plan']['name'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_name">Navn</label>
                      <input type="text" class="form-control" id="vendor_name" placeholder="Tast inn navn" name="vendor_name" value="{{ Auth::guard('admin')->user()->name }}">
                    </div>
                    <div class="form-group">
                      <label for="company_name">Bedriftens navn</label>
                      <input type="text" class="form-control" id="company_name" placeholder="Tast inn bedriftens navn" name="company_name" value="{{ $vendorDetails['company_name'] }}">
                    </div>
                    <div class="form-group">
                      <label for="organisation_number">Organisasjonsnummer</label>
                      <input type="text" class="form-control" id="organisation_number" placeholder="Tast inn organisasjonsnummer" name="organisation_number" value="{{ $vendorDetails['organisation_number'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_address">Adresse</label>
                      <input type="text" class="form-control" id="vendor_address" placeholder="Tast inn adresse" name="vendor_address" value="{{ $vendorDetails['address'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_pincode">Postnummer</label>
                      <input type="text" class="form-control" id="norway_pincodes" placeholder="Tast inn postnummer" name="vendor_pincode" value="{{ $vendorDetails['pincode'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_city">Poststed</label>
                      <!-- <input type="text" class="form-control" id="vendor_city" placeholder="Tast inn poststed" name="vendor_city" value="{{ $vendorDetails['city'] }}"> -->
                      <select name="vendor_city" id="load_city" class="form-control text-dark" required>
                          <option value="">Velg poststed</option>
                          @foreach($cities as $city)
                             <option @if(!empty($vendorDetails['city'])&&$vendorDetails['city']==$city) selected @elseif(!empty($vendorDetails['city'])&&old('city')==$city) selected @endif value="{{ $city }}">{{ $city }}</option>
                          @endforeach
                          <!-- <option value="India">India</option> -->
                       </select> 
                    </div>
                    <div class="form-group">
                      <label for="vendor_state">Fylke</label>
                      <!-- <input type="text" class="form-control" id="vendor_state" placeholder="Tast inn fylke" name="vendor_state" value="{{ $vendorDetails['state'] }}"> -->
                      <select name="vendor_state" id="load_state" class="form-control text-dark" required>
                          <option value="">Velg fylke</option>
                          @foreach($states as $state)
                             <option @if(!empty($vendorDetails['state'])&&$vendorDetails['state']==$state) selected @elseif(!empty($vendorDetails['state'])&&old('state')==$state) selected @endif value="{{ $state }}">{{ $state }}</option>
                          @endforeach
                          <!-- <option value="India">India</option> -->
                       </select> 
                    </div>
                    <!-- <div class="form-group">
                      <label for="vendor_country">Country</label>
                      <select class="form-control" id="vendor_country" name="vendor_country"  style="color: #495057;">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                          <option value="{{ $country['country_name'] }}" @if($country['country_name']==$vendorDetails['country']) selected @endif>{{ $country['country_name'] }}</option>
                        @endforeach
                      </select>
                    </div> -->
                    
                    <!-- <div class="form-group">
                      <label for="vendor_radius">Leveringsradius</label>
                      <input type="text" class="form-control" id="vendor_radius" placeholder="Tast inn leveringsradius" name="vendor_radius" value="{{ $vendorDetails['radius'] }}">
                    </div> -->
                    <div class="form-group">
                      <label for="vendor_mobile">Telefonnummer</label>
                      <input type="text" class="form-control" id="vendor_mobile" placeholder="Tast inn 8 to 10 Digit Mobile Number" name="vendor_mobile" value="{{ Auth::guard('admin')->user()->mobile }}" required="" readonly>
                    </div>
                    <!-- <div class="form-group">
                      <label for="birth_date">Date Of Birth</label>
                      <input type="text" class="form-control" id="birth_date" placeholder="Tast inn Date Of Birth" name="birth_date" value="{{ $vendorDetails['birth_date'] }}">
                    </div> -->
                    <!-- <div class="form-group">
                      <label for="gender">Gender</label>
                      <select class="form-control" id="gender" name="gender"  style="color: #495057;">
                        <option value="">Select Gender</option>
                          <option value="Male" @if($vendorDetails['gender']=="Male") selected @endif>Male</option>
                          <option value="Female" @if($vendorDetails['gender']=="Female") selected @endif>Female</option>
                      </select>
                    </div> -->
                    <div class="form-group">
                      <label for="instagram">Instagram</label>
                      <input type="text" class="form-control" id="instagram" placeholder="Tast inn Instagram-link" name="instagram" value="{{ $vendorDetails['instagram'] }}">
                    </div>
                    <div class="form-group">
                      <label for="facebook">Facebook</label>
                      <input type="text" class="form-control" id="facebook" placeholder="Tast inn Facebook-link" name="facebook" value="{{ $vendorDetails['facebook'] }}">
                    </div>
                    <div class="form-group">
                      <label for="tiktok">Tik-tok</label>
                      <input type="text" class="form-control" id="tiktok" placeholder="Tast inn Tik-tok-link" name="tiktok" value="{{ $vendorDetails['tiktok'] }}">
                    </div>
                    <div class="form-group">
                      <label for="youtube">Youtube</label>
                      <input type="text" class="form-control" id="youtube" placeholder="Tast inn Youtube-link" name="youtube" value="{{ $vendorDetails['youtube'] }}">
                    </div>
                    <div class="form-group">
                      <label for="website">Nettside</label>
                      <input type="text" class="form-control" id="website" placeholder="Tast inn Nettside Link" name="website" value="{{ $vendorDetails['website'] }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_image">Profilbilde (Anbefalt størrelse:  Maks 2 MB)</label>
                      <input type="file" class="form-control" id="vendor_image" name="vendor_image" accept="image/*">
                      @if(!empty(Auth::guard('admin')->user()->image))
                        <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}">Vis bilde</a>
                        <input type="hidden" name="current_vendor_image" value="{{ Auth::guard('admin')->user()->image }}">
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Fullfør</button>
                    <?php /* <button type="reset" class="btn btn-light">Avbryt</button> */ ?>
                     <a href="{{ url('/admin/dashboard')}}" class="btn btn-primary mr-2">
                     Avbryt 
                     </a>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        @elseif($slug=="business")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Business Information</h4>
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
                  
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}" method="post" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Vendor Username/Email</label>
                      <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="shop_name">Branch/Company Name</label>
                      <input type="text" class="form-control" id="shop_name" placeholder="Tast inn Branch/Company Name" name="shop_name" @if(isset($vendorDetails['shop_name'])) value="{{ $vendorDetails['shop_name'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="shop_address">Branch/Company Address</label>
                      <input type="text" class="form-control" id="shop_address" placeholder="Tast inn Branch/Company Address" name="shop_address" @if(isset($vendorDetails['shop_address'])) value="{{ $vendorDetails['shop_address'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="shop_city">Branch/Company City</label>
                      <input type="text" class="form-control" id="shop_city" placeholder="Tast inn Branch/Company City" name="shop_city" @if(isset($vendorDetails['shop_city'])) value="{{ $vendorDetails['shop_city'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="shop_state">Branch/Company State</label>
                      <input type="text" class="form-control" id="shop_state" placeholder="Tast inn Branch/Company State" name="shop_state" @if(isset($vendorDetails['shop_state'])) value="{{ $vendorDetails['shop_state'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="shop_country">Branch/Company Country</label>
                      <select class="form-control" id="shop_country" name="shop_country" style="color: #495057;">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                          <option value="{{ $country['country_name'] }}" @if(isset($vendorDetails['shop_country']) && $country['country_name']==$vendorDetails['shop_country']) selected @endif>{{ $country['country_name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="shop_pincode">Branch/Company Pincode</label>
                      <input type="text" class="form-control" id="shop_pincode" placeholder="Tast inn Branch/Company Pincode" name="shop_pincode" @if(isset($vendorDetails['shop_pincode'])) value="{{ $vendorDetails['shop_pincode'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="shop_mobile">Branch/Company Mobile</label>
                      <input type="text" class="form-control" id="shop_mobile" placeholder="Tast inn Mobile Number" name="shop_mobile" @if(isset($vendorDetails['shop_mobile'])) value="{{ $vendorDetails['shop_mobile'] }}" @endif required="" maxlength="12" minlength="8">
                    </div>
                    <div class="form-group">
                      <label for="business_license_number">Business License Number</label>
                      <input type="text" class="form-control" id="business_license_number" placeholder="Tast inn Business License Number" name="business_license_number" @if(isset($vendorDetails['business_license_number'])) value="{{ $vendorDetails['business_license_number'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="gst_number">GST Number</label>
                      <input type="text" class="form-control" id="gst_number" placeholder="Tast inn GST Number" name="gst_number" @if(isset($vendorDetails['gst_number'])) value="{{ $vendorDetails['gst_number'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="pan_number">PAN Number</label>
                      <input type="text" class="form-control" id="pan_number" placeholder="Tast inn PAN Number" name="pan_number" @if(isset($vendorDetails['pan_number'])) value="{{ $vendorDetails['pan_number'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="address_proof">Address Proof</label>
                      <select class="form-control" name="address_proof" id="address_proof">
                        <option value="Passport" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Passport") selected @endif>Passport</option>
                        <option value="Voting Card" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Voting Card") selected @endif>Voting Card</option>
                        <option value="PAN" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="PAN") selected @endif>PAN</option>
                        <option value="Driving License" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Driving License") selected @endif>Driving License</option>
                        <option value="Aadhar card" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Aadhar Card") selected @endif>Aadhar Card</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="address_proof_image">Address Proof Image</label>
                      <input type="file" class="form-control" id="address_proof_image" name="address_proof_image">
                      @if(!empty($vendorDetails['address_proof_image']))
                        <a target="_blank" href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}">View Image</a>
                        <input type="hidden" name="current_address_proof" value="{{ $vendorDetails['address_proof_image'] }}">
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <?php /* <button type="reset" class="btn btn-light">Avbryt</button> */ ?>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        @elseif($slug=="bank")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Bank Information</h4>
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
                  
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}" method="post" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Vendor Username/Email</label>
                      <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="account_holder_name">Account Holder Name</label>
                      <input type="text" class="form-control" id="account_holder_name" placeholder="Tast inn Account Holder Name" name="account_holder_name" @if(isset($vendorDetails['account_holder_name'])) value="{{ $vendorDetails['account_holder_name'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="bank_name">Bank Name</label>
                      <input type="text" class="form-control" id="bank_name" placeholder="Tast inn Bank Name" name="bank_name" @if(isset($vendorDetails['account_holder_name'])) value="{{ $vendorDetails['bank_name'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="account_number">Account Number</label>
                      <input type="text" class="form-control" id="account_number" placeholder="Tast inn Account Number" name="account_number" @if(isset($vendorDetails['account_holder_name'])) value="{{ $vendorDetails['account_number'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="bank_ifsc_code">Bank IFSC Code</label>
                      <input type="text" class="form-control" id="bank_ifsc_code" placeholder="Tast inn Bank IFSC Code" name="bank_ifsc_code" @if(isset($vendorDetails['account_holder_name'])) value="{{ $vendorDetails['bank_ifsc_code'] }}" @endif>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <?php /* <button type="reset" class="btn btn-light">Avbryt</button> */ ?>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        @endif
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection