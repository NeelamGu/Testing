<?php $messagesCountVendor = messagesCountVendor(); ?>
@extends('admin.layout.layout')
@section('content')
<style>
    .profile-img {
        width: 100%;
        max-width: 40px;
        margin-bottom: 10px;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4">
                        <h3 class="font-weight-bold">Velkommen {{ Auth::guard('admin')->user()->name }}</h3>

                        @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @elseif(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong></strong> {{ Session::get('error_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @else
                        <h6 class="font-weight-normal mb-0">Alle systemer virker knirkefritt!</h6>
                        @endif
                    </div>
                    <div class="col-12 col-xl-4  ">
                        <div class="justify-content-end dashboard-date-area d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <!-- <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> -->
                                <!-- <i class="mdi mdi-calendar"></i> Idag (
                                <?php echo date('d.m.y');?>) -->
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

        @if(Auth::guard('admin')->user()->type=="vendor")
        <div class="row">
            <div class="col-md-12 grid-margin transparent">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12  mb-4 stretch-card transparent order-md-0 order-1">
                        <div class="card card-tale text-center">
                            <a style="color:#fff; text-decoration: none;" href="{{ url('admin/products') }}">
                                <div class="card-body">
                                    <img class="profile-img" src="{{ asset('admin/images/cv.png') }}" alt=""
                                        class="banner">
                                    <p style="font-weight:bold;" class="mb-2">Mine annonser</p>
                                    <p class="fs-30 mb-2">{{ $productsCount }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12  mb-4 stretch-card transparent order-md-1 order-2">
                        <div class="card card-dark-blue text-center">
                            <a style="color:#fff; text-decoration: none;" href="{{ url('admin/products-enquiries') }}">
                                <div class="card-body">
                                    <img class="profile-img" src="{{ asset('admin/images/help.png') }}" alt=""
                                        class="banner">
                                    <p style="font-weight:bold;" class="mb-2">Oppdrag og meldinger</p>
                                    <p class="fs-30 mb-2">{{ $messagesCountVendor }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12  mb-4 stretch-card  transparent order-md-2 order-3">
                        <div class="card card-dark-blue text-center">
                            <a style="color:#fff; text-decoration: none;"
                                href="{{ url('admin/update-vendor-details/personal') }}">
                                <div class="card-body">
                                    <img class="profile-img" src="{{ asset('admin/images/user.png') }}" alt=""
                                        class="banner">
                                    <p style="font-weight:bold;" class="mb-2">Min Konto</p>
                                    <p class="fs-30 mb-2">&nbsp;</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12  mb-4 stretch-card transparent order-md-3 order-0">
                        <div class="card card-dark-blue text-center">
                            <a style="color:#fff; text-decoration: none;" href="{{ url('admin/add-edit-product') }}">
                                <div class="card-body">
                                    <img class="profile-img" src="{{ asset('admin/images/plus.png') }}" alt=""
                                        class="banner">
                                    <p style="font-weight:bold;" class="mb-2">Lag ny annonse</p>
                                    <p class="fs-30 mb-2">&nbsp;</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-6 grid-margin transparent">
                <div class="row">
                  
                </div>
            </div> -->
        </div>
        @else
        <div class="row">
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">

                                <p class="mb-4">Total Sections</p>
                                <p class="fs-30 mb-2">{{ $sectionsCount }}</p>
                                <!-- <p>10.00% (30 days)</p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Profiles</p>
                                <p class="fs-30 mb-2">{{ $productsCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Categories</p>
                                <p class="fs-30 mb-2">{{ $categoriesCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Users</p>
                                <p class="fs-30 mb-2">{{ $usersCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Total Vendors</p>
                                <p class="fs-30 mb-2">{{ $vendorsCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Banners</p>
                                <p class="fs-30 mb-2">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">

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