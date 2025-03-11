@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 mb-0 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <!-- <h3 class="font-weight-bold">Settings</h3> -->
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
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 style="text-transform: none;" class="card-title">Bytt passord</h4>
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
                  
                  <form class="forms-sample" action="{{ url('admin/update-admin-password') }}" method="post">@csrf
                    <div class="form-group">
                      <label>Epost/brukernavn</label>
                      <input class="form-control" value="{{ $adminDetails['email'] }}" readonly="">
                    </div>
                   <!--  <div class="form-group">
                      <label>Admin Type</label>
                      <input class="form-control" value="{{ $adminDetails['type'] }}" readonly="">
                    </div> -->
                    <div class="form-group eye-password-area">
                      <label for="current_password">Nåværende passord</label>
                      <input type="password" class="form-control eyepassword" id="current_password" placeholder="Tast inn nåværende passord" name="current_password" required="">
                      <span id="check_password"></span>
                      <span toggle=".eyepassword" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <div class="form-group eye-password-area">
                      <label for="new_password">Nytt passord</label>
                      <input type="password" class="form-control eye-password-update" id="new_password" placeholder="Tast inn nytt passord" name="new_password" required="">
                      <span toggle=".eye-password-update" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>
                    <div class="form-group eye-password-area">
                      <label for="confirm_password">Bekreft passord</label>
                      <input type="password" class="form-control eyepasswordthree" id="confirm_password" placeholder="Bekreft passord" name="confirm_password" required="">
                      <span toggle=".eyepasswordthree" class="fa fa-fw fa-eye field-icon toggle-password-three"></span>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Lagre</button>
                    <?php /* <button type="reset" class="btn btn-light">Avbryt</button> */ ?>
                     <a href="{{ url('/admin/dashboard')}}" class="btn btn-primary mr-2">
                     Avbryt 
                     </a>
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