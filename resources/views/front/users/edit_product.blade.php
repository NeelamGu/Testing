@extends('front.layout.layout')
@section('content')
@include('front.users.partials.topbar', ['activeTopTab' => 'profile'])
<div class="page-wrapper">
    <div class="contact-section account-page">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
                          @include('front.users.partials.sidebar', ['activeTab' => 'account'])
                </div>
                <!--Content Side-->
                <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
                    <div class="sec-title account-heading">
                        <h3 style="margin-bottom:15px;" class="font-20 text-black account-title">OPPDATERT ANNONSEDETALJER</h3>
                    </div>
                    <div class="form-box p-xs-15 account-form">
                        @if(Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                              <strong> </strong> {{ Session::get('error_message')}}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        @endif

                        @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                          <strong>Suksess: </strong> {{ Session::get('success_message')}}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Lukk">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        @endif

                        @if($errors->any())
                          <div class="alert alert-danger alert-dismissible fade in" role="alert">
                          @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                          <button type="button" class="close" data-dismiss="alert" aria-label="Lukk">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        @endif
                        <form action="{{ url('user/edit-product/'.$product_id) }}" class="post-form-form" method="post" enctype="multipart/form-data">@csrf
                            <div class="row clearfix">
                                <!-- <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <div class="field-label">Brand</div>
                                    <select class="account-state" id="" name="" class="form-control valid" data-height="40px" required="">
                                        <option value="">One</option>
                                        <option value="">Two</option>
                                        <option value="">Three</option>
                                        <option value="">Four</option>
                                    </select>
                                </div> -->
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <div class="field-label">Tittel</div>
                                    <input type="text" name="product_name" placeholder="" required value="{{ $productDetails['product_name'] }}">
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <div class="field-label">Beskrivelse</div>
                                    <textarea style="height:70px;" name="description" required>{{ $productDetails['description'] }}</textarea>
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <div class="field-label">Pris</div>
                                    <input type="number" name="product_price" placeholder="" required value="{{ $productDetails['product_price'] }}">
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <div class="field-label">Din by</div>
                                    <input type="text" name="city" placeholder="" required value="{{ $productDetails['city'] }}">
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <div class="field-label">Mobilnummer</div>
                                    <input type="number" value="{{ Auth::user()->mobile }}" readonly style="background-color:#f2f2f2" >
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12 ">
                                    <button class="save-btn" type="submit" name="submit-form">
                                    Oppdater nå</button>
                                </div>
                            </div>
                        </form>
                        @include('front.users.view_products')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection