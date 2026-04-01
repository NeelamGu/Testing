<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EnquiriesResponse;

class Enquiry extends Model
{
    use HasFactory;

    public function vendors(){
        return $this->hasMany('App\Models\EnquiriesVendor','enquiry_id')->with('vendor','admin','product');
    }

    public function product(){
        return $this->hasMany('App\Models\ProductsEnquiry','enquiry_detail_id');
    }

    public static function enquiryDetails($id){
        $enquiryDetails = Enquiry::where('id',$id)->first()->toArray();
        return $enquiryDetails;
    }

    /*public static function vendorEnquiriesCount($vendor_id){
        $enquiriesCount = ProductsEnquiry::where('vendor_id',$vendor_id)->count();
        return $enquiriesCount;
    }*/

    public static function vendorEnquiriesCount($vendor_id){
        $enquiriesCount = ProductsEnquiry::where('vendor_id',$vendor_id)->count();
        $enquiriesTotalCount = 0;
        if($enquiriesCount>0){
            $enquiriesArr = ProductsEnquiry::select('id')->where('vendor_id',$vendor_id)->pluck('id')->toArray();
            $enquiriesArr = array_unique($enquiriesArr);
            //dd($enquiriesArr);
            foreach ($enquiriesArr as $key => $val) {
                $enquiriesUserCount = EnquiriesResponse::where('enquiry_id',$val)->where('sender_type','Vendor')->count();
                if($enquiriesUserCount>0){
                    $enquiriesTotalCount = $enquiriesTotalCount + 1;    
                }
                
            }
        }
        //echo $enquiriesTotalCount; die;
        return $enquiriesTotalCount;
    }

    /*public static function vendorEnquiriesCountOld($vendor_id){
        $enquiriesCount = ProductsEnquiry::where('vendor_id',$vendor_id)->count();
        $enquiriesTotalCount = 0;
        if($enquiriesCount>0){
            $enquiriesArr = ProductsEnquiry::select('user_id')->where('vendor_id',$vendor_id)->pluck('user_id')->toArray();
            $enquiriesArr = array_unique($enquiriesArr);
            //dd($enquiriesArr);
            foreach ($enquiriesArr as $key => $user_id) {
                $enquiriesUserCount = ProductsEnquiry::where('user_id',$user_id)->count()-1;
                $enquiriesTotalCount = $enquiriesTotalCount + $enquiriesUserCount;
            }
        }
        return $enquiriesTotalCount;
    }*/

    public static function googleAPIRequest($vendor_pincode,$user_pincode) {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?key=AIzaSyDOGDgt9xUJTSHnqHsPXO5ZFYBvVh3msFc&origins=".$vendor_pincode.",norway&destinations=".$user_pincode.",norway&mode=driving&language=en-EN&sensor=false";

        // Create a curl call
        $ch      = curl_init();
        $timeout = 0;

        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );

        $data = curl_exec( $ch );
        // send request and wait for response

        $response = json_decode( $data, true );

        curl_close( $ch );

        /*echo "<pre>"; print_r($response); die;*/

        return $response;
        
    }

    public static function googleAPIRequestOld($vendor_pincode,$user_pincode){

        /*https://maps.googleapis.com/maps/api/distancematrix/json?key=AIzaSyCix700I0g-HesngOlQK8Fk4wJHpvUJQ58&origins=9520,norway&destinations=9524,norway&mode=driving&language=en-EN&sensor=false*/

        /*$request ="";
        $param['key']="AIzaSyCix700I0g-HesngOlQK8Fk4wJHpvUJQ58";
        $param['origins'] = $vendor_pincode.",norway";
        $param['destinations'] = $user_pincode.",norway";
        $param['mode']="driving";
        $param['language']="en-EN";
        $param['sensor']="false";
        
        foreach($param as $key=>$val) {
            $request.= $key."=".urlencode($val);
            $request.= "&";
        }
        $request = substr($request, 0, strlen($request)-1);

        echo $url ="https://maps.googleapis.com/maps/api/distancematrix/json?".$request; die;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
        echo "<pre>"; print_r($ch); die;

        $ch = curl_init();*/

    $ch = curl_init();

    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?";

    $dataArray = ['key' => "AIzaSyCix700I0g-HesngOlQK8Fk4wJHpvUJQ58",'origins' => $vendor_pincode.",norway",'destinations' => $user_pincode.",norway",'mode' => "driving",'language' => "en-EN",'sensor' => "false"];

    $data = http_build_query($dataArray);

    $getUrl = $url."?".$data;

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    curl_setopt($ch, CURLOPT_URL, $getUrl);

    curl_setopt($ch, CURLOPT_TIMEOUT, 80);

    $response = curl_exec($ch);

    if(curl_error($ch)){

        echo 'Request Error:' . curl_error($ch);

    }else{

        echo $response;

    }

    echo "<pre>"; print_r($ch); die;   

    curl_close($ch);

    }
}
