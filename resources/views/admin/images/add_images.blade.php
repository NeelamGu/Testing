@extends('admin.layout.layout')
@section('content')
<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css"> 
<style>
ul { 
  list-style: none;
  margin: 5px 20px;
}
li {
  margin: 10px 0;
}
  input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 103px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}
.bootstrap-tagsinput {
  white-space: nowrap;
  width: 100%;
  overflow: scroll;
}

/* Bootstrap for tags */

.label {
    display: inline;
    padding: 0.2em 0.6em 0.3em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25em;
}
a.label:focus,
a.label:hover {
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}
.label:empty {
    display: none;
}
.btn .label {
    position: relative;
    top: -1px;
}
.label-default {
    background-color: #777;
}
.label-default[href]:focus,
.label-default[href]:hover {
    background-color: #5e5e5e;
}
.label-primary {
    background-color: #337ab7;
}
.label-primary[href]:focus,
.label-primary[href]:hover {
    background-color: #286090;
}
.label-success {
    background-color: #5cb85c;
}
.label-success[href]:focus,
.label-success[href]:hover {
    background-color: #449d44;
}
.label-info {
    background-color: #5bc0de;
}
.label-info[href]:focus,
.label-info[href]:hover {
    background-color: #31b0d5;
}
.label-warning {
    background-color: #f0ad4e;
}
.label-warning[href]:focus,
.label-warning[href]:hover {
    background-color: #ec971f;
}
.label-danger {
    background-color: #d9534f;
}
.label-danger[href]:focus,
.label-danger[href]:hover {
    background-color: #c9302c;
}

.hovedbilde-text b
{
  font-weight: 500;
  font-style:italic;
  color:#e46f01;
  font-size:13px;
} 
.orangeDim{
    color: #e46f01;
}
input {
    margin-bottom: 10px;
}
@media only screen and (max-width: 767px) {
    .hovedbilde-text b{
        display: none;
    }}
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-2 mb-xl-0">
                        <h4 class="card-title">Galleri</h4>
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
                  <h4 class="card-title" style="margin-bottom: 7px;">Legg til bilder for {{ $product['product_name'] }}</h4>
                  <p  style="color:rgb(112, 112, 112); margin-bottom: 5px;font-size:12px;">Bilder skal ikke inneholde kontaktinformasjon.</p>
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
                  
                  <form class="forms-sample" action="{{ url('admin/add-images/'.$product['id']) }}" method="post" enctype="multipart/form-data">@csrf
                    
                  
                    <div class="form-group">
                      <label for="product_banner">Banner-bilde (Anbefalt størrelse: 1900x400)</label>
                      <input type="file" class="form-control" id="product_banner" name="product_banner" accept="image/*">
                      @if(!empty($product['product_banner']))
                        <a target="_blank" href="{{ url('front/images/product_banners/'.$product['product_banner']) }}">Se Banner-bilde</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" module="product-banner" moduleid="{{ $product['id'] }}">Slett Banner-bilde</a>
                        <input type="hidden" name="current_product_banner" value="{{ $product['product_banner'] }}">
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="product_image">Hovedbilde</label>
                      <!-- <label for="product_image">Hovedbilde (Anbefalt størrelse: 1000*500). Maks 2 MB</label> -->
                      
                      <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
                      @if(!empty($product['product_image']))
                        <a target="_blank" href="{{ url('front/images/product_images/large/'.$product['product_image']) }}">Vis bilde</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" module="product-image" moduleid="{{ $product['id'] }}">Slett bilde</a>
                        <input type="hidden" name="current_product_image" value="{{ $product['product_image'] }}">
                      @endif
                    </div>
                    <div class="form-group">
                      <!-- <label for="images">Bilde-galleri (Anbefalt størrelse: 1000*500). Maks 2 MB</label> -->
                      <label for="images">Bilde-galleri <span class="orangeDim">(Maks 10MB pr opplastning)</span></label>
                      <p class="hovedbilde-text"><b>For å legge til flere bilder i galleriet, trykk på “velg filer”, dermed hold inne CTRL tasten samtidig som du trykker på alle bildene du ønsker å legge til. Tilslutt trykk på “åpne” for å legge til bildene</b></p>
                      <input multiple type="file" class="form-control" id="files" name="images[]" accept="image/*">
                      
                    </div><br>
                    <button type="submit" class="btn btn-primary mr-2 scroll-to-captions" style="margin:-15px 0 20px 0;">Legg til bildetekster</button><br>

                    @if(count($product['images'])>0)
                    <div id="image-captions" class="form-group" style="width: 100%; display: inline-block;">
                      @foreach($product['images'] as $image)
                        <span style="float:left; width:110px; padding: 5px; margin: 5px;">
                          <a target="_blank" href="{{ url('front/images/product_images/large/'.$image['image']) }}"><img style="width:100px;" src="{{ url('front/images/product_images/small/'.$image['image']) }}"></a><br>
                          <input type="hidden" name="image[]" value="{{ $image['image'] }}">
                          <input style="width:100px;" type="text" placeholder="Bildetekst" name="title[]" value="{{ $image['title'] }}"><br>
                          <a href="javascript:void(0)" class="confirmDelete" module="image" moduleid="{{ $image['id'] }}">Slett</a>
                        </span>
                      @endforeach
                    </div>
                    @endif

                    <!-- <button type="submit" class="btn btn-primary mr-2" style="margin-top:-15px;">Legg til bildetekster</button><br><br> -->
                    <div class="form-group">
                      <!-- <label for="product_video" style="float:left;">Video-galleri (Anbefalt størrelse:  Maks 5 MB)</label> -->
                      <label for="product_video" style="float:left;">Video-galleri  <span class="orangeDim">(Maks 5MB)</span></label>
                      <input type="file" class="form-control" id="product_video" name="product_video" accept="video/*">
                      @if(!empty($product['product_video']))
                      <a target="_blank" href="{{ url('front/videos/product_videos/'.$product['product_video']) }}">View Video</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" module="product-video" moduleid="{{ $product['id'] }}">Delete Video</a>
                      @endif
                    </div>
                   
                    <button type="submit" class="btn btn-primary mr-2">Lagre</button>
                    <?php /* <button type="reset" class="btn btn-light">Avbryt</button> */ ?>
                    <a href="{{ url('/admin/products')}}" class="btn btn-primary mr-2">
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