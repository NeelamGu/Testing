<?php
use App\Models\Cart;
use App\Models\ProductsEnquiry;
use App\Models\EnquiriesResponse;

function totalCartItems(){
	if(Auth::check()){
		$user_id = Auth::user()->id;
		$totalCartItems = Cart::where('user_id',$user_id)->sum('quantity');
	}else{
		$session_id = Session::get('session_id');
		$totalCartItems = Cart::where('session_id',$session_id)->sum('quantity');
	}
	return $totalCartItems;
}

function getCartItems(){
    if(Auth::check()){
        // If user logged in / pick auth id of the user
        $getCartItems = Cart::with(['product'=>function($query){
            $query->select('id','category_id','product_name','product_code','product_color','product_image');
        }])->orderby('id','Desc')->where('user_id',Auth::user()->id)->get()->toArray();
    }else{
        // If user not logged in / pick session id of the user
        $getCartItems = Cart::with(['product'=>function($query){
            $query->select('id','category_id','product_name','product_code','product_color','product_image');
        }])->orderby('id','Desc')->where('session_id',Session::get('session_id'))->get()->toArray();
    }
    return $getCartItems;
}

function messagesCountCustomer(){
    $unreadTotalCount = 0;
    if(Auth::check()){
        $enquiries = ProductsEnquiry::query();
        $enquiries = $enquiries->where('user_id',Auth::user()->id);
        $enquiries = $enquiries->with(['product','user','vendor'])->orderBy('id','Desc')->get()->toArray();
        foreach ($enquiries as $key => $enquiry) {
            $unreadCount = EnquiriesResponse::where(['enquiry_id'=>$enquiry['id'],'sender_type'=>'Vendor'])->where('is_unread',1)->count();
            $unreadTotalCount = $unreadTotalCount + $unreadCount;
        }    
    }
    return $unreadTotalCount;
}

function messagesCountVendor(){
    $unreadTotalCount = 0;
    if(Auth::guard('admin')->user()){
        $enquiries = ProductsEnquiry::query();
        $enquiries = $enquiries->where('vendor_id',Auth::guard('admin')->user()->vendor_id);
        $enquiries = $enquiries->with(['product','user','vendor'])->orderBy('id','Desc')->get()->toArray();
        foreach ($enquiries as $key => $enquiry) {
            $unreadCount = EnquiriesResponse::where(['enquiry_id'=>$enquiry['id'],'sender_type'=>'Customer'])->where('is_unread',1)->count();
            $unreadTotalCount = $unreadTotalCount + $unreadCount;
        }    
    }
    return $unreadTotalCount;
}