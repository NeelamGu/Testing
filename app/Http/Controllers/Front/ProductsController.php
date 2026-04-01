<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsCity;
use App\Models\ProductsState;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use App\Models\Rating;
use App\Models\Wishlist;
use Session;
use DB;
use Auth;
use Image;
use Validator;

class ProductsController extends Controller
{
    public function listing(Request $request){

        if($request->ajax()){
            $data = $request->all();
            $url = Route::getFacadeRoot()->current()->uri();
            /*echo "<pre>"; print_r($data); die;*/
            /*$url = $data['url'];*/

            /*$_GET['sort'] = $data['sort'];*/
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            $sectionCount = Section::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){

                // Get Category Details
                $categoryDetails = Category::categoryDetails($url);            
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1)->where('is_delete',0);

                // Checking for Dynamic Filters
                /*$productFilters = ProductsFilter::productFilters();
                foreach ($productFilters as $key => $filter) {
                    // If filter is selected
                    if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){
                        $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                    }
                }*/

                // checking for Sort
                if(isset($data['sort']) && !empty($data['sort'])){
                    if($data['sort']=="newest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($data['sort']=="oldest"){
                        $categoryProducts->orderby('products.id','Asc');
                    }else if($data['sort']=="lth"){
                        $categoryProducts->orderby('products.product_price','Asc');
                    }else if($data['sort']=="htl"){
                        $categoryProducts->orderby('products.product_price','Desc');
                    }else if($data['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
                    }else if($data['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
                    }else if($data['sort']=="popular"){
                        //$categoryProducts->where('products.is_popular','Yes');
                        $productIds = DB::table('products_enquiries')->select('product_id')->pluck('product_id')->toArray();
                        $allproductIds = DB::table('products')->select('id')->where('status',1)->where('is_delete',0)->whereNotin('id',$productIds)->pluck('id')->toArray();
                        $popularProductIds = array_merge($productIds,$allproductIds);
                        $ids_ordered = implode(',', $popularProductIds);
                        $categoryProducts->wherein('id',$popularProductIds)->orderByRaw("FIELD(products.id, $ids_ordered)");
                    }else if($data['sort']=="new-products"){
                        //$categoryProducts->where('products.is_new','Yes');
                        $categoryProducts->orderby('products.id','Desc')->limit(18);
                    }else if($data['sort']=="featured"){
                        $categoryProducts->where('products.is_featured','Yes');
                    }
                }

                // checking for Whole Norway
                if(isset($data['wholenorway']) && !empty($data['wholenorway'])){
                    if($data['wholenorway']=="Yes"){
                        $wholenorway = "all";
                    }else{
                        $wholenorway = "limited";
                    }
                    $categoryProducts->where('products.all_norway',$wholenorway);
                }

                // checking for Size
                if(isset($data['size']) && !empty($data['size'])){
                    $prosize = $data['size'];
                    $prosizes = explode('~',$prosize);
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size',$prosizes)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for City
                if(isset($data['city1']) && !empty($data['city1'])){
                    $procity = $data['city1'];
                    $procities = explode('~',$procity);
                    $productIds = Product::select('id')->whereIn('city',$procities)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for State
                if(isset($data['state1']) && !empty($data['state1'])){
                    $prostate = $data['state1'];
                    $prostates = explode('~',$prostate);
                    foreach ($prostates as $key => $state) {
                        $citiesCount = DB::table('cities')->where('state',$state)->count();
                        if($citiesCount>0){
                            $citiesData = DB::table('cities')->where('state',$state)->get();
                            foreach ($citiesData as $key => $city) {
                                $cities[] = $city->city;
                            }
                            $cities = array_unique($cities);
                        }
                    }
                    $productIds = Product::select('id')->whereIn('city',$cities)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for City
                if(isset($data['city']) && !empty($data['city'])){
                    $procity = $data['city'];
                    $procities = explode('~',$procity);
                    $productIds = ProductsCity::select('product_id')->whereIn('city',$procities)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for State
                if(isset($data['state']) && !empty($data['state'])){
                    $prostate = $data['state'];
                    $prostates = explode('~',$prostate);
                    foreach ($prostates as $key => $state) {
                        $citiesCount = DB::table('cities')->where('state',$state)->count();
                        if($citiesCount>0){
                            $citiesData = DB::table('cities')->where('state',$state)->get();
                            foreach ($citiesData as $key => $city) {
                                $cities[] = $city->city;
                            }
                            $cities = array_unique($cities);
                        }
                    }
                    $productIds = ProductsCity::select('product_id')->whereIn('city',$cities)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for Price Range
                if(isset($data['range']) && !empty($data['range'])){
                    $prorange = $data['range'];
                    $proranges = explode('~',$prorange);
                    $productIds = Product::select('id')->whereIn('price_range',$proranges)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for Color
                /*if(isset($data['color']) && !empty($data['color'])){
                    $productIds = Product::select('id')->whereIn('product_color',$data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }*/

                // checking for Price
                /*if(isset($data['price']) && !empty($data['price'])){
                    foreach ($data['price'] as $key => $price) {
                        $priceArr = explode("-",$price);
                        $productIds[] = Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();
                    }
                    $productIds = call_user_func_array('array_merge', $productIds);
                    $categoryProducts->whereIn('products.id',$productIds);
                }*/

                // checking for Price
                /*$productIds = array();
                if(isset($data['price']) && !empty($data['price'])){
                    foreach ($data['price'] as $key => $price) {
                        $priceArr = explode("-",$price);
                        if(isset($priceArr[0]) && isset($priceArr[1])){
                            $productIds[] = Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();    
                        }
                    }
                    $productIds = array_unique(array_flatten($productIds));
                    $categoryProducts->whereIn('products.id',$productIds);
                }*/

                // checking for Brand
                /*if(isset($data['brand']) && !empty($data['brand'])){
                    $productIds = Product::select('id')->whereIn('brand_id',$data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }*/

                //Checking for categories
                if(isset($data['category']) && !empty($data['category'])){
                    $catids = explode('~',$data['category']);
                    $categoryProducts->wherein('products.category_id', $catids);
                }

                $categoryProducts = $categoryProducts->get();
                /*dd($categoryProducts);*/
                /*echo "Category exists"; die;*/
                /*return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));*/

                return response()->json([
                'view' => (String)View::make('front.products.products_listing')->with(compact('categoryDetails','categoryProducts','url'))
                ]);


            }else if($sectionCount>0){

                // Get Section Details
                $sectionDetails = Section::where(['url'=>$url,'status'=>1])->first()->toArray();  

                $categoryProducts =  Product::with('brand')->where('section_id',$sectionDetails['id'])->where('status',1)->where('is_delete',0);


                // Checking for Dynamic Filters
                /*$productFilters = ProductsFilter::productFilters();
                foreach ($productFilters as $key => $filter) {
                    // If filter is selected
                    if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){
                        $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                    }
                }*/

                // checking for Sort
                if(isset($data['sort']) && !empty($data['sort'])){
                    if($data['sort']=="newest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($data['sort']=="oldest"){
                        $categoryProducts->orderby('products.id','Asc');
                    }else if($data['sort']=="lth"){
                        $categoryProducts->orderby('products.product_price','Asc');
                    }else if($data['sort']=="htl"){
                        $categoryProducts->orderby('products.product_price','Desc');
                    }else if($data['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
                    }else if($data['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
                    }else if($data['sort']=="popular"){
                        // $categoryProducts->where('products.is_popular','Yes');
                        $productIds = DB::table('products_enquiries')->select('product_id')->pluck('product_id')->toArray();
                        $allproductIds = DB::table('products')->select('id')->where('status',1)->where('is_delete',0)->whereNotin('id',$productIds)->pluck('id')->toArray();
                        $popularProductIds = array_merge($productIds,$allproductIds);
                        $ids_ordered = implode(',', $popularProductIds);
                        $categoryProducts->wherein('id',$popularProductIds)->orderByRaw("FIELD(products.id, $ids_ordered)");
                    }else if($data['sort']=="new-products"){
                        //$categoryProducts->where('products.is_new','Yes');
                        $categoryProducts->orderby('products.id','Desc')->limit(18);
                    }else if($data['sort']=="featured"){
                        $categoryProducts->where('products.is_featured','Yes');
                    }
                }

                // checking for Whole Norway
                if(isset($data['wholenorway']) && !empty($data['wholenorway'])){
                    if($data['wholenorway']=="Yes"){
                        $wholenorway = "all";
                    }else{
                        $wholenorway = "limited";
                    }
                    $categoryProducts->where('products.all_norway',$wholenorway);
                }

                // checking for Size
                if(isset($data['size']) && !empty($data['size'])){
                    $prosize = $data['size'];
                    $prosizes = explode('~',$prosize);
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size',$prosizes)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for City
                if(isset($data['city1']) && !empty($data['city1'])){
                    $procity = $data['city1'];
                    $procities = explode('~',$procity);
                    $productIds = Product::select('id')->whereIn('city',$procities)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for State
                if(isset($data['state1']) && !empty($data['state1'])){
                    $prostate = $data['state1'];
                    $prostates = explode('~',$prostate);
                    foreach ($prostates as $key => $state) {
                        $citiesCount = DB::table('cities')->where('state',$state)->count();
                        if($citiesCount>0){
                            $citiesData = DB::table('cities')->where('state',$state)->get();
                            foreach ($citiesData as $key => $city) {
                                $cities[] = $city->city;
                            }
                            $cities = array_unique($cities);
                        }
                    }
                    $productIds = Product::select('id')->whereIn('city',$cities)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for City
                if(isset($data['city']) && !empty($data['city'])){
                    $procity = $data['city'];
                    $procities = explode('~',$procity);
                    $productIds = ProductsCity::select('product_id')->whereIn('city',$procities)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for State
                if(isset($data['state']) && !empty($data['state'])){
                    $prostate = $data['state'];
                    $prostates = explode('~',$prostate);
                    foreach ($prostates as $key => $state) {
                        $citiesCount = DB::table('cities')->where('state',$state)->count();
                        if($citiesCount>0){
                            $citiesData = DB::table('cities')->where('state',$state)->get();
                            foreach ($citiesData as $key => $city) {
                                $cities[] = $city->city;
                            }
                            $cities = array_unique($cities);
                        }
                    }
                    $productIds = ProductsCity::select('product_id')->whereIn('city',$cities)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for Color
                /*if(isset($data['color']) && !empty($data['color'])){
                    $productIds = Product::select('id')->whereIn('product_color',$data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }*/

                // checking for Price
                /*if(isset($data['price']) && !empty($data['price'])){
                    foreach ($data['price'] as $key => $price) {
                        $priceArr = explode("-",$price);
                        $productIds[] = Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();
                    }
                    $productIds = call_user_func_array('array_merge', $productIds);
                    $categoryProducts->whereIn('products.id',$productIds);
                }*/

                // checking for Price
                /*$productIds = array();
                if(isset($data['price']) && !empty($data['price'])){
                    foreach ($data['price'] as $key => $price) {
                        $priceArr = explode("-",$price);
                        if(isset($priceArr[0]) && isset($priceArr[1])){
                            $productIds[] = Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();    
                        }
                    }
                    $productIds = array_unique(array_flatten($productIds));
                    $categoryProducts->whereIn('products.id',$productIds);
                }*/

                // checking for Brand
                /*if(isset($data['brand']) && !empty($data['brand'])){
                    $productIds = Product::select('id')->whereIn('brand_id',$data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }*/

                //Checking for categories
                if(isset($data['category']) && !empty($data['category'])){
                    $catids = explode('~',$data['category']);
                    $categoryProducts->wherein('products.category_id', $catids);
                }

                $categoryDetails['breadcrumbs'] = $sectionDetails['name'];
                $categoryDetails['categoryDetails']['name'] = $sectionDetails['name'];
                $categoryDetails['categoryDetails']['url'] = $sectionDetails['url'];
                $categoryDetails['categoryDetails']['description'] = "Listing for Section ".$sectionDetails['name'];

                $categoryProducts = $categoryProducts->get();
                $getproductscount = json_decode(json_encode($categoryProducts),true);
                $totalProducts = count($getproductscount);
                /*dd($categoryProducts);*/
                /*echo "Category exists"; die;*/
                /*return view('front.products.products_listing')->with(compact('categoryDetails','categoryProducts','url'));*/

                return response()->json([
                'view' => (String)View::make('front.products.products_listing')->with(compact('categoryDetails','categoryProducts','url','totalProducts')),
                    'totalProducts' => $totalProducts
                ]);


            }else{
                abort(404);
            }

        }else{

            $url = Route::getFacadeRoot()->current()->uri();
            $sectionCount = Section::where(['url'=>$url,'status'=>1])->count();
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if(isset($_REQUEST['q']) && !empty($_REQUEST['q'])){
                $search_product = $_REQUEST['q'];
                $categoryDetails['breadcrumbs'] = $search_product;
                $categoryDetails['categoryDetails']['name'] = $search_product;
                $categoryDetails['categoryDetails']['description'] = "Search Results for ".$search_product;
                $categoryProducts = Product::with('brand')->select('categories.*','categories.id as category_id','products.*','products.id as id')->join('categories','categories.id','=','products.category_id')->where(function($query)use($search_product){
                    $query->where('products.product_name','like','%'.$search_product.'%')
                    ->orWhere('products.product_code','like','%'.$search_product.'%')
                    /*->orWhere('products.product_color','like','%'.$search_product.'%')*/
                    ->orWhere('products.description','like','%'.$search_product.'%')
                    ->orWhere('categories.category_name','like','%'.$search_product.'%')
                    ->orWhere('products.keywords','like','%'.$search_product.'%');
                })->where('products.status',1)->where('products.is_delete',0);
                $categoryProducts = $categoryProducts->get();
                /*$categoryProducts = json_decode(json_encode($categoryProducts),true);
                echo "<pre>"; print_r($categoryProducts); die;*/
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts'));
            }else if($sectionCount>0){
                $sectionDetails = Section::where(['url'=>$url,'status'=>1])->first()->toArray();

                // Get Products           
                $categoryProducts = Product::with('brand')->where('section_id',$sectionDetails['id'])->where('status',1)->where('is_delete',0);

                // checking for Size
                if(isset($_GET['size']) && !empty($_GET['size'])){
                    $prosize = $_GET['size'];
                    $prosizes = explode('~',$prosize);
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size',$prosizes)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for Whole Norway
                if(isset($_GET['wholenorway']) && !empty($_GET['wholenorway'])){
                    if($_GET['wholenorway']=="Yes"){
                        $wholenorway = "all";
                    }else{
                        $wholenorway = "limited";
                    }
                    $categoryProducts->where('products.all_norway',$wholenorway);
                }

                // checking for City
                if(isset($_GET['city1']) && !empty($_GET['city1'])){
                    $procity = $_GET['city1'];
                    $procities = explode('~',$procity);
                    $productIds = Product::select('id')->whereIn('city',$procities)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for State
                if(isset($_GET['state1']) && !empty($_GET['state1'])){
                    $prostate = $_GET['state1'];
                    $prostates = explode('~',$prostate);
                    foreach ($prostates as $key => $state) {
                        $citiesCount = DB::table('cities')->where('state',$state)->count();
                        if($citiesCount>0){
                            $citiesData = DB::table('cities')->where('state',$state)->get();
                            foreach ($citiesData as $key => $city) {
                                $cities[] = $city->city;
                            }
                            $cities = array_unique($cities);
                        }
                    }
                    $productIds = Product::select('id')->whereIn('city',$cities)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for City
                if(isset($_GET['city']) && !empty($_GET['city'])){
                    $procity = $_GET['city'];
                    $procities = explode('~',$procity);
                    $productIds = ProductsCity::select('product_id')->whereIn('city',$procities)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for State
                if(isset($_GET['state']) && !empty($_GET['state'])){
                    $prostate = $_GET['state'];
                    $prostates = explode('~',$prostate);
                    foreach ($prostates as $key => $state) {
                        $citiesCount = DB::table('cities')->where('state',$state)->count();
                        if($citiesCount>0){
                            $citiesData = DB::table('cities')->where('state',$state)->get();
                            foreach ($citiesData as $key => $city) {
                                $cities[] = $city->city;
                            }
                            $cities = array_unique($cities);
                        }
                    }
                    $productIds = ProductsCity::select('product_id')->whereIn('city',$cities)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for Sort
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="newest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($_GET['sort']=="oldest"){
                        $categoryProducts->orderby('products.id','Asc');
                    }else if($_GET['sort']=="lth"){
                        $categoryProducts->orderby('products.product_price','Asc');
                    }else if($_GET['sort']=="htl"){
                        $categoryProducts->orderby('products.product_price','Desc');
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
                    }else if($_GET['sort']=="popular"){
                        //$categoryProducts->where('products.is_popular','Yes');
                        $productIds = DB::table('products_enquiries')->select('product_id')->pluck('product_id')->toArray();
                        $allproductIds = DB::table('products')->select('id')->where('status',1)->where('is_delete',0)->whereNotin('id',$productIds)->pluck('id')->toArray();
                        $popularProductIds = array_merge($productIds,$allproductIds);
                        $ids_ordered = implode(',', $popularProductIds);
                        $categoryProducts->wherein('id',$popularProductIds)->orderByRaw("FIELD(products.id, $ids_ordered)");
                    }else if($_GET['sort']=="new-products"){
                        //$categoryProducts->where('products.is_new','Yes');
                        $categoryProducts->orderby('products.id','Desc')->limit(18);
                    }else if($_GET['sort']=="featured"){
                        $categoryProducts->where('products.is_featured','Yes');
                    }
                }

                // checking for Price Range
                if(isset($_GET['range']) && !empty($_GET['range'])){
                    $prorange = $_GET['range'];
                    $proranges = explode('~',$prorange);
                    $productIds = Product::select('id')->whereIn('price_range',$proranges)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //Checking for categories
                if(isset($_GET['category']) && !empty($_GET['category'])){
                    $catids = explode('~',$_GET['category']);
                    $categoryProducts->wherein('products.category_id', $catids);
                }

                $categoryProducts = $categoryProducts->paginate(18);
                /*$categoryProducts = $categoryProducts->appends($request->except('page'));*/
                /*$categoryProducts = json_decode(json_encode($categoryProducts));
                echo "<pre>"; print_r($categoryProducts); die;*/
                /*dd($categoryProducts);*/
                $getproductscount = json_decode(json_encode($categoryProducts));
                $totalproducts = $getproductscount->total;

                $categoryDetails['breadcrumbs'] = $sectionDetails['name'];
                $categoryDetails['categoryDetails']['name'] = $sectionDetails['name'];
                $categoryDetails['categoryDetails']['url'] = $sectionDetails['url'];
                $categoryDetails['categoryDetails']['description'] = "Listing for Section ".$sectionDetails['name'];

                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url','totalproducts'));
            }else if($categoryCount>0){

                // Get Category Details
                $categoryDetails = Category::categoryDetails($url);            
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1)->where('is_delete',0);

                // checking for Whole Norway
                if(isset($_GET['wholenorway']) && !empty($_GET['wholenorway'])){
                    if($_GET['wholenorway']=="Yes"){
                        $wholenorway = "all";
                    }else{
                        $wholenorway = "limited";
                    }
                    $categoryProducts->where('products.all_norway',$wholenorway);
                }

                // checking for Size
                if(isset($_GET['size']) && !empty($_GET['size'])){
                    $prosize = $_GET['size'];
                    $prosizes = explode('~',$prosize);
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size',$prosizes)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for City
                if(isset($_GET['city1']) && !empty($_GET['city1'])){
                    $procity = $_GET['city1'];
                    $procities = explode('~',$procity);
                    $productIds = Product::select('id')->whereIn('city',$procities)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for State
                if(isset($_GET['state1']) && !empty($_GET['state1'])){
                    $prostate = $_GET['state1'];
                    $prostates = explode('~',$prostate);
                    foreach ($prostates as $key => $state) {
                        $citiesCount = DB::table('cities')->where('state',$state)->count();
                        if($citiesCount>0){
                            $citiesData = DB::table('cities')->where('state',$state)->get();
                            foreach ($citiesData as $key => $city) {
                                $cities[] = $city->city;
                            }
                            $cities = array_unique($cities);
                        }
                    }
                    $productIds = Product::select('id')->whereIn('city',$cities)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for City
                if(isset($_GET['city']) && !empty($_GET['city'])){
                    $procity = $_GET['city'];
                    $procities = explode('~',$procity);
                    $productIds = ProductsCity::select('product_id')->whereIn('city',$procities)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for State
                if(isset($_GET['state']) && !empty($_GET['state'])){
                    $prostate = $_GET['state'];
                    $prostates = explode('~',$prostate);
                    foreach ($prostates as $key => $state) {
                        $citiesCount = DB::table('cities')->where('state',$state)->count();
                        if($citiesCount>0){
                            $citiesData = DB::table('cities')->where('state',$state)->get();
                            foreach ($citiesData as $key => $city) {
                                $cities[] = $city->city;
                            }
                            $cities = array_unique($cities);
                        }
                    }
                    $productIds = ProductsCity::select('product_id')->whereIn('city',$cities)->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                // checking for Sort
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="newest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($_GET['sort']=="oldest"){
                        $categoryProducts->orderby('products.id','Asc');
                    }else if($_GET['sort']=="lth"){
                        $categoryProducts->orderby('products.product_price','Asc');
                    }else if($_GET['sort']=="htl"){
                        $categoryProducts->orderby('products.product_price','Desc');
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
                    }else if($_GET['sort']=="popular"){
                        //$categoryProducts->where('products.is_popular','Yes');
                        $productIds = DB::table('products_enquiries')->select('product_id')->pluck('product_id')->toArray();
                        $allproductIds = DB::table('products')->select('id')->where('status',1)->where('is_delete',0)->whereNotin('id',$productIds)->pluck('id')->toArray();
                        $popularProductIds = array_merge($productIds,$allproductIds);
                        $ids_ordered = implode(',', $popularProductIds);
                        $categoryProducts->wherein('id',$popularProductIds)->orderByRaw("FIELD(products.id, $ids_ordered)");
                    }else if($_GET['sort']=="new-products"){
                        //$categoryProducts->where('products.is_new','Yes');
                        $categoryProducts->orderby('products.id','Desc')->limit(18);
                    }else if($_GET['sort']=="featured"){
                        $categoryProducts->where('products.is_featured','Yes');
                    }
                }

                // checking for Price Range
                if(isset($_GET['range']) && !empty($_GET['range'])){
                    $prorange = $_GET['range'];
                    $proranges = explode('~',$prorange);
                    $productIds = Product::select('id')->whereIn('price_range',$proranges)->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                $categoryProducts = $categoryProducts->paginate(18);
                /*$categoryProducts = $categoryProducts->get()->toArray();*/

                /*dd($categoryDetails);*/

                $meta_title = $categoryDetails['categoryDetails']['meta_title'];
                $meta_description = $categoryDetails['categoryDetails']['meta_description'];
                $meta_keywords = $categoryDetails['categoryDetails']['meta_keywords'];

                /*echo "Category exists"; die;*/
                $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupby('name')->pluck('name');
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url','countries','meta_title','meta_description','meta_keywords'));
            }else{
                abort(404);
            }
        }  
    }

    public function detail($name,$id){

        $productCount = Product::where('id',$id)->where('status',1)->where('is_delete',0)->count(); 
        if($productCount==0){
            abort(404);
        }

        // Update Product Count
        Product::where('id',$id)->increment('count');
        
        $productDetails = Product::with(['section','category','brand','attributes'=>function($query){
            $query->where('stock','>',0)->where('status',1);
        },'images','vendor'])->find($id)->toArray();
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        /*dd($productDetails);*/

        Session::put('product_id',$id);

        // Get Similar Products
        $similarProducts = Product::with('brand')->where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->where('status',1)->where('is_delete',0)->limit(4)->inRandomOrder()->get()->toArray();
        /*dd($similarProducts);*/

        // Set Session for Recently Viewed Products
        if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(), true));
        }else{
            $session_id = Session::get('session_id');
        }

        Session::put('session_id',$session_id);

        // Insert product in table if not already exists
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRecentlyViewedProducts==0){
            DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id]);
        }

        // Get Recently Viewed Products Ids
        $recentProductsIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
        /*dd($recentProductsIds);*/


        // Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('brand')->whereIn('id',$recentProductsIds)->where('status',1)->where('is_delete',0)->get()->toArray();
        /*dd($recentlyViewedProducts);*/

        // Get Group Products (Product Colors)
        $groupProducts = array();
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id','product_image')->where('id','!=',$id)->where(['group_code'=>$productDetails['group_code'],'status'=>1])->where('is_delete',0)->get()->toArray();
            /*dd($groupProducts);*/
        }


        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');

        // Get All Ratings of product 
        $ratings = Rating::with('user')->where(['product_id'=>$id,'status'=>1])->get()->toArray();
        
        // Get Average Rating of product
        $ratingSum = Rating::where(['product_id'=>$id,'status'=>1])->sum('star_rating');
        $ratingCount = Rating::where(['product_id'=>$id,'status'=>1])->count();

        $avgRating = 0;
        $avgStarRating = 0;

        if($ratingCount>0){
            $avgRating = round($ratingSum/$ratingCount,2);
            $avgStarRating = round($ratingSum/$ratingCount);
        }

        //Reviews
        $reviews = Rating::with(['user','product'])->where('status','1')->where('product_id',$productDetails['id'])->get();
        if($reviews->count() > 0){
            $reviews = json_decode(json_encode($reviews), true);
        }

        $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupby('name')->pluck('name');

        $productStates = DB::table('products_states')->select('state')->where('product_id',$id)->get()->pluck('state'); 
        //dd($productStates);
        $productCities = DB::table('products_cities')->where('product_id',$id)->whereNotin('state',$productStates)->get()->toArray();
        $productCities = json_decode(json_encode($productCities),true);
        //dd($productCities); 

        return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recentlyViewedProducts','groupProducts','reviews','avgRating','avgStarRating','ratingCount','countries','productStates','productCities'));
    }

    public function detailReview($name,$id){

        $productCount = Product::where('id',$id)->count(); 
        if($productCount==0){
            abort(404);
        }
        
        $productDetails = Product::with(['section','category','brand','attributes'=>function($query){
            $query->where('stock','>',0)->where('status',1);
        },'images','vendor'])->where('is_delete',0)->find($id)->toArray();
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        /*dd($productDetails);*/

        Session::put('product_id',$id);

        // Get Similar Products
        $similarProducts = Product::with('brand')->where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->where('status',1)->where('is_delete',0)->limit(4)->inRandomOrder()->get()->toArray();
        /*dd($similarProducts);*/

        // Set Session for Recently Viewed Products
        if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(), true));
        }else{
            $session_id = Session::get('session_id');
        }

        Session::put('session_id',$session_id);

        // Insert product in table if not already exists
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRecentlyViewedProducts==0){
            DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id]);
        }

        // Get Recently Viewed Products Ids
        $recentProductsIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
        /*dd($recentProductsIds);*/


        // Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('brand')->whereIn('id',$recentProductsIds)->where('status',1)->where('is_delete',0)->get()->toArray();
        /*dd($recentlyViewedProducts);*/

        // Get Group Products (Product Colors)
        $groupProducts = array();
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id','product_image')->where('id','!=',$id)->where(['group_code'=>$productDetails['group_code'],'status'=>1])->where('is_delete',0)->get()->toArray();
            /*dd($groupProducts);*/
        }


        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');

        // Get All Ratings of product 
        $ratings = Rating::with('user')->where(['product_id'=>$id,'status'=>1])->get()->toArray();
        
        // Get Average Rating of product
        $ratingSum = Rating::where(['product_id'=>$id,'status'=>1])->sum('star_rating');
        $ratingCount = Rating::where(['product_id'=>$id,'status'=>1])->count();

        $avgRating = 0;
        $avgStarRating = 0;

        if($ratingCount>0){
            $avgRating = round($ratingSum/$ratingCount,2);
            $avgStarRating = round($ratingSum/$ratingCount);
        }

        //Reviews
        $reviews = Rating::with(['user','product'])->where('status','1')->where('product_id',$productDetails['id'])->get();
        if($reviews->count() > 0){
            $reviews = json_decode(json_encode($reviews), true);
        }

        $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupby('name')->pluck('name');

        $productStates = DB::table('products_states')->select('state')->where('product_id',$id)->get()->pluck('state'); 
        //dd($productStates);
        $productCities = DB::table('products_cities')->where('product_id',$id)->whereNotin('state',$productStates)->get()->toArray();
        $productCities = json_decode(json_encode($productCities),true);
        //dd($productCities);

        return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recentlyViewedProducts','groupProducts','reviews','avgRating','avgStarRating','ratingCount','countries','productStates','productCities'));
    }

    public function selectCategory(){
        $categories = Section::with('categories')->where('id',2)->get()->toArray();
        /*dd($categories);*/
        $products = array();
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }]);
        $products = $products->where('user_id',Auth::user()->id)->where('is_delete',0);
        $products = $products->get()->toArray();
        return view('front.users.select_category')->with(compact('categories','products'));
    }

    public function addProduct(Request $request, $id){
        $category_id = $id;
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo $id; echo "--";
            echo "<pre>"; print_r($data); die;*/

            $rules = [
                'category_id' => 'required',
                /*'product_name' => 'required|regex:/^[\pL\s\-]+$/u',*/
                'product_name' => 'required',
                'description' => 'required',
                'city' => 'required',
                'product_price' => 'required|numeric',
                'images' => 'required',
            ];

            $customMessages = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'Valid Product Price is required',
            ];

            $this->validate($request,$rules,$customMessages);

            // Save Product details in products table
            $categoryDetails = Category::find($data['category_id']);

            $product = new Product;
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];

            $adminType = 'user';
            $vendor_id = 0;
            $admin_id = 0;
            $user_id = Auth::user()->id;

            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;
            $product->vendor_id = $vendor_id;
            $product->user_id = $user_id;

            $product->product_name = $data['product_name'];
            $product->product_price = $data['product_price'];
            $product->product_discount = 0;
            $product->product_weight = 0;
            $product->description = $data['description'];

            // for categories
            $product->city = $data['city'];

            $product->status = 0;

            $product->save();
            $product_id = DB::getPdo()->lastInsertId();
            // Upload Product Images after Resize small: 250x250 medium: 500x500 large: 1000x1000
            if($request->hasFile('images')){

                $images = $request->file('images');
                /*echo "<pre>"; print_r($images); die;*/
                foreach ($images as $key => $image) {
                    // Generate Temp Image
                    $image_tmp = Image::make($image);
                    // Get Image Name
                    $image_name = $image->getClientOriginalName();
                    // Get Image Extension
                    $extension = $image->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = 'ad-image'.rand(111,99999).'.'.$extension;
                    if($key==0){
                        $mainImagename = $imageName;
                    }
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload the Large, Medium and Small Images after Resize
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);
                    // Insert Image Name in products table
                    $image = new ProductsImage; 
                    $image->image = $imageName;
                    $image->product_id = $product_id;
                    $image->status = 1;
                    $image->save();
                }
            }


            // Update Image Name in products table
            Product::where('id',$product_id)->update(['product_image'=>$mainImagename]);
            $message = "Item added successfully and will approve by admin soon!";
            return redirect()->back()->with('success_message',$message);
        }
        $products = array();
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }]);
        $products = $products->where('user_id',Auth::user()->id)->where('is_delete',0);
        $products = $products->get()->toArray();
        /*dd($products);*/
        return view('front.users.add_product')->with(compact('category_id','products'));
    }

    public function editProduct(Request $request, $id){
        $product_id = $id;
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo $id; echo "--";
            echo "<pre>"; print_r($data); die;*/

            $rules = [
                /*'product_name' => 'required|regex:/^[\pL\s\-]+$/u',*/
                'product_name' => 'required',
                'description' => 'required',
                'city' => 'required',
                'product_price' => 'required|numeric',
            ];

            $customMessages = [
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'Valid Product Price is required',
            ];

            $this->validate($request,$rules,$customMessages);

            // Update Product details in products table

            $product = Product::find($id);
            $product->product_name = $data['product_name'];
            $product->product_price = $data['product_price'];
            $product->description = $data['description'];
            $product->city = $data['city'];
            $product->status = 0;
            $product->save();
            $message = "Item updated successfully and will approve by admin soon!";
            return redirect()->back()->with('success_message',$message);
        }
        $products = array();
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }]);
        $products = $products->where('user_id',Auth::user()->id)->where('is_delete',0);
        $products = $products->get()->toArray();
        /*dd($products);*/
        $productDetails = Product::where('id',$id)->first()->toArray();
        return view('front.users.edit_product')->with(compact('products','product_id','productDetails'));
    }

    public function deleteProduct($id){
        // Delete Product
        Product::where('id',$id)->update(['is_delete'=>1]);
        $message = "Product has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }

    public function writeReview(Request $request){ 
        if(!Auth::check()){
            return redirect()->back()->with('flash_message_error','Please login to add review for this');
        }else{
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
    
            $validator = Validator::make($request->all(), [
                'rating' => 'required',
                /*'review_name' => 'required|regex:/^[a-zA-Z ]+$/u|max:255',*/
                'review_title' => 'required|regex:/^[a-zA-Z ]+$/u|max:255',
                /*'review_email' => 'required|email',*/
                'review_description' => 'required'
            ], [
                'rating.required' => 'Please select stars to rate product.',
                /*'review_name.required' => 'Please enter name',*/
                'review_title.required' => 'Please enter Review Title',
                /*'review_email.email' => 'Please enter valid email.',*/
                'review_description' => 'Please enter Review Description.',
            ]);
            if($validator->passes()) {
                if($data['product_id'] != "" && $data['review_title'] != "" && $data['review_description'] !="" && $data['rating'] != ""){

                    // Check if review already exists
                    $reviewCount = Rating::where(['user_id'=>Auth::user()->id,'product_id'=>$data['product_id']])->count();
                    if($reviewCount>0){
                        return redirect()->back()->with('error_message', 'You have already submitted review for this.');
                    }else{
                        $star_rating = new Rating;
                        $star_rating->product_id = $data['product_id'];
                        $star_rating->user_id = Auth::user()->id;
                        $star_rating->review_title = $data['review_title'];
                        $star_rating->review_description = $data['review_description'];
                        $star_rating->star_rating = $data['rating'];

                        // Upload Review Image
                        if($request->hasFile('image')){
                            $image_tmp = $request->file('image');
                            if($image_tmp->isValid()){
                                // Get Image Extension
                                $extension = $image_tmp->getClientOriginalExtension();
                                // Generate New Image Name
                                $imageName = rand(111,99999).'.'.$extension;
                                $imagePath = 'front/images/reviews_images/'.$imageName;
                                // Upload the Image
                                Image::make($image_tmp)->save($imagePath);
                                $star_rating->image = $imageName;
                            }
                        }

                        $star_rating->save();
                        return redirect()->back()->with('success_message', 'Thanks for adding review. It will be shown once approved.');    
                    }                    
                }else{
                    return redirect()->back()->with('error_message', 'Please enter required information to submit review.');
                } 
            }else{
                return redirect()->back()->with('errors',$validator->messages());
            }      
        }
    }

    public function addtoWishlist(Request $request){
        if($request->ajax()){
            if(Auth::check()){
                $data = $request->all();
                $checkifExits = Wishlist::where([
                    'user_id'=>Auth::user()->id,
                    'product_id' => $data['proid']
                ])->count();
                if($checkifExits ==0){
                    $wishlist = new Wishlist;
                    $wishlist->user_id = Auth::user()->id;
                    $wishlist->product_id = $data['proid'];
                    $wishlist->save();
                    return response()->json(['status'=>true,'message'=>'set']);
                }else{
                    Wishlist::where([
                        'user_id'=>Auth::user()->id,
                        'product_id' => $data['proid']
                    ])->delete();
                    return response()->json(['status'=>true,'message'=>'unset']);
                }
            }else{
                return response()->json(['status'=>false,'message'=>'Vennligst logg inn for å legge til favoritter.']);
            }
        }
    }

}
