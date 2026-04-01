<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use Validator;
use Session;
use DB;

class APIController extends Controller
{
    public function syncPincodes(){
        /*try{*/
            $url = 'https://api.bring.com/address/api/NO/postal-codes';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/json','X-Mybring-API-Uid: guptaneelam@hotmail.com','X-Mybring-API-Key: cca56c5b-8ae4-4a3e-8cbb-59a564aa4120'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result,true);
            /*echo "<pre>"; print_r($result); die;*/

            City::truncate();

            foreach ($result['postal_codes'] as $key => $value) {
                    //echo "Pincode: ".$value['postal_code']."  City: ".$value['city']."  State:  ".$value['county']; "<br>";
                    //City::where('postcode',$value['postal_code'])->update(['city'=>$value['city'],'state'=>$value['county']]);
                    if(isset($value['county']) && $key<=5500){
                        $city = new City;
                        $city->postcode = $value['postal_code']; 
                        $city->city = $value['city']; 
                        $city->state = $value['county'];
                        $city->status = 1;
                        $city->save();    
                    }
                    

            }
        /*}catch(\Exception $e){
            return response()->json(exceptionMessage($e),423);
        }*/
    }
}
