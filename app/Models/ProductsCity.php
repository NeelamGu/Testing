<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsCity extends Model
{
    use HasFactory;

    public static function countCity($product_id,$city){
        $countCity = ProductsCity::where(['product_id'=>$product_id,'city'=>$city])->count();
        return $countCity;
    }
}
