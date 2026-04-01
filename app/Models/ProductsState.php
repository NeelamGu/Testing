<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsState extends Model
{
    use HasFactory;

    public static function countState($product_id,$state){
        $countState = ProductsState::where(['product_id'=>$product_id,'state'=>$state])->count();
        return $countState;
    }
}
