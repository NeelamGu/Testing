<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    use HasFactory;

    public function section(){
        return $this->belongsTo('App\Models\Section','section_id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id')->with('parentcategory');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }

    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public function images(){
        return $this->hasMany('App\Models\ProductsImage')->orderby('id','Desc');
    }

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor','vendor_id')->with('vendorbusinessdetails');
    }

    public static function getDiscountPrice($product_id){
        $proDetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first();
        $proDetails = json_decode(json_encode($proDetails),true);
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);

        if($proDetails['product_discount']>0){
            // If product discount is added from the admin panel
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*$proDetails['product_discount']/100);


        }else if($catDetails['category_discount']>0){
            // If product discount is not added but category discount added from the admin panel
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*$catDetails['category_discount']/100);

        }else{
            $discounted_price = 0;
        }
        return $discounted_price;
    }

    public static function getDiscountAttributePrice($product_id,$size){
        $proAttrPrice = ProductsAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        $proDetails = Product::select('product_discount','category_id')->where('id',$product_id)->first();
        $proDetails = json_decode(json_encode($proDetails),true);
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);
        if($proDetails['product_discount']>0){
            // If product discount is added from the admin panel
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$proDetails['product_discount']/100);
            $discount = $proAttrPrice['price'] - $final_price; 

        }else if($catDetails['category_discount']>0){
            // If product discount is not added but category discount added from the admin panel
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$catDetails['category_discount']/100);
            $discount = $proAttrPrice['price'] - $final_price; 
        }else{
            $final_price = $proAttrPrice['price'];
            $discount = 0;
        }
        return array('product_price'=>$proAttrPrice['price'],'final_price'=>$final_price,'discount'=>$discount);
    }

    public static function isProductNew($product_id){
        // Get Last 3 Products
        $productIds = Product::select('id')->where('status',1)->orderby('id','Desc')->limit(3)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        //dd($productIds);
        if(in_array($product_id,$productIds)){
            $isProductNew = "Yes";
        }else{
            $isProductNew = "No";
        }
        return $isProductNew;
    }

    public static function getProductURL($product_name){
        $product_name = strtolower($product_name);
        $product_name = str_replace(' ','-',$product_name);
        return $product_name;
    }

    public static function states($catids){
        /*echo "<pre>"; print_r($catids); die;*/
        $productIds = Product::select('id')->whereIn('category_id',$catids)->where('status',1)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        $cities = Product::select('city')->whereIn('id',$productIds)->where('status',1)->groupby('city')->get();
        $cities = json_decode(json_encode($cities),true);
        sort($cities);
        $states = array();
        foreach ($cities as $key => $city) {
            $getStateCount = DB::table('cities')->where('city',$city)->count();
            if($getStateCount>0){
                $getState = DB::table('cities')->where('city',$city)->first();   
                $states[] = $getState->state; 
            }
        }
        sort($states);
        $states = array_unique($states);
        return $states;
    }

    public static function productStatesOld1($catids){
        /*echo "<pre>"; print_r($catids); die;*/
        $productIds = Product::select('id')->whereIn('category_id',$catids)->where('status',1)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        //dd($productIds);
        $cities = ProductsCity::select('city')->whereIn('product_id',$productIds)->groupby('city')->get();
        $cities = json_decode(json_encode($cities),true);
        $states = array();
        foreach ($cities as $key => $city) {
            $getStateCount = DB::table('cities')->where('city',$city)->count();
            if($getStateCount>0){
                $getState = DB::table('cities')->where('city',$city)->first();   
                $states[] = $getState->state; 
            }
        }
        $states = array_unique($states);
        return $states;
    }

    public static function productStates($catids){
        /*echo "<pre>"; print_r($catids); die;*/
        $productIds = Product::select('id')->whereIn('category_id',$catids)->where('status',1)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        //dd($productIds);
        $states = ProductsCity::select('state')->whereIn('product_id',$productIds)->get()->pluck('state')->toArray();
        $states = json_decode(json_encode($states),true);
        sort($states);
        $states = array_unique($states);
        return $states;
    }

    public static function cities($catids){
        /*echo "<pre>"; print_r($catids); die;*/
        $productIds = Product::select('id')->whereIn('category_id',$catids)->where('status',1)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        $cities = Product::select('city')->whereIn('id',$productIds)->where('status',1)->groupby('city')->get();
        return $cities;
    }

    public static function stateCities($catids,$state){
        /*echo "<pre>"; print_r($catids); die;*/
        $productIds = Product::select('id')->whereIn('category_id',$catids)->where('status',1)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        $cities = Product::select('city')->whereIn('id',$productIds)->where('status',1)->groupby('city')->get();
        $cities = json_decode(json_encode($cities),true);
        $stateCitiesData = array();
        foreach ($cities as $key => $city) {
            $citiesCount = DB::table('cities')->where('city',$city)->where('state',$state)->count();
            if($citiesCount>0){
                $citiesData = DB::table('cities')->where('city',$city)->where('state',$state)->first();
                $stateCitiesData[] = $citiesData->city;
            }
        }
        $stateCitiesData = array_unique($stateCitiesData);
        return $stateCitiesData;
    }

    public static function productStateCitiesOld($catids,$state){
        /*echo "<pre>"; print_r($catids); die;*/
        $productIds = Product::select('id')->whereIn('category_id',$catids)->where('status',1)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        $cities = ProductsCity::select('city')->whereIn('product_id',$productIds)->groupby('city')->get();
        $cities = json_decode(json_encode($cities),true);
        foreach ($cities as $key => $city) {
            $citiesCount = DB::table('cities')->where('city',$city)->where('state',$state)->count();
            if($citiesCount>0){
                $citiesData = DB::table('cities')->where('city',$city)->where('state',$state)->first();
                $stateCitiesData[] = $citiesData->city;
            }
        }
        $stateCitiesData = array_unique($stateCitiesData);
        return $stateCitiesData;
    }

    public static function productStateCities($catids,$state){
        /*echo "<pre>"; print_r($catids); die;*/
        $productIds = Product::select('id')->whereIn('category_id',$catids)->where('status',1)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        $cities = ProductsCity::select('city')->where('state',$state)->whereIn('product_id',$productIds)->pluck('city');
        $cities = json_decode(json_encode($cities),true);
        $cities = array_unique($cities);
        return $cities;
    }

    public static function productURL($product_name){
        $product_name = strtolower($product_name);
        $product_name = str_replace(' ','-',$product_name);
        $product_name = str_replace(',','',$product_name);
        $product_name = str_replace('&','-',$product_name);
        return $product_name;
    }

}
