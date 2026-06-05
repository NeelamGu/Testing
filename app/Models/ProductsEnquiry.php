<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsEnquiry extends Model
{
    use HasFactory;

    function product(){
        return $this->hasOne('App\Models\Product','id','product_id')->with('category');
    }

    function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    function vendor(){
        return $this->hasOne('App\Models\Admin','vendor_id','vendor_id');
    }

    function enquiryDetail(){
        return $this->hasOne('App\Models\Enquiry','id','enquiry_detail_id');
    }

    public static function enquiryStatus($id){
        $enquiryStatus = ProductsEnquiry::where('id',$id)->first();
        return $enquiryStatus->status;
    }
}
