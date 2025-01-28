<?php
   use App\Models\Section;
   $sections = Section::sections();
   /*echo "<pre>"; print_r($sections); die;*/
   $totalCartItems = totalCartItems();
   $messagesCountCustomer = messagesCountCustomer();
   ?>
  
<!-- Main Header -->
<header class="main-header" id="main-header">
<div id="translator" style="background-color:#fff !important; position: relative; top:0; z-index: 9;">   
    <div id="google_translate_element" style="position: absolute; z-index: 9;">
        <!-- Google Translate will load here -->
    </div>
</div>

   @if(isset(Auth::guard('admin')->user()->type))
      <!-- Header Top -->
      <div class="header-top">
         <div class="auto-container clearfix">
            <!-- Top Left -->
            <!-- Top Right -->
            <div class="top-right">
               <ul class="clearfix">
                  
                  <li><a href="{{ url('admin/dashboard') }}"><span class="fa fa-user"></span>Min side</a></li>
                  <!-- <li><a href="{{ url('admin/update-admin-details') }}"><span class="fa fa-user"></span>Regnskap</a></li> -->
                   <li><a href="{{ url('admin/products-enquiries') }}"></span><i class="fa fa-comment-o" aria-hidden="true"></i>Meldinger</a></li>
                  <li><a href="{{ url('admin/logout') }}"><span class="fa fa-sign-out"></span>Logg ut</a></li>
                  
               </ul>
            </div>
         </div>
      </div>
      <!-- Header Top End -->
   @else
      <!-- Header Top -->
      <div class="header-top">
         <div class="auto-container clearfix">
            <!-- Top Left -->
            <!-- Top Right -->
            <div class="top-right">
               <ul class="clearfix">
                  <!-- <li><a href="#"><span class="fa fa-bell"></span> Notifications</a></li> -->
                  @if(Auth::check())
                 <!--  <li><a href="{{ url('user/select-category') }}"><span class="fa fa-plus"></span>Ny annonse</a></li>
                  <li><a href="{{ url('user/add-event') }}"><span class="fa fa-calendar"></span>Ny begivenhet</a></li> -->
                  <li>
                     <a href="{{ url('user/enquiries') }}">
                        <span class="fa fa-comment"></span>Meldinger
                        @if($messagesCountCustomer>0)<span class="count-number">{{$messagesCountCustomer}}</span>@endif
                     </a>
                  </li>
                  <li>
                     <a href="{{ url('user/wishlist') }}">
                        <span class="fa fa-heart"></span>Favoritter
                     </a>
                  </li>
                  <li><a href="{{ url('user/account') }}"><span class="fa fa-user"></span>Min side</a></li>
                 <!--  <li><a href="{{ url('user/logout') }}"><span class="fa fa-sign-out"></span>Logg ut</a></li> -->
                  @else

                   <li>
                     <a href="#" class="login-btns" data-toggle="modal"  data-target="#loginModal" >
                     Kunde Logg inn</a>
                  </li>
                   <!-- @if(!isset(Auth::guard('admin')->user()->type))
                  <li>
                     <a href="{{ url('enquire-us') }}">Lag oppdrag</a>
                  </li>
                   @endif -->
                  <li>
                     <a href="#" class="" data-toggle="modal" data-target="#customerlogin">Leverandør Logg inn</a>
                  </li>
                 
                  @endif
               </ul>
            </div>
         </div>
      </div>
      <!-- Header Top End -->
   @endif
   <!-- Header Lower -->
   <div class="header-lower">
      <div class="auto-container clearfix">
         <!--Outer Box-->
         <div class="outer-box">
            <!-- Logo -->
            <div class="logo">
               <a onclick="resetGoogleTranslate()"><img class="img-responsive" src="{{ asset('front/images/logo5.png') }}"
                  alt="garnen-help"></a>
            </div>
            <nav class="main-menu">
               <div class="navbar-header">
                  <!-- Toggle Button -->
                  <button type="button" class="navbar-toggle" data-toggle="collapse"
                     data-target=".navbar-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
               </div>
               <div class="navbar-collapse collapse clearfix">
                  <ul class="navigation">
                     <!-- <li class="current"><a href="{{ url('/')}}">Hjem</a>
                        </li> -->
                     <!-- <li><a href="{{ url('/venues')}}">Venues</a></li> -->
                     <!-- <li class=""><a href="vendors.php">Vendors</a>
                        </li> -->
                     @foreach($sections as $section)
                     @if(count($section['categories'])>0)
                     <li class="dropdown w3_megamenu-fw open">
                        <a href="{{ url($section['url']) }}" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">{{ $section['name'] }}<b class="caret"></b></a>
                        <ul class="dropdown-menu fullwidth" style="display: none;">
                           <li>
                              <div class="row">
                                 @foreach($section['categories'] as $category)
                                 <div class="col-sm-6">
                                    <div class="menu-category">
                                       <a href="{{ url($category['url']) }}">
                                          <h3 class="title">{{ $category['category_name'] }}</h3>
                                       </a>
                                       <ul>
                                          @foreach($category['subcategories'] as $subcategory)
                                          <li><a href="{{ url($subcategory['url']) }}">{{ $subcategory['category_name'] }}</a></li>
                                          @endforeach
                                       </ul>
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                           </li>
                        </ul>
                     </li>
                     @endif
                     @endforeach
                     <li class=""><a href="{{ url('/about')}}">Om Samling</a>
                     </li>
                     <li><a href="{{ url('/contact')}}">Kontakt oss</a></li>
                  </ul>
               </div>
            </nav>
            <!-- Main Menu -->
            <!-- Main Menu End-->
            <!--RSVP Button-->
            <div class="appoinment-btn">
               <!-- Modal: donate now Starts -->
               <!-- <a>
                  <input style="width: 300px;" class="thm-btn pt-5 pb-5 mt-5 letter-spacing-1" href="#"
                     type="search" name="fname" value="" placeholder="Search..." required="">
                  <button type="submit"><i class="fa fa-search bg-none"></i></button>
                  </a> -->
               <div class="search-button">
                  <button id="search"><i class="fa fa-search"></i></button>
                  <div class="search-popup" style="display: none;">
                     <div class="search-bg"></div>
                     <div class="search-form" style="right: 0px;">
                        <form method="get" action="{{ url('/search-products')}}" class="search-form" autocomplete="off" style="right: 0px;">
                           <div class="form">
                              <input type="text" class="searchproducts ui-autocomplete-input" name="q" id="search" placeholder="søk" required="" autocomplete="off">
                              <button type="submit" class="submit-btn"><label for="search"><i class="fa fa-search"></i></label></button>
                           </div>
                           <a href="javascript:void(0)" class="close-icon"><img src="{{ asset('front/images/icons/cloose-white.png') }}"></a>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Header Lower End-->
</header>
<!--End Main Header -->