<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public static function getVendorDetails($vendorid){
        $getVendorDetails = Vendor::where('id',$vendorid)->first()->toArray();
        return $getVendorDetails;
    }

    public function vendorbusinessdetails(){
        return $this->belongsTo('App\Models\VendorsBusinessDetail','id','vendor_id');
    }

    public function plan(){
        return $this->belongsTo('App\Models\Plan');
    }

    public static function getVendorShop($vendorid){
        $getVendorShop = VendorsBusinessDetail::select('shop_name')->where('vendor_id',$vendorid)->first()->toArray();
        return $getVendorShop['shop_name'];
    }

    public static function getVendorCategory($vendorid){
        $getVendorCategory = Vendor::select('category_id')->where('id',$vendorid)->first()->toArray();
        $getCatName = Category::select('category_name')->where('id',$getVendorCategory['category_id'])->first()->toArray();
        return $getCatName['category_name'];
    }

    public static function getPlanDetails($vendorid){
        $getPlanId = Vendor::select('plan_id')->where('id',$vendorid)->first();
        $getPlanDetails = Plan::where('id',$getPlanId->plan_id)->first()->toArray();
        return $getPlanDetails;
    }

    public static function vendorProductsCount($vendorid){
        $vendorProductsCount = Product::where('vendor_id',$vendorid)->count();
        return $vendorProductsCount;
    }

    public static function getVendorID($email){
        $getVendorID = Vendor::select('id')->where('email',$email)->first();
        return $getVendorID->id;
    }
}
