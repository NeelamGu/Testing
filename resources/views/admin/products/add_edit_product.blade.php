<?php use App\Models\Category; use App\Models\Vendor; ?>
@if(isset(Auth::guard('admin')->user()->type) && Auth::guard('admin')->user()->type=="vendor")
  @php 
  $getVendorCategory = Vendor::select('category_id')->where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
  $getCategoryName = Category::getCategoryName($getVendorCategory['category_id']) 
  @endphp
@endif
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

</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <!-- <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h4 class="card-title">Profiler</h4>
                    </div> -->
                    <div class="col-12 col-xl-4">
                        <div class="">
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
                  <h4 style="text-transform: none;" class="card-title">{{ $title }}</h4>
                  @if(Session::has('error_message'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong> </strong> <?php echo Session::get('error_message'); ?>
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
                  
                  <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$product['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                    @if(isset(Auth::guard('admin')->user()->type) && Auth::guard('admin')->user()->type=="vendor" && $getPlanDetails['products_limit']==1)

                      <div class="form-group">
                      <label>Kategori</label>
                      <input class="form-control" value="{{ $getCategoryName }}" readonly="">
                      <input type="hidden" name="category_id" value="{{ $getVendorCategory['category_id'] }}">
                    </div>
                    @else
                    <div class="form-group">
                      <label for="category_id">Velg kategori</label>
                      @if(empty($product['id']))
                      <select name="category_id" id="category_id" class="form-control text-dark" required>
                          <option value="">Velg</option>
                          @foreach($categories as $section)
                            @if(isset(Auth::guard('admin')->user()->type) && Auth::guard('admin')->user()->type=="superadmin")
                            <optgroup label="{{ $section['name'] }}"></optgroup>
                            @endif
                           @foreach($section['categories'] as $category)
                           @if(isset(Auth::guard('admin')->user()->type) && Auth::guard('admin')->user()->type=="superadmin")
                            <option @if(Session::get('category_id')==$category['id']) selected="" @endif value="{{ $category['id'] }}">&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                            @else
                            <optgroup label="{{ $category['category_name'] }}" @if(Session::get('category_id')==$category['id']) selected="" @endif value="{{ $category['id'] }}">&nbsp;{{ $category['category_name'] }}</optgroup>
                            @endif
                            @foreach($category['subcategories'] as $subcategory)
                            <option @if(Session::get('category_id')==$subcategory['id']) selected="" @endif value="{{ $subcategory['id'] }}">&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                            @endforeach
                           @endforeach
                          @endforeach
                      </select>
                      @else
                        <select name="category_id" id="category_id" class="form-control text-dark" required>
                          <option value="">Velg</option>
                          @foreach($categories as $section)
                            @if(isset(Auth::guard('admin')->user()->type) && Auth::guard('admin')->user()->type=="superadmin")
                            <optgroup label="{{ $section['name'] }}"></optgroup>
                            @endif
                           @foreach($section['categories'] as $category)
                           @if(isset(Auth::guard('admin')->user()->type) && Auth::guard('admin')->user()->type=="superadmin")
                            <option @if(!empty($product['category_id']==$category['id'])) selected="" @elseif(!empty($product['category_id']==$category['id'])) selected="" @endif value="{{ $category['id'] }}">&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                            @else
                            <optgroup label="{{ $category['category_name'] }}" @if(!empty($product['category_id']==$category['id'])) selected="" @endif value="{{ $category['id'] }}">&nbsp;{{ $category['category_name'] }}</optgroup>
                            @endif
                            @foreach($category['subcategories'] as $subcategory)
                            <option @if(!empty($product['category_id']==$subcategory['id'])) selected="" @endif value="{{ $subcategory['id'] }}">&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                            @endforeach
                           @endforeach
                          @endforeach
                      </select>
                      @endif
                    </div>
                    @endif
                    <!-- <div class="loadFilters">
                      @include('admin.filters.category_filters')
                    </div> -->
                    <div class="form-group">
                      <label for="product_name">Bedriftens navn</label>
                      @if(empty($product['id']))
                      <input type="text" class="form-control" id="product_name" placeholder="Tast inn bedriftens navn" name="product_name" @if(!empty(Session::get('product_name'))) value="{{ Session::get('product_name') }}" @endif required>
                      @else
                      <input type="text" class="form-control" id="product_name" placeholder="Tast inn bedriftens navn" name="product_name" @if(!empty($product['product_name'])) value="{{ $product['product_name'] }}" @else value="{{ old('product_name') }}" @endif required>
                      @endif
                    </div>

                    <div class="form-group @if($product['category_id']!=6 && $product['category_id']!=7) itemCity" @endif>
                      <label for="address">Adresse</label>
                      @if(empty($product['id']))
                      <input type="text" class="form-control" id="product_address" placeholder="Tast inn adresse" name="address" @if(!empty(Session::get('address'))) value="{{ Session::get('address') }}" @endif required>
                      @else
                      <input type="text" class="form-control" id="product_address" placeholder="Tast inn adresse" name="address" @if(!empty($product['address'])) value="{{ $product['address'] }}" @else value="{{ old('address') }}" @endif required>
                      @endif
                    </div>
                    <!-- <div class="form-group">
                      <label for="product_code">Item Code</label>
                      <input type="text" class="form-control" id="product_code" placeholder="Enter Item Code" name="product_code" @if(!empty($product['product_code'])) value="{{ $product['product_code'] }}" @else value="{{ old('product_code') }}" @endif>
                    </div> -->
                    <!-- <div class="form-group">
                      <label for="product_price">Starting Price</label>
                      <input type="text" class="form-control" id="product_price" placeholder="Enter Starting Price" name="product_price" @if(!empty($product['product_price'])) value="{{ $product['product_price'] }}" @else value="{{ old('product_price') }}" @endif>
                    </div> -->
                    <!-- <div class="form-group">
                      <label for="product_discount">Item Discount (%)</label>
                      <input type="text" class="form-control" id="product_discount" placeholder="Enter Item Discount" name="product_discount" @if(!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" @else value="{{ old('product_discount') }}" @endif>
                    </div> -->
                    <div class="form-group @if($product['category_id']!=6 && $product['category_id']!=7) itemCity" @endif>
                      <label for="pincode">Postnummer</label>
                      @if(empty($product['id']))
                      <input type="text" class="form-control" id="norway_pincodes" placeholder="Tast inn postnummer" name="pincode" @if(!empty(Session::get('pincode'))) value="{{ Session::get('pincode') }}" @endif required>
                      @else
                      <input type="text" class="form-control" id="norway_pincodes" placeholder="Tast inn postnummer" name="pincode" @if(!empty($product['pincode'])) value="{{ $product['pincode'] }}" @else value="{{ old('pincode') }}" @endif required>
                      @endif
                    </div>

                    <div class="form-group @if($product['category_id']!=6 && $product['category_id']!=7) itemCity" @endif>
                      <label for="norway_radius">Vil se oppdrag innen (radius i km)</label>
                      @if(empty($product['id']))
                      <input type="number" class="form-control radiusAll" id="norway_radius" placeholder="radius i km" name="radius" @if(!empty(Session::get('radius'))) value="{{ Session::get('radius') }}" @endif required>
                      <input id="deliverToAll" name="deliverToAll" type="checkbox" value="Yes" />
                      <label for="checkbox"><span class="reg-checkbox-text">Se oppdrag fra hele Norge (km)</span></label>
                      @else
                      <input type="number" class="form-control radiusAll" id="norway_radius" placeholder="radius i km" name="radius" @if(!empty($product['radius'])) value="{{ $product['radius'] }}" @else value="{{ old('radius') }}" @endif required>
                      <input id="deliverToAll" name="deliverToAll" type="checkbox" value="Yes" />
                      <label for="checkbox"><span class="reg-checkbox-text">Se oppdrag fra hele Norge (km)</span></label>
                      @endif
                    </div>
                    
                    <div class="form-group @if($product['category_id']!=6 && $product['category_id']!=7) itemCity" @endif>
                      <label for="city">Poststed</label>
                      <!-- <input type="text" class="form-control" id="product_city" placeholder="Enter City" name="city" @if(!empty($product['city'])) value="{{ $product['city'] }}" @else value="{{ old('city') }}" @endif> -->
                      @if(empty($product['id']))
                      <select name="city" id="load_city" class="form-control text-dark" required>
                          <option value="">Velg poststed</option>
                          @foreach($cities as $city)
                             <option @if(!empty(Session::get('city'))&&Session::get('city')==$city) selected @endif value="{{ $city }}">{{ $city }}</option>
                          @endforeach
                          <!-- <option value="India">India</option> -->
                       </select> 
                       @else
                       <select name="city" id="load_city" class="form-control text-dark" required>
                          <option value="">Velg poststed</option>
                          @foreach($cities as $city)
                             <option @if(!empty($product['city'])&&$product['city']==$city) selected @elseif(!empty($product['city'])&&old('city')==$city) selected @endif value="{{ $city }}">{{ $city }}</option>
                          @endforeach
                          <!-- <option value="India">India</option> -->
                       </select> 
                       @endif 
                    </div>
                    <div class="form-group @if($product['category_id']!=6 && $product['category_id']!=7) itemState" @endif>
                      <label for="state">Fylke</label>
                      @if(empty($product['id']))
                      <select name="state" id="load_state" class="form-control text-dark" required>
                          <option value="">Velg fylke</option>
                          @foreach($states as $state)
                             <option @if(!empty(Session::get('state'))&&Session::get('state')==$state) selected @endif value="{{ $state }}">{{ $state }}</option>
                          @endforeach
                          <!-- <option value="India">India</option> -->
                       </select> 
                       @else
                       <select name="state" id="load_state" class="form-control text-dark" required>
                          <option value="">Velg fylke</option>
                          @foreach($states as $state)
                             <option @if(!empty($product['state'])&&$product['state']==$state) selected @elseif(!empty($product['state'])&&old('state')==$state) selected @endif value="{{ $state }}">{{ $state }}</option>
                          @endforeach
                          <!-- <option value="India">India</option> -->
                       </select> 
                       @endif 
                    </div>
                                       
                    <!-- <div class="form-group itemWeight">
                      <label for="product_weight">Item Weight (in grams)</label>
                      <input type="text" class="form-control" id="product_weight" placeholder="Enter Item Weight" name="product_weight" @if(!empty($product['product_weight'])) value="{{ $product['product_weight'] }}" @else value="{{ old('product_weight') }}" @endif>
                    </div> -->
                    <!-- <div class="form-group">
                      <label for="group_code">Group Code</label>
                      <input type="text" class="form-control" id="group_code" placeholder="Enter Group Code" name="group_code" @if(!empty($product['group_code'])) value="{{ $product['group_code'] }}" @else value="{{ old('group_code') }}" @endif>
                    </div> -->
                    <?php /* <div class="form-group">
                      <label for="product_image">Hovedbilde</label>
                      <!-- <label for="product_image">Hovedbilde (Anbefalt størrelse: 1000*500). Maks 2 MB</label> -->
                      
                      <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
                      @if(!empty($product['product_image']))
                        <a target="_blank" href="{{ url('front/images/product_images/large/'.$product['product_image']) }}">Vis bilde</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" module="product-image" moduleid="{{ $product['id'] }}">Slett bilde</a>
                        <input type="hidden" name="current_product_image" value="{{ $product['product_image'] }}">
                      @endif
                    </div> */ ?>
                    <?php /* <div class="form-group">
                      <!-- <label for="images">Bilde-galleri (Anbefalt størrelse: 1000*500). Maks 2 MB</label> -->
                      <label for="images">Bilde-galleri <span class="orangeDim">(Maks 10MB pr opplastning)</span></label>
                      <p class="hovedbilde-text"><b>For å legge til flere bilder i galleriet, trykk på “velg filer”, dermed hold inne CTRL tasten samtidig som du trykker på alle bildene du ønsker å legge til. Tilslutt trykk på “åpne” for å legge til bildene</b></p>
                      <input multiple type="file" class="form-control" id="files" name="images[]" accept="image/*">
                      
                    </div>

                    @if(count($product['images'])>0)
                    <div class="form-group" style="width: 100%; display: inline-block;">
                      @foreach($product['images'] as $image)
                        <span style="float:left; width:110px; padding: 5px; margin: 5px;">
                          <a target="_blank" href="{{ url('front/images/product_images/large/'.$image['image']) }}"><img style="width:100px;" src="{{ url('front/images/product_images/small/'.$image['image']) }}"></a><br>
                          <input type="hidden" name="image[]" value="{{ $image['image'] }}">
                          <input style="width:100px;" type="text" placeholder="Title" name="title[]" value="{{ $image['title'] }}"><br>
                          <a href="javascript:void(0)" class="confirmDelete" module="image" moduleid="{{ $image['id'] }}">Slett</a>
                        </span>
                      @endforeach
                    </div>
                    @endif */ ?>
                    <?php /* <div class="form-group">
                      <!-- <label for="product_video" style="float:left;">Video-galleri (Anbefalt størrelse:  Maks 5 MB)</label> -->
                      <label for="product_video" style="float:left;">Video-galleri  <span class="orangeDim">(Maks 5MB)</span></label>
                      <input type="file" class="form-control" id="product_video" name="product_video" accept="video/*">
                      @if(!empty($product['product_video']))
                      <a target="_blank" href="{{ url('front/videos/product_videos/'.$product['product_video']) }}">View Video</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" module="product-video" moduleid="{{ $product['id'] }}">Delete Video</a>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="product_banner">Banner-bilde (Anbefalt størrelse: 1900x400)</label>
                      <input type="file" class="form-control" id="product_banner" name="product_banner" accept="image/*">
                      @if(!empty($product['product_banner']))
                        <a target="_blank" href="{{ url('front/images/product_banners/'.$product['product_banner']) }}">Se Banner-bilde</a>&nbsp;|&nbsp;
                        <a href="javascript:void(0)" class="confirmDelete" module="product-banner" moduleid="{{ $product['id'] }}">Slett Banner-bilde</a>
                        <input type="hidden" name="current_product_banner" value="{{ $product['product_banner'] }}">
                      @endif
                    </div> */ ?>
                    <div class="form-group">
                      <label for="product_discount">Beskrivelse av tjenesten</label>
                      @if(empty($product['id']))
                      <textarea oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" name="description" id="description" class="form-control" rows="3">@if(Session::has('description')) {{ Session::get('description') }}  @endif</textarea>
                      @else
                      <textarea oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" name="description" id="description" class="form-control" rows="3">{{ $product['description'] }}</textarea>
                      @endif
                      <p style="color:rgb(112, 112, 112); margin-top: 5px;font-size:12px;">Beskrivelsen skal ikke inneholde kontaktinformasjon.</p>

                    </div>
                    @if($product['keywords']!="")
                    <div class="form-group">
                      <label for="keywords">Søkeord</label><br>
                      <input name="keywords" id="keywords" type="text" class="form-control tags" value="{{ $product['keywords'] }}">
                    </div>
                    @else
                    <div class="form-group">
                      <label for="keywords">Søkeord</label><br>
                      <textarea oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" name="keywords" id="keywords" class="form-control tags" rows="3" style="width:400px !important;">
                        @if(Session::has('keywords')) {{ Session::get('keywords') }}  @endif
                      </textarea>
                    </div>
                    @endif
                    <!-- <div class="form-group">
                      <label for="meta_title">Meta Title</label>
                      <input type="text" class="form-control" id="meta_title" placeholder="Enter Meta Title" name="meta_title" @if(!empty($product['meta_title'])) value="{{ $product['meta_title'] }}" @else value="{{ old('meta_title') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="  meta_description">Meta Description</label>
                      <input type="text" class="form-control" id="meta_description" placeholder="Enter Meta Description" name="meta_description" @if(!empty($product['meta_description'])) value="{{ $product['meta_description'] }}" @else value="{{ old('meta_description') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="meta_keywords">Meta Keywords</label>
                      <input type="text" class="form-control" id="meta_keywords" placeholder="Enter Meta Keywords" name="meta_keywords" @if(!empty($product['meta_keywords'])) value="{{ $product['meta_keywords'] }}" @else value="{{ old('meta_keywords') }}" @endif>
                    </div> -->
                    <div class="form-group">
                      <label for="price_range" style="float:left;">Prisnivå (lav $-medium $$-høy $$$) </label>
                                     @if(empty($product['id']))
                      <select class="form-control text-dark" name="price_range" required>
                        <option value="">Velg</option>
                        <option value="Low" @if(!empty(Session::get('price_range'))&&Session::get('price_range')=="Low") selected @endif>lav ($)</option>
                        <option value="Medium" @if(!empty(Session::get('price_range'))&&Session::get('price_range')=="Medium") selected @endif>medium ($$)</option>
                        <option value="High" @if(!empty(Session::get('price_range'))&&Session::get('price_range')=="High") selected @endif>høy ($$$)</option>
                        
                      </select>
                      @else
                      <select class="form-control text-dark" name="price_range" required>
                        <option value="">Velg</option>
                        <option value="Low" @if(!empty($product['price_range'])&&$product['price_range']=="Low") selected @endif>lav ($)</option>
                        <option value="Medium" @if(!empty($product['price_range'])&&$product['price_range']=="Medium") selected @endif>medium ($$)</option>
                        <option value="High" @if(!empty($product['price_range'])&&$product['price_range']=="High") selected @endif>høy ($$$)</option>
                        
                      </select>
                      @endif
                    </div>
                    @if(isset(Auth::guard('admin')->user()->type) && Auth::guard('admin')->user()->type=="superadmin")
                    <div class="form-group">
                      <label for="is_featured">Featured/Sponsored Profile</label>
                      <input type="checkbox" name="is_featured" id="is_featured" value="Yes" @if(!empty($product['is_featured']) && $product['is_featured']=="Yes") checked="" @endif>
                    </div>
                    <div class="form-group">
                      <label for="is_popular">Popular Profile</label>
                      <input type="checkbox" name="is_popular" id="is_popular" value="Yes" @if(!empty($product['is_popular']) && $product['is_popular']=="Yes") checked="" @endif>
                    </div>
                    <div class="form-group">
                      <label for="is_new">New Profile</label>
                      <input type="checkbox" name="is_new" id="is_new" value="Yes" @if(!empty($product['is_new']) && $product['is_new']=="Yes") checked="" @endif>
                    </div>
                    @endif
                    <div class="form-group">
                      <label for="all_norway">Velg leveringsområde</label><br>
                      <input style="display: none;" type="checkbox" id="checkAll"/>&nbsp;
                      @if(empty($product['id']))
                        <input name="all_norway" id="all" type="radio" value="all" checked />&nbsp;Hele Norge
                          <input name="all_norway" id="limited" type="radio" value="limited"  />&nbsp;Velg byer og fylker
                      @else
                        @if(!empty($product['all_norway']) && $product['all_norway']=="all")
                          <input name="all_norway" id="all" type="radio" value="all" checked />&nbsp;Hele Norge
                          <input name="all_norway" id="limited" type="radio" value="limited"  />&nbsp;Velg byer og fylker
                        @else
                          <input name="all_norway" id="all" type="radio" value="all" />&nbsp;Hele Norge
                          <input name="all_norway" id="limited" type="radio" value="limited" checked  />&nbsp;Velg byer og fylker
                        @endif
                      @endif
                      <ul class="allnorway">
                        @foreach($statesWithCities as $state => $cityinfo)
                        <li>
                          <details>
                          <input type="checkbox" name="states[]" id="{{$state}}" value="{{$state}}" @if(!empty($product['all_norway']) && $product['all_norway']=="limited" && $cityinfo['state_selected']==1) checked @endif>
                          <summary class="cityMarker"><label for="{{$state}}">{{$state}}</label></summary>
                          <ul>
                            @foreach($cityinfo['cities'] as $keyc => $city)
                            <li>
                              <input type="checkbox" name="cities[]" id="{{$state}}-{{$keyc}}" value="{{$city['city']}}" @if(!empty($product['all_norway']) && $product['all_norway']=="limited" && $city['city_selected']==1) checked @endif>
                              <label for="{{$state}}-{{$keyc}}">{{$city['city']}}</label>
                            </li>
                            @endforeach
                          </ul>
                        </details>
                        </li>
                        @endforeach
                      </ul>
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