<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Models\Section;
use App\Models\Category;
use App\Models\CmsPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    // Admin Login Route
    Route::match(['get','post'],'login','AdminController@login');    
    Route::group(['middleware'=>['admin']],function(){
        // Admin Dashboard Route
        Route::get('dashboard','AdminController@dashboard');  

        // Update Admin Password
        Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword');

        // Check Admin Password
        Route::post('check-admin-password','AdminController@checkAdminPassword');

        // Update Admin Details
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');

        // Update Vendor Details
        Route::match(['get','post'],'update-vendor-details/{slug}','AdminController@updateVendorDetails');

        // View Admins / Subadmins / Vendors
        Route::get('admins/{type?}','AdminController@admins');

        // View Vendor Details
        Route::match(['get','post'],'view-vendor-details/{id}','AdminController@viewVendorDetails');

        // Update Admin Status
        Route::post('update-admin-status','AdminController@updateAdminStatus');

        // Admin Logout
        Route::get('logout','AdminController@logout');  

        // Sections
        Route::get('sections','SectionController@sections');
        Route::post('update-section-status','SectionController@updateSectionStatus');
        Route::get('delete-section/{id}','SectionController@deleteSection');
        Route::match(['get','post'],'add-edit-section/{id?}','SectionController@addEditSection');

        // Brands
        Route::get('brands','BrandController@brands');
        Route::post('update-brand-status','BrandController@updateBrandStatus');
        Route::get('delete-brand/{id}','BrandController@deleteBrand');
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');

        // Categories
        Route::get('categories','CategoryController@categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        Route::get('append-categories-level','CategoryController@appendCategoryLevel');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');

        // Products
        Route::get('products','ProductsController@products');
        Route::get('reused-products','ProductsController@reusedProducts');
        Route::post('update-product-status','ProductsController@updateProductStatus');
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
        Route::match(['get','post'],'add-edit-reused-product/{id?}','ProductsController@addEditReusedProduct');
        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');
        Route::get('delete-product-banner/{id}','ProductsController@deleteProductBanner');

        // Attributes
        Route::match(['get','post'],'add-edit-attributes/{id}','ProductsController@addAttributes');
        Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}','ProductsController@deleteAttribute');
        Route::match(['get','post'],'edit-attributes/{id}','ProductsController@editAttributes');

        // Filters
        Route::get('filters','FilterController@filters');
        Route::get('filters-values','FilterController@filtersValues');
        Route::post('update-filter-status','FilterController@updateFilterStatus');
        Route::post('update-filter-value-status','FilterController@updateFilterValueStatus');
        Route::match(['get','post'],'add-edit-filter/{id?}','FilterController@addEditFilter');
        Route::match(['get','post'],'add-edit-filter-value/{id?}','FilterController@addEditFilterValue');
        Route::post('category-filters','FilterController@categoryFilters');

        // Images
        Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');
        Route::match(['get','post'],'add-reused-images/{id}','ProductsController@addReusedImages');
        Route::post('update-image-status','ProductsController@updateImageStatus');
        Route::get('delete-image/{id}','ProductsController@deleteImage');

        // Banners
        Route::get('banners','BannersController@banners');
        Route::post('update-banner-status','BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}','BannersController@deleteBanner');
        Route::match(['get','post'],'add-edit-banner/{id?}','BannersController@addEditBanner');

        // Coupons
        Route::get('coupons','CouponsController@coupons');
        Route::post('update-coupon-status','CouponsController@updateCouponStatus');
        Route::get('delete-coupon/{id}','CouponsController@deleteCoupon');
        Route::match(['get','post'],'add-edit-coupon/{id?}','CouponsController@addEditCoupon');

        // Users
        Route::get('users','UserController@users');
        Route::post('update-user-status','UserController@updateUserStatus');
        Route::get('delete-user/{id}','UserController@deleteUser');

        // Subscribers
        Route::get('subscribers','UserController@subscribers');
        Route::post('update-subscriber-status','UserController@updateSubscriberStatus');

        // CMS Pages
        Route::get('cms-pages','CmsController@cmspages');
        Route::post('update-cms-page-status','CmsController@updateCMSPageStatus');
        Route::match(['get','post'],'add-edit-cms-page/{id?}','CmsController@addEditCmsPage');
        Route::get('delete-cms-page/{id}','CmsController@deleteCMSPage');

        // Products Enquiries
        Route::get('products-enquiries','EnquiryController@productsEnquiries');
        Route::get('products-enquiries/{enqid}','EnquiryController@productsEnquiriesDetail');
        Route::get('enquiries-responses','EnquiryController@enquiriesResponses');
        Route::post('reply-enquiry','EnquiryController@replyEnquiry');
        Route::post('update-enquiry-status','EnquiryController@updateEnquiryStatus');
        Route::post('update-pin-status','EnquiryController@updatePinStatus');

        // Enquiries
        Route::get('enquiries','EnquiryController@enquiries');

        // Events
        Route::get('events','EventController@events');
        Route::post('update-event-status','EventController@updateEventStatus');

        // Reviews/Ratings
        Route::get('ratings','RatingController@ratings');
        Route::post('update-rating-status','RatingController@updateRatingStatus');
        Route::get('delete-rating/{id}','RatingController@deleteRating');

        // Plans
        Route::get('plans','PlanController@plans');
        Route::post('update-plan-status','PlanController@updatePlanStatus');
        Route::match(['get','post'],'add-edit-plan/{id?}','PlanController@addEditPlan');
        Route::get('delete-plan-image/{id}','PlanController@deletePlanImage');

        // Upgrade Plan
        Route::post('/vendor/upgrade-plan','AdminController@upgradeSelectedPlan');

        // Plan Upgrade
        Route::get('/vendor/plans/upgrade/{code}','AdminController@planUpgrade');

        // Delete Vendor
        Route::get('delete-vendor/{id}','AdminController@deleteVendor');
    });
});

