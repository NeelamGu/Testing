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
}
