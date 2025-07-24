<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use App\Models\ProductsFilter;
use App\Models\ProductsCity;
use App\Models\ProductsState;
use App\Models\VendorsCategory;
use App\Models\Vendor;
use App\Models\City;
use Session;
use Auth;
use Image;
use DB;

class ProductsController extends Controller
{
    public function products(){
        Session::put('page','products');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Din leverandør-konto er foreløpig inaktiv.');
                /*Please make sure to fill your valid personal, business and bank details*/
            }
        }
        $products = Product::with(['vendor','section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }]);
        if($adminType=="vendor"){
            $products = $products->where('vendor_id',$vendor_id);
        }
        $products = $products->where('admin_type','!=','user');
        $products = $products->where('section_id','!=',2);
        $products = $products->where('is_delete',0);
        if($adminType=="vendor"){
            $products = $products->orderby('id','Desc')->get()->toArray();
        }else{
            $products = $products->get()->toArray();    
        }
        
        /*dd($products);*/
        /*echo "<pre>"; print_r($products); die;*/
        return view('admin.products.products')->with(compact('products'));
    }

    public function reusedProducts(){
        Session::put('page','reused_products');
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType=="vendor"){
            return redirect("admin/dashboard")->with('error_message','This feature is restricted for you!');
        }
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }]);
        $products = $products->where('admin_type','user');
        $products = $products->get()->toArray();
        /*dd($products);*/
        return view('admin.products.reused_products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProduct($id){
        // Delete Product
        // Product::where('id',$id)->delete();
        Product::where('id',$id)->update(['is_delete'=>1,'status'=>0]);
        $message = "Product has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditProduct(Request $request, $id=null){
        ini_set('memory_limit','256M');
        Session::put('page','products');
        if($id==""){
            $title = "Ny annonse";
            $product = new Product;
            $message = "Din annonse kontrolleres og du vil snart høre fra oss.";
        }else{
            $title = "Endre annonse";
            $product = Product::find($id);
            /*echo "<pre>"; print_r($product); die;*/
            $message = "Profil-opplysninger endret";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

           Session::put('category_id',$data['category_id']);
           Session::put('product_name',$data['product_name']);
           if(!empty($data['address'])){
                Session::put('address',$data['address']);
           }
           if(!empty($data['pincode'])){
                Session::put('pincode',$data['pincode']);
           }
           if(!empty($data['description'])){
                Session::put('description',$data['description']);
           }
           if(!empty($data['keywords'])){
                Session::put('keywords',$data['keywords']);
           }
           Session::put('city',$data['city']);
           Session::put('state',$data['state']);
           Session::put('price_range',$data['price_range']);

            $rules = [
                'category_id' => 'required',
                /*'product_name' => 'required|regex:/^[\pL\s\-]+$/u',*/
                'product_name' => 'required',
                'product_image'  => 'max:20000|mimes:jpeg,bmp,png',
                'product_banner'  => 'max:20000|mimes:jpeg,bmp,png',
                'product_video'  => 'max:50000|mimes:mp4,mov',
                'images.*'  => 'max:20000|mimes:jpeg,bmp,png'
                /*'product_price' => 'required|numeric',*/
            ];

            $customMessages = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                /*'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'Valid Product Price is required',*/
            ];

            $this->validate($request,$rules,$customMessages);

            DB::beginTransaction();

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;

            if($id=="" && $adminType=="vendor"){
                $getPlanDetails = Vendor::getPlanDetails($vendor_id);
                $vendorProductsCount = Vendor::vendorProductsCount($vendor_id);

                /*echo $getPlanDetails['products_limit'];
                echo "--";
                echo $vendorProductsCount; die;*/

                if($getPlanDetails['products_limit']<=$vendorProductsCount){
                    $code = base64_encode(Auth::guard('admin')->user()->email);
                    $message = "Vennligst <a href='/admin/vendor/plans/upgrade/'.$code.''>oppgrader</a> ditt abonnement for å legge til flere leverandør-profiler";
                    return redirect()->back()->with('error_message',$message);
                }
            }

            /*

            // Upload Product Image after Resize small: 250x250 medium: 500x500 large: 1000x1000
            if($request->hasFile('product_image')){
                $image_tmp = $request->file('product_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(1111,999999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload the Large, Medium and Small Images after Resize
                    //Image::make($image_tmp)->resize(1000,500)->save($largeImagePath, 50);
                    Image::make($image_tmp)->save($largeImagePath, 50);
                    Image::make($image_tmp)->resize(500,250)->save($mediumImagePath, 50);
                    Image::make($image_tmp)->resize(250,125)->save($smallImagePath, 50);
                    // Insert Image Name in products table
                    //$product->product_image = $imageName;
                }
            }else if(!empty($data['current_product_image'])){
                $imageName = $data['current_product_image'];
            }else{
                $imageName = "";
            }
            // Insert Image Name in products table
            $product->product_image = $imageName;

            // Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    // Upload Video in videos folder
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111,99999).'.'.$extension;
                    $videoPath = 'front/videos/product_videos/';
                    $video_tmp->move($videoPath,$videoName);
                    // Insert Video name in products table
                    $product->product_video = $videoName;
                }
            }

            // Upload Product Banner
            if($request->hasFile('product_banner')){
                $image_tmp = $request->file('product_banner');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/product_banners/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath, 50);
                    $product->product_banner = $imageName;
                }
            }

            */

            // Save Product details in products table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            /*$product->group_code = $data['group_code'];*/

            $productFilters = ProductsFilter::productFilters();
            foreach($productFilters as $filter){
                /*echo $data[$filter['filter_column']]; die;*/
                $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$data['category_id']);
                if($filterAvailable=="Yes"){
                    if(isset($filter['filter_column']) && $data[$filter['filter_column']]){
                        $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                    }
                }
            }

            if($id==""){
                $product->admin_type = $adminType;
                $product->admin_id = $admin_id;
                if($adminType=="vendor"){
                    $product->vendor_id = $vendor_id;
                }else{
                    $product->vendor_id = 0;    
                }
            }

            if(empty($data['product_discount'])){
                $data['product_discount'] = 0;
            }

            if(empty($data['product_weight'])){
                $data['product_weight'] = 0;
            }

            if(empty($data['product_price'])){
                $data['product_price'] = 0;
            }

            $product->product_name = $data['product_name'];
            /*$product->product_code = $data['product_code'];*/
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->price_range = $data['price_range'];
            $product->keywords = $data['keywords'];
            /*$product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];*/

            // for categories
            $product->city = $data['city'];
            $product->state = $data['state'];
            $product->address = $data['address'];
            $product->pincode = $data['pincode'];
            $product->radius = $data['radius'];

            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            if(!empty($data['is_popular'])){
                $product->is_popular = $data['is_popular'];
            }else{
                $product->is_popular = "No";
            }
            if(!empty($data['is_new'])){
                $product->is_new = $data['is_new'];
            }else{
                $product->is_new = "No";
            }
            if($id==""){
                $product->status = 0;
            }else{
                /*$product->status = 1;*/
            }
            if(!empty($data['all_norway'])){
                $product->all_norway = $data['all_norway'];
            }
            $product->save();
            if($id==""){
                $product_id = DB::getPdo()->lastInsertId();

                if($adminType=="vendor"){
                    // Send Email to Admin (New Profile)
                    $email = array("admin@samling.no");
                    $messageData = ['name'=>Auth::guard('admin')->user()->name,'product_name'=>$data['product_name']];
                    Mail::send('emails.new_profile',$messageData,function($message)use($email,$data){
                        $message->to($email)->subject('Ny annonse - '.$data['product_name']);
                    });
                }

            }else{
                $product_id = $id;
                
                /*if($adminType=="vendor"){
                    // Send Email to Admin (Edit Profile)
                    $email = array("admin@samling.no");
                    $messageData = ['name'=>Auth::guard('admin')->user()->name,'product_name'=>$data['product_name']];
                    Mail::send('emails.update_profile',$messageData,function($message)use($email,$data){
                        $message->to($email)->subject('Profile Updated - '.$data['product_name']);
                    });
                }*/
            }

            /*

            // Upload Alt Images
            if($request->hasFile('images')){
                $images = $request->file('images');
                foreach ($images as $key => $image) {
                    // Generate Temp Image
                    $image_tmp = Image::make($image);
                    // Get Image Name
                    $image_name = $image->getClientOriginalName();
                    // Get Image Extension
                    $extension = $image->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = 'item-'.rand(1111,999999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload the Large, Medium and Small Images after Resize
                    // Image::make($image_tmp)->resize(1000,500)->save($largeImagePath, 50);
                    Image::make($image_tmp)->save($largeImagePath, 50);
                    Image::make($image_tmp)->resize(500,250)->save($mediumImagePath, 50);
                    Image::make($image_tmp)->resize(250,125)->save($smallImagePath, 50);
                    // Insert Image Name in products table
                    $image = new ProductsImage; 
                    $image->image = $imageName;
                    $image->product_id = $product_id;
                    $image->status = 1;
                    $image->save();
                }
            }

            if($id!=""){
                if(isset($data['image'])){
                    foreach ($data['image'] as $ikey => $image) {
                        ProductsImage::where(['product_id'=>$id,'image'=>$image])->update(['title'=>$data['title'][$ikey]]);
                    }
                }
            }

            */ 

            if(isset($data['all_norway'])&&$data['all_norway']=="limited"){
                // Delete earlier States of Product
                ProductsState::where('product_id',$product_id)->delete();
                // Update states for Product
                if(isset($data['states']) && count($data['states'])>0){
                    /*foreach ($data['states'] as $key => $state) {
                        $procity = new ProductsState;
                        $procity->product_id = $product_id;
                        $procity->state = $state;
                        $procity->save();
                    }*/  
                    $data_to_insert = [];
                    foreach ($data['states'] as $keys => $state)
                    {
                        array_push($data_to_insert, [
                                'product_id' => $product_id,
                                'state' => $state,
                        ]);
                    }
                    DB::table('products_states')->insert($data_to_insert);  
                }
              
                // Delete earlier Cities of Product
                ProductsCity::where('product_id',$product_id)->delete();
                // Update Cities for Product
                if(isset($data['cities']) && count($data['cities'])>0){
                    $data_to_insert = [];
                    foreach ($data['cities'] as $keyc => $city)
                    {
                        $getState = City::getState($city);
                        array_push($data_to_insert, [
                                'product_id' => $product_id,
                                'state' => $getState,
                                'city' => $city,
                        ]);
                    }
                    DB::table('products_cities')->insert($data_to_insert);

                    /*foreach ($data['cities'] as $key => $city) {
                        $procity = new ProductsCity;
                        $procity->product_id = $product_id;
                        $getState = City::getState($city);
                        $procity->state = $getState;
                        $procity->city = $city;
                        $procity->save();
                    }*/
                }  
            }else{

                $cities = DB::table('cities')->select('city')->where('status',1)->groupby('city')->pluck('city');
                $states = DB::table('cities')->select('state')->where('status',1)->groupby('state')->pluck('state');

                // Delete earlier States of Product
                ProductsState::where('product_id',$product_id)->delete();

                // Update states for Product
                if(isset($states) && count($states)>0){  
                    $data_to_insert = [];
                    foreach ($states as $keys => $state)
                    {
                        array_push($data_to_insert, [
                                'product_id' => $product_id,
                                'state' => $state,
                        ]);
                    }
                    DB::table('products_states')->insert($data_to_insert);  
                }
              
                // Delete earlier Cities of Product
                ProductsCity::where('product_id',$product_id)->delete();

                // Update Cities for Product
                if(isset($cities) && count($cities)>0){
                    $data_to_insert = [];
                    foreach ($cities as $keyc => $city)
                    {
                        $getState = City::getState($city);
                        array_push($data_to_insert, [
                                'product_id' => $product_id,
                                'state' => $getState,
                                'city' => $city,
                        ]);
                    }
                    DB::table('products_cities')->insert($data_to_insert);
                }      
            }

           Session::forget('category_id');
           Session::forget('product_name');
           Session::forget('address');
           Session::forget('pincode');
           Session::forget('city');
           Session::forget('price_range');
           Session::forget('description');
           Session::forget('keywords');

            DB::Commit();
            
            //return redirect('admin/products')->with('success_message',$message);
            return redirect('admin/add-images/'.$product_id)->with('success_message',$message);
        }

        /*echo "<pre>"; print_r(Auth::guard('admin')->user()->vendor_id); die;*/
        if(isset(Auth::guard('admin')->user()->type) && Auth::guard('admin')->user()->type=="vendor"){
            /*$getVendorCategories = VendorsCategory::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->pluck('category_id')->toArray();
            // Get Sections with Categories and Sub Categories
            $categories = Section::with(['categories'=>function($query)use($getVendorCategories){
                $query->whereIn('id',$getVendorCategories);
            }])->get()->toArray();*/
            $categories = Section::with('categories')->where('id',1)->get()->toArray();
            /*dd($categories);*/
        }else{
            $categories = Section::with('categories')->get()->toArray();  
            /*dd($categories);*/
        }
        

        $states = DB::table('cities')->select('state','city')->groupby('state','city')->orderby('state','ASC')->orderby('city','ASC')->get();
        $states = json_decode(json_encode($states),true);
        $selStates = \App\Models\ProductsState::where('product_id',$id)->pluck('state')->toArray();
        $selCities = \App\Models\ProductsCity::where('product_id',$id)->pluck('city')->toArray();
        $statesWithCities = [];
        $index = 0;
        foreach($states as $row){
            $statesWithCities[$row['state']]['state_selected'] = false;
            if(in_array($row['state'],$selStates)){
                $statesWithCities[$row['state']]['state_selected'] = true;
            }
            $statesWithCities[$row['state']]['cities'][$index]['city'] = $row['city'];
            $statesWithCities[$row['state']]['cities'][$index]['city_selected'] = false;
            if(in_array($row['city'],$selCities)){
                $statesWithCities[$row['state']]['cities'][$index]['city_selected'] = true;
            }
            $index++;
        }
        //echo "<pre>"; print_r($statesWithCities); die;

        // Get All Brands
        $brands = Brand::where('status',1)->get()->toArray();
        $cities = DB::table('cities')->select('city')->where('status',1)->groupby('city')->pluck('city');
        $states = DB::table('cities')->select('state')->where('status',1)->groupby('state')->pluck('state');
        $vendorDetails = array();
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType=="vendor"){
            $vendorDetails = Vendor::with('plan')->where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            $getPlanDetails = Vendor::getPlanDetails(Auth::guard('admin')->user()->vendor_id);
        }else{
            $getPlanDetails = array();  
        }
        //dd($states);
        return view('admin.products.add_edit_product')->with(compact('title','categories','brands','product','cities','states','vendorDetails','getPlanDetails','statesWithCities'));
    }

    public function addEditReusedProduct(Request $request, $id=null){
        Session::put('page','products');
        if($id==""){
            $title = "Add Item";
            $product = new Product;
            $message = "Item added successfully!";
        }else{
            $title = "Edit Item";
            $product = Product::find($id);
            /*echo "<pre>"; print_r($product); die;*/
            $message = "Item updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $rules = [
                'category_id' => 'required',
                /*'product_name' => 'required|regex:/^[\pL\s\-]+$/u',*/
                'product_name' => 'required',
                'product_price' => 'required|numeric',
            ];

            $customMessages = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'Valid Product Price is required',
            ];

            $this->validate($request,$rules,$customMessages);

            // Upload Product Image after Resize small: 250x250 medium: 500x500 large: 1000x1000
            if($request->hasFile('product_image')){
                $image_tmp = $request->file('product_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(1111,999999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload the Large, Medium and Small Images after Resize
                    // Image::make($image_tmp)->resize(1000,500)->save($largeImagePath);
                    Image::make($image_tmp)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,250)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,125)->save($smallImagePath);
                    // Insert Image Name in products table
                    /*$product->product_image = $imageName;*/
                }
            }else if(!empty($data['current_product_image'])){
                $imageName = $data['current_product_image'];
            }else{
                $imageName = "";
            }
            // Insert Image Name in products table
            $product->product_image = $imageName;

            // Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    // Upload Video in videos folder
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111,99999).'.'.$extension;
                    $videoPath = 'front/videos/product_videos/';
                    $video_tmp->move($videoPath,$videoName);
                    // Insert Video name in products table
                    $product->product_video = $videoName;
                }
            }

            // Save Product details in products table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->group_code = $data['group_code'];

            $productFilters = ProductsFilter::productFilters();
            foreach($productFilters as $filter){
                /*echo $data[$filter['filter_column']]; die;*/
                $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$data['category_id']);
                if($filterAvailable=="Yes"){
                    if(isset($filter['filter_column']) && $data[$filter['filter_column']]){
                        $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                    }
                }
            }

            if(empty($data['product_discount'])){
                $data['product_discount'] = 0;
            }

            if(empty($data['product_weight'])){
                $data['product_weight'] = 0;
            }

            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];

            // for categories
            $product->city = $data['city'];

            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            if(!empty($data['is_popular'])){
                $product->is_popular = $data['is_popular'];
            }else{
                $product->is_popular = "No";
            }
            $product->status = 1;
            $product->save();
            return redirect('admin/reused-products')->with('success_message',$message);
        }

        /*echo "<pre>"; print_r(Auth::guard('admin')->user()->vendor_id); die;*/
        if(isset(Auth::guard('admin')->user()->type) && Auth::guard('admin')->user()->type=="vendor"){
            /*$getVendorCategories = VendorsCategory::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->pluck('category_id')->toArray();
            // Get Sections with Categories and Sub Categories
            $categories = Section::with(['categories'=>function($query)use($getVendorCategories){
                $query->whereIn('id',$getVendorCategories);
            }])->get()->toArray();*/
            $categories = Section::with('categories')->get()->toArray();
            /*dd($categories);*/
        }else{
            $categories = Section::with('categories')->get()->toArray();  
            /*dd($categories);*/
        }
        

        // Get All Brands
        $brands = Brand::where('status',1)->get()->toArray();

        return view('admin.products.add_edit_reused_product')->with(compact('title','categories','brands','product'));
    }

    public function deleteProductImage($id){
        // Get product image
        $productImage = Product::select('product_image')->where('id',$id)->first();

        // Get Product Image Paths
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';
    
        // Delete Product small image if exists in small folder
        if(file_exists($small_image_path.$productImage->product_image)){
            unlink($small_image_path.$productImage->product_image);
        }

        // Delete Product medium image if exists in medium folder
        if(file_exists($medium_image_path.$productImage->product_image)){
            unlink($medium_image_path.$productImage->product_image);
        }

        // Delete Product large image if exists in large folder
        if(file_exists($large_image_path.$productImage->product_image)){
            unlink($large_image_path.$productImage->product_image);
        }

        // Delete Product image from products table
        Product::where('id',$id)->update(['product_image'=>'']);

        $message = "Bildet er slettet";
        return redirect()->back()->with('success_message',$message);

    }

    public function deleteProductBanner($id){
        // Get product banner
        $productBanner= Product::select('product_banner')->where('id',$id)->first();

        // Get Product Banner Path
        $banner_path = 'front/images/product_banners/';
    
        // Delete Product Banner if exists in folder
        if(file_exists($banner_path.$productBanner->product_banner)){
            unlink($banner_path.$productBanner->product_banner);
        }

        // Delete Product Banner from products table
        Product::where('id',$id)->update(['product_banner'=>'']);

        $message = "Product Banner has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }


    public function deleteProductVideo($id){
        // Get Product Video
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        // Get Product Video Path
        $product_video_path = 'front/videos/product_videos/';

        // Delete Product Video from product_videos folder if exists
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }

        // Delete Product Video Image from products table
        Product::where('id',$id)->update(['product_video'=>'']);

        $message = "Product Video has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);

    }

    public function addAttributes(Request $request, $id){
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_price','product_image')->with('attributes')->find($id);
        /*$product = json_decode(json_encode($product),true);
        dd($product);*/
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            foreach ($data['sku'] as $key => $value) {
                if(!empty($value)){

                    // SKU duplicate check
                    $skuCount = ProductsAttribute::where('sku',$value)->count();
                    if($skuCount>0){
                        return redirect()->back()->with('error_message','SKU already exists! Please add another SKU!');    
                    }

                    // Size duplicate check
                    $sizeCount = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($sizeCount>0){
                        return redirect()->back()->with('error_message','Size already exists! Please add another Size!');    
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }

            return redirect()->back()->with('success_message','Product Attributes has been added successfully!');
        }

        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }

    public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function editAttributes(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            foreach ($data['attributeId'] as $key => $attribute) {
                if(!empty($attribute)){
                    ProductsAttribute::where(['id'=>$data['attributeId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
                }
            }
            return redirect()->back()->with('success_message','Product Attributes has been updated successfully!');
        }
    }

    public function addImagesOld($id, Request $request){
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_price','product_image')->with('images')->find($id); 

        if($request->isMethod('post')){
            $data = $request->all();
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
                    $imageName = 'item-'.rand(1111,999999).'.'.$extension;
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
                    $image->product_id = $id;
                    $image->status = 1;
                    $image->save();
                }
            }
            return redirect()->back()->with('success_message','Product Images has been added successfully!');
        }

        return view('admin.images.add_images')->with(compact('product'));
    }

    public function addImages($id, Request $request){
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_price','product_image','product_video','product_banner')->with('images')->find($id); 

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'product_image'  => 'max:20000|mimes:jpeg,bmp,png',
                'product_banner'  => 'max:20000|mimes:jpeg,bmp,png',
                'product_video'  => 'max:50000|mimes:mp4,mov',
                'images.*'  => 'max:20000|mimes:jpeg,bmp,png'
                /*'product_price' => 'required|numeric',*/
            ];

            $customMessages = [
                
            ];

            $this->validate($request,$rules,$customMessages);

            // Upload Product Image after Resize small: 250x250 medium: 500x500 large: 1000x1000
            if($request->hasFile('product_image')){
                $image_tmp = $request->file('product_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(1111,999999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload the Large, Medium and Small Images after Resize
                    //Image::make($image_tmp)->resize(1000,500)->save($largeImagePath, 50);
                    Image::make($image_tmp)->save($largeImagePath, 70);
                    Image::make($image_tmp)->resize(500,250)->save($mediumImagePath, 70);
                    Image::make($image_tmp)->resize(250,125)->save($smallImagePath, 70);
                    // Insert Image Name in products table
                    /*$product->product_image = $imageName;*/
                }
            }else if(!empty($data['current_product_image'])){
                $imageName = $data['current_product_image'];
            }else{
                $imageName = "";
            }
            // Update Image Name in products table
            Product::where('id',$id)->update(['product_image'=>$imageName]);

            // Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    // Upload Video in videos folder
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111,99999).'.'.$extension;
                    $videoPath = 'front/videos/product_videos/';
                    $video_tmp->move($videoPath,$videoName);
                    // Update Video name in products table
                    Product::where('id',$id)->update(['product_video'=>$videoName]);
                }
            }

            // Upload Product Banner
            if($request->hasFile('product_banner')){
                $image_tmp = $request->file('product_banner');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/product_banners/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath, 70);
                    // Update Product Banner name in products table
                    Product::where('id',$id)->update(['product_banner'=>$imageName]);
                }
            }
            
            // Upload Alt Images
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
                    $imageName = 'item-'.rand(1111,999999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload the Large, Medium and Small Images after Resize
                    // Image::make($image_tmp)->resize(1000,500)->save($largeImagePath, 50);
                    Image::make($image_tmp)->save($largeImagePath, 70);
                    Image::make($image_tmp)->resize(500,250)->save($mediumImagePath, 70);
                    Image::make($image_tmp)->resize(250,125)->save($smallImagePath, 70);
                    // Insert Image Name in products table
                    $image = new ProductsImage; 
                    $image->image = $imageName;
                    $image->product_id = $id;
                    /*if(isset($data['title'][$key])&&!empty($data['title'][$key])){
                        $image->title = $data['title'][$key];    
                    }*/
                    $image->status = 1;
                    $image->save();
                    $message = "Product Images has been added successfully! You can update Images Titles now.";
                }
            }

            if($id!=""){
                if(isset($data['image'])){
                    foreach ($data['image'] as $ikey => $image) {
                        ProductsImage::where(['product_id'=>$id,'image'=>$image])->update(['title'=>$data['title'][$ikey]]);
                        $message = "Product Images Titles has been updated successfully!";
                    }
                }
            }

            if(isset($message)&&$message!=""){
                /*return redirect()->back()->with('success_message',$message);  */
                return redirect()->back()->with([
                    'success_message' => $message,
                    'scroll_to' => 'captions'
                ]);  
            }else{
                /*return redirect()->back();*/
                return redirect()->back()->with('scroll_to', 'captions');
            }
            
        }

        return view('admin.images.add_images')->with(compact('product'));
    }

    public function addReusedImages($id, Request $request){
        Session::put('page','reused_products');
        $product = Product::select('id','product_name','product_code','product_price','product_image')->with('images')->find($id); 

        if($request->isMethod('post')){
            $data = $request->all();
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
                    $imageName = 'item-'.rand(1111,999999).'.'.$extension;
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
                    $image->product_id = $id;
                    $image->status = 1;
                    $image->save();
                }
            }
            return redirect()->back()->with('success_message','Product Images has been added successfully!');
        }

        return view('admin.images.add_images')->with(compact('product'));
    }

    public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
        }
    }

    public function deleteImage($id){
        // Get product image
        $productImage = ProductsImage::select('image')->where('id',$id)->first();

        // Get Product Image Paths
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';
    
        // Delete Product small image if exists in small folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        // Delete Product medium image if exists in medium folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        // Delete Product large image if exists in large folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        // Delete Product image from products_images table
        ProductsImage::where('id',$id)->delete();

        $message = "Bildet er slettet";
        return redirect()->back()->with('success_message',$message);

    }
}