Route::namespace('App\Http\Controllers\Front')->group(function(){

    // Coming Soon Page
    //Route::get('/', 'IndexController@comingSoon');

    // Home Page
    Route::get('/','IndexController@index');

    // Phpinfo
    Route::get('/phpinfo','IndexController@phpinfo');

    Route::get('/login','IndexController@login')->name('login');

    Route::match(['get', 'post'], '/admin/vendor-login','VendorController@adminVendorLogin');

    Route::get('/enquiry-done','IndexController@enquiryDone')->name('enquirydone');

    // Listing/Section Routes
    $catUrls = [];
    try {
        if (Schema::hasTable('sections')) {
            $catUrls = Section::select('url')->where('status',1)->pluck('url')->toArray();
        }
    } catch (\Throwable $e) {
        $catUrls = [];
    }
    /*dd($catUrls); die;*/
    foreach ($catUrls as $key => $url) {
        Route::match(['get','post'],'/'.$url,'ProductsController@listing');
    }

    // Listing/Categories Routes
    $catUrls = [];
    try {
        if (Schema::hasTable('categories')) {
            $catUrls = Category::select('url')->where('status',1)->pluck('url')->toArray();
        }
    } catch (\Throwable $e) {
        $catUrls = [];
    }
    /*dd($catUrls); die;*/
    foreach ($catUrls as $key => $url) {
        Route::match(['get','post'],'/'.$url,'ProductsController@listing');
    }

    // CMS Pages Routes
    $cmsUrls = [];
    try {
        if (Schema::hasTable('cms_pages')) {
            $cmsUrls = CmsPage::select('url')->where('status',1)->pluck('url')->toArray();
        }
    } catch (\Throwable $e) {
        $cmsUrls = [];
    }
    foreach($cmsUrls as $url){
        Route::get($url,'CmsController@cmsPage');
    }

    // Search Products
    Route::get('search-products','ProductsController@listing');

    // Listing Page
    /*Route::get('/listing','IndexController@listing');*/

    // Detail Page
    /*Route::get('/detail','IndexController@detail');*/

    // Product Detail Page
    Route::get('/product/{name}/{id}','ProductsController@detail');

    // Product Detail Review Page
    Route::get('/product-review/{name}/{id}','ProductsController@detailReview');

    // Blog
    Route::get('/blog','IndexController@blog');
    Route::get('/blog-detail','IndexController@blogDetail');
    Route::get('/blog-detail_1','IndexController@blogDetail_1');
    Route::get('/blog-detail_2','IndexController@blogDetail_2');

    // Contact Us
    Route::get('/contact','IndexController@contact');
    Route::post('/save-contact','CmsController@saveContact');

    // Enquire Us
    Route::get('/enquire-us','IndexController@enquiry');

    // Cookies Policy
    Route::get('/cookie-policy','IndexController@cookiepolicy');

    // Terms Conditions
    Route::get('/terms-conditions','IndexController@termsconditions');

    // Terms Conditions for Vendor
    Route::get('/supplier-terms-conditions','IndexController@suppliertermsconditions');

    // Privacy Policy
    Route::get('/privacy-policy','IndexController@privacypolicy');

    // About Us
    Route::get('/about','IndexController@aboutus');

    // Thanks Enquiry
    Route::get('/enquire-thanks','EnquiryController@thanksEnquiry');

    // Contact Us
    Route::get('/contact','IndexController@contact');

    // Vendor Register
    Route::match(['get','post'],'vendor/register','VendorController@vendorRegister');

    // Plans
    Route::get('/vendor/plans/{code}','VendorController@plans');

    // Display Plans
    Route::get('/plans','VendorController@displayPlans');

    // Select Plan
    Route::post('/vendor/select-plan','VendorController@selectPlan');

    // Vendor Login
    Route::match(['get','post'],'vendor/login','VendorController@vendorLogin');

    // Vendor Forgot Password
    Route::match(['get','post'],'vendor/forgot-password','VendorController@vendorForgotPassword');

    // Confirm Vendor Account
    Route::get('vendor/confirm/{code}','VendorController@confirmVendor');

    // User Login
    Route::post('user/login','UserController@userLogin');

    // User Register
    Route::post('user/register','UserController@userRegister');

    // Confirm User Account
    Route::get('user/confirm/{code}','UserController@confirmAccount');

    // User Enquiry for Product 
    Route::post('user/enquiry','UserController@userEnquiry');

    // User Enquiry
    Route::post('user/submit-enquiry','EnquiryController@submitEnquiry');

    // Event Detail Page
    Route::get('/event/{name}/{id}','EventController@viewEvent');

    // Attend Event
    Route::post('/user/attend-event','EventController@attendEvent');

    // Get Cities
    Route::get('/get-city','EnquiryController@getCity');

    // Get Cities & States
    Route::get('/get-city-state','EnquiryController@getCityState');

    // Get Country Code
    Route::get('/get-countrycode','EnquiryController@getCountryCode');

    // Add to Wishlist
    Route::match(['get','post'],'/add-to-wishlist','ProductsController@addtoWishlist');

    // User Forgot Password
    Route::match(['get','post'],'user/forgot-password','UserController@forgotPassword');

    //Subscriber routes
    Route::post('add-subscriber','IndexController@addSubscriber');

    Route::group(['middleware'=>['auth']],function(){

        // User Account
        Route::match(['GET','POST'],'user/account','UserController@userAccount');

        // User Wishlist
        Route::get('/user/wishlist','UserController@userWishList');

        // Remove Wishlist
        Route::get('/user/remove-wishlist/{id}','UserController@removeWishlist');

        // User Enquiries
        Route::match(['GET','POST'],'user/enquiries','UserController@userEnquiries');

        // User Enquiries Detail
        Route::match(['GET','POST'],'user/enquiries/{enqid}','UserController@userEnquiriesDetail');

        // User Assignment Enquiry Overview
        Route::get('user/enquiries/{enqid}/overview','UserController@userEnquiryOverview');

        // User Enquiries Messages Polling
        Route::get('user/enquiries/{enqid}/messages','UserController@userEnquiryMessages');

        // User Enquiries Response
        Route::post('user/enquiry/response','UserController@userEnquiryResponse');

        // User Update Password
        Route::match(['GET','POST'],'user/update-password','UserController@userUpdatePassword');

        // User Invitations
        Route::match(['GET','POST'],'user/invitations','UserController@userInvitations');
        Route::get('user/invitations/delete/{id}','UserController@deleteInvitation');

        // User Select Category
        Route::match(['get','post'],'user/select-category','ProductsController@selectCategory');

        // User Add Listing
        Route::match(['get','post'],'user/add-product/{catid}','ProductsController@addProduct');

        // User Edit Listing
        Route::match(['get','post'],'user/edit-product/{proid}','ProductsController@editProduct');

        // User Delete Listing
        Route::match(['get','post'],'user/delete-product/{proid}','ProductsController@deleteProduct');

        // User Add Event
        Route::match(['get','post'],'user/add-event','EventController@addEvent');

        // User Delete Event
        Route::match(['get','post'],'user/delete-event/{eventid}','EventController@deleteEvent');

        // User Logout
        Route::get('user/logout','UserController@userLogout');

        //Write a Review Page
        Route::post('/write-a-review','ProductsController@writeReview');

        // Update Enquiry Status
        Route::post('update-enquiry-status','EnquiryController@updateEnquiryStatus');

        // Delete completed user enquiry
        Route::post('delete-enquiry','EnquiryController@deleteEnquiry');

        // Update Pin Status
        Route::post('update-pin-status','EnquiryController@updatePinStatus');

        // Get User Enquiries (based on categories, pin/unpin, active/close) 
        Route::post('get-user-enquiries','UserController@getUserEnquiries');

    });
});
