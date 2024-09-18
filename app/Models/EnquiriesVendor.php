<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiriesVendor extends Model
{
    use HasFactory;

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor','vendor_id');
    }

    public function admin(){
        return $this->hasOne('App\Models\Admin','vendor_id','vendor_id');
    }

    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
