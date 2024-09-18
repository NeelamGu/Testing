@extends('front.layout.layout')
@section('content')
<div class="page-wrapper">
   <div class="contact-section account-page">
       <div class="auto-container">
           <div class="row clearfix">
               <div class="col-md-3 col-sm-3 col-xs-12 column account-tab-area">
                   <div class="info-box p-xs-15">
                       <ul class="account-sidebar">
                     <li>
                        <a href="{{url('user/account')}}">
                           <span class="fa fa-user"></span>
                           <p >Profil</p>
                        </a>
                     </li>
                     <li>
                         <a href="{{url('user/select-category')}}">
                             <span class="fa fa-plus"></span>
                             <p class="active-list"></span>Ny annonse</p>
                         </a>
                     </li>
                     <li>
                          <a href="{{url('/user/add-event')}}">
                              <span class="fa fa-calendar"></span>
                              <p>Legg til hendelse</p>
                          </a>
                      </li>
                     <li>
                        <a href="{{url('user/enquiries')}}">
                           <span class="fa fa-comment"></span>
                           <p>Forespørsler</p>
                        </a>
                     </li>
                     <li>
                        <a href="{{url('user/update-password')}}">
                           <img src="{{ asset('front/images/icons/change-password.svg') }}" alt="">
                           <p>Bytt passord</p>
                        </a>
                     </li>
                     <li>
                        <a href="{{url('user/logout')}}">
                           <img src="{{ asset('front/images/icons/log-out.svg') }}" alt="">
                           <p>Logg ut</p>
                        </a>
                     </li>
                  </ul>
                   </div>
               </div>
               <!--Content Side-->
               <div class="col-md-9 col-sm-9 col-xs-12 column pull-left">
                   <div class="vartical-tabs-data">
                       <div class="sec-title account-heading">
                           <h3 class="font-20  text-black account-title">LEGG UT NY ANNONSE</h3>
                           <h4 class="font-10  text-black account-title">VELG EN KATEGORI</h4>
                       </div>
                       <div class="container">
                           <div class="row">
                               <div class="col-sm-3 p-0">
                                   <ul class="nav nav-tabs tabs-left" role="tablist">
                                       @foreach($categories as $section)
                                       @foreach($section['categories'] as $category)
                                       <li role="presentation">
                                           <a href="#{{ $category['id'] }}" aria-controls="mobile" role="tab" data-toggle="tab">{{ $category['category_name'] }} <i class="fa fa-angle-right pull-right" aria-hidden="true"></i>
                                           </a>
                                       </li>
                                       @endforeach
                                       @endforeach
                                   </ul>
                               </div>
                               <div class="col-sm-9 p-0">
                                   <div class="tab-content">
                                        @foreach($categories as $section)

                                        @foreach($section['categories'] as $category)
                                       <div role="tabpanel" class="tab-pane" id="{{ $category['id'] }}">
                                           <ul class="addon-list">
                                                @foreach($category['subcategories'] as $subcategory)
                                               <li><a href="{{ url('user/add-product/'.$subcategory['id'])}}">{{ $subcategory['category_name'] }}</a></li>
                                               @endforeach
                                           </ul>
                                       </div>
                                       @endforeach
                                       @endforeach
                                       
                                   </div>
                               </div>
                               <div>&nbsp;</div>
                        
                           </div>
                       </div>
                       @include('front.users.view_products')
                   </div>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection