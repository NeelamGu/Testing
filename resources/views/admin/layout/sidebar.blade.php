<?php $messagesCountVendor = messagesCountVendor(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .count-number 
{
    position: absolute;
    left: 33px !important;
    width: 21px;
    top: -1px;
    text-align: center;
    height: 21px;
    background: #000;
    border-radius: 30px;
    vertical-align: middle;
    font-weight: bold;
    color: #Fff;
    line-height: 21px;
    font-size: 11px;
    right: 30px;

} 
.sidebar .nav:not(.sub-menu) > .nav-item:hover > .nav-link
{
    background: #e46f01 !important;
}
.sidebar .nav:not(.sub-menu) > .nav-item > .nav-link[aria-expanded="true"]
{
    background: #e46f01 !important;
}
</style>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a @if(Session::get('page')=="dashboard") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" href="{{ url('admin/dashboard')}}">
            <i class="icon-grid menu-icon"></i>
            <span class="menu-title">Min side</span>
            </a>
        </li>
        @if(Auth::guard('admin')->user()->type=="vendor")
        <li class="nav-item">
            <a @if(Session::get('page')=="update_personal_details") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" href="{{ url('admin/update-vendor-details/personal') }}">
            <!-- <i class="fa fa-user-o menu-icon"></i> -->
            <img src="{{ asset('admin/images/user.png') }}" alt="icon" width="16px">
            <span class="menu-title">Min konto</span>
            </a>
        </li>
     
        <?php /* <li class="nav-item">
            <a @if(Session::get('page')=="update_personal_details" || Session::get('page')=="update_business_details" || Session::get('page')=="update_bank_details" || Session::get('page')=="update_admin_password")  style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-vendors" aria-expanded="false" aria-controls="ui-vendors">
            <!-- <i class="icon-layout menu-icon"></i> -->
            <!-- <img class="profile-img side-icon" src="{{ asset('admin/images/user.png') }}" alt="" class="banner"> -->
            <i class="fa fa-user-o menu-icon icon-sidebar" aria-hidden="true"></i>
            <span class="menu-title">Kontoadministrasjon</span>
            <i class="menu-arrow "></i>
            </a>
            <div class="collapse" id="ui-vendors">
                <ul class="nav flex-column sub-menu" style="background:#fff3e5 !important; color: #404040 !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="update_personal_details") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/update-vendor-details/personal') }}">Min konto </a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="update_admin_password") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/update-admin-password') }}">Bytt passord </a></li>
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="update_business_details") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/update-vendor-details/business') }}">Business Details</a></li> -->
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="update_bank_details") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/update-vendor-details/bank') }}">Bank Details</a></li> -->
                </ul>
            </div>
        </li> */ ?>
        <li class="nav-item">
            <a @if(Session::get('page')=="products") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" href="{{ url('admin/products') }}">
            <!-- <i class="fa fa-address-book-o menu-icon"></i> -->
            <img class="profile-img" src="{{ asset('admin/images/cv.png') }}" alt="" width="16px">
            <span class="menu-title">Mine annonser</span>
            </a>
        </li>
        <?php /* <li class="nav-item">
            <a @if(Session::get('page')=="sections" || Session::get('page')=="categories" || Session::get('page')=="products") style="background:#e46f01 !important; color: #fff !important;"  @endif class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
            <i class="fa fa-address-book-o menu-icon icon-sidebar other-s-icons" aria-hidden="true"></i>
            <span class="menu-title">Annonser</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;"> 
                    <li class="nav-item"> <a @if(Session::get('page')=="products") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/products') }}">Mine annonser</a></li>  
                </ul>
            </div>
        </li> */ ?>
        <li class="nav-item">
            <a @if(Session::get('page')=="products_enquiries" || Session::get('page')=="products_enquiries_detail") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" href="{{ url('admin/products-enquiries') }}">
            <img src="{{ asset('admin/images/help.png') }}" alt="icon" width="16px">
            <!-- <span class="menu-title">Oppdrag og meldinger</span> -->
            <span class="menu-title">Oppdrag og meldinger</span>
            </a>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="update_admin_password") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" href="{{ url('admin/update-admin-password') }}">
            <i class="fa fa-unlock-alt menu-icon"></i>
            <span class="menu-title">Bytt passord</span>
            </a>
        </li>
        <?php /* <li class="nav-item" style="position: relative;">
            <a @if(Session::get('page')=="enquiries_responses" || Session::get('page')=="products_enquiries") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-enquiries" aria-expanded="false" aria-controls="ui-enquiries">
            <i class="fa fa-comments-o menu-icon icon-sidebar other-s-icons" aria-hidden="true"></i>
            <span class="menu-title">@if( isset($messagesCountVendor) && $messagesCountVendor>0)<span class="count-number">{{$messagesCountVendor}}</span> @endif Oppdrag og meldinger</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-enquiries">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="enquiries") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/enquiries') }}">Enquiries</a></li> -->
                    <li class="nav-item"> <a @if(Session::get('page')=="products_enquiries") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/products-enquiries') }}">Oppdrag og meldinger</a></li>
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="enquiries_responses") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/enquiries-responses') }}">Responses</a></li> -->   
                </ul>
            </div>
        </li> */ ?>
        @else
        <li class="nav-item">
            <a @if(Session::get('page')=="update_admin_password" || Session::get('page')=="update_admin_details") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-settings" aria-expanded="false" aria-controls="ui-settings">
            <i class="icon-lock menu-icon"></i>
            <span class="menu-title">Settings</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-settings">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="update_admin_password") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/update-admin-password') }}">Update Password</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="update_admin_details") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/update-admin-details') }}">Update Details</a></li>
                    
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="view_admins" || Session::get('page')=="view_subadmins"  || Session::get('page')=="view_vendors"  || Session::get('page')=="view_all") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-admins" aria-expanded="false" aria-controls="ui-admins">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Admin Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-admins">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <?php /* <li class="nav-item"> <a @if(Session::get('page')=="view_admins") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/admins/admin') }}">Admins</a></li> */ ?>
                    <?php /* <li class="nav-item"> <a @if(Session::get('page')=="view_subadmins") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/admins/subadmin') }}">Subadmins</a></li> */ ?>
                    <li class="nav-item"> <a @if(Session::get('page')=="view_vendors") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/admins/vendor') }}">Vendors</a></li>
                    <?php /* <li class="nav-item"> <a @if(Session::get('page')=="view_all") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/admins') }}">All</a></li> */ ?>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="sections" || Session::get('page')=="categories" || Session::get('page')=="products" || Session::get('page')=="coupons") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
            <i class="icon-paper menu-icon"></i>
            <span class="menu-title">Catalogue Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="sections") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/sections') }}">Sections</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="categories") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/categories') }}">Categories</a></li> 
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="brands") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/brands') }}">Brands</a></li> -->  
                    <li class="nav-item"> <a @if(Session::get('page')=="products") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/products') }}">Profiles</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="reused_products") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/reused-products') }}">Re-used Items</a></li> 
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="coupons") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/coupons') }}">Coupons</a></li> -->
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="filters") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/filters') }}">Filters</a></li> -->   
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="enquiries_responses" || Session::get('page')=="products_enquiries" || Session::get('page')=="products_enquiries_detail" || Session::get('page')=="enquiries") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-enquiries" aria-expanded="false" aria-controls="ui-enquiries">
            <i class="icon-paper menu-icon"></i>
            <span class="menu-title">Enquiries Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-enquiries">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="enquiries") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/enquiries') }}">Enquiries</a></li>
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="products_enquiries") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/products-enquiries') }}">Products Enquiries</a></li> -->
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="enquiries_responses") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/enquiries-responses') }}">Responses</a></li>  -->  
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="events" || Session::get('page')=="events") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-events" aria-expanded="false" aria-controls="ui-events">
            <i class="icon-paper menu-icon"></i>
            <span class="menu-title">Events Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-events">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="events") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/events') }}">Events</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="users" || Session::get('page')=="Subscribers") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-users" aria-expanded="false" aria-controls="ui-users">
            <i class="icon-head menu-icon"></i>
            <span class="menu-title">Users Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-users">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="users") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/users') }}">Users</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="subscribers") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/subscribers') }}">Subscribers</a></li>   
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="banners") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-banners" aria-expanded="false" aria-controls="ui-banners">
            <i class="icon-image menu-icon"></i>
            <span class="menu-title">Banners Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-banners">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="banners") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/banners') }}">Home Page Banners</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="cmspages") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-banners" aria-expanded="false" aria-controls="ui-banners">
            <i class="icon-paper menu-icon"></i>
            <span class="menu-title">Pages Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-banners">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="cmspages") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/cms-pages') }}">CMS Pages</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="ratings") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-ratings" aria-expanded="false" aria-controls="ui-ratings">
            <i class="icon-paper menu-icon"></i>
            <span class="menu-title">Reviews Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-ratings">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="ratings") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/ratings') }}">Ratings & Reviews</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="plans") style="background:#e46f01 !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-plans" aria-expanded="false" aria-controls="ui-plans">
            <i class="icon-paper menu-icon"></i>
            <span class="menu-title">Plans Management</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-plans">
                <ul class="nav flex-column sub-menu" style="background: #fff3e5 !important; color: #404040 !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="plans") style="background:#e46f01 !important; color: #fff !important;" @else style="background:#fff3e5 !important; color: #404040 !important;" @endif class="nav-link" href="{{ url('admin/plans') }}">Plans</a></li>
                </ul>
            </div>
        </li>
        @endif
    </ul>
</nav>