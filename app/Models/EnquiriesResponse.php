<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiriesResponse extends Model
{
    use HasFactory;

    function enquiry(){
        return $this->belongsTo('App\Models\ProductsEnquiry','enquiry_id')->with(['product','user','vendor']);
    }

    public static function getlastEnquiryDate($enquiry_id){
        $last_date = "";
        $getlastEnquiryCount = EnquiriesResponse::where('enquiry_id',$enquiry_id)->orderby('id','Desc')->count();
        if($getlastEnquiryCount>0){
            $getlastEnquiryDate = EnquiriesResponse::where('enquiry_id',$enquiry_id)->orderby('id','Desc')->first()->toArray();
            $last_date = $getlastEnquiryDate['created_at'];    
        }
        return $last_date;   
    }
}
