<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;
class Wishlist extends Model
{
    //
    public function product(){
    	return $this->belongsTo('App\Models\Product','product_id');
    }

	public static function wishlists(){
		$wishlists= Wishlist::with('product')->where('user_id',Auth::user()->id)->get();
		return $wishlists;
	}

    public static function checkwishlist($proid){
    	$check = Wishlist::where([
                'user_id'=>Auth::user()->id,
                'product_id' => $proid
            ])->count();
    	return $check;
    }
}
