<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    use HasFactory;

    public static function getProductStock($product_id,$size){
        $getProductStock = ProductsAttribute::select('stock')->where(['product_id'=>$product_id,'size'=>$size])->first();
        return $getProductStock->stock;
    }

    public static function sizes($catids){
        $productIds = Product::select('id')->whereIn('category_id',$catids)->where('status',1)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        $sizes = ProductsAttribute::select('size')->whereIn('product_id',$productIds)->where('status',1)->groupby('size')->get();
        return $sizes;
    }
}
