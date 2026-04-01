<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public static function getCities($state){
        $getCities = City::select('city')->where(['state'=>$state,'status'=>1])->groupby('city')->pluck('city')->toArray();
        $getCities = array_unique($getCities);
        return $getCities;
    }

    public static function getState($city){
        $getState = City::select('state')->where(['city'=>$city])->first()->toArray();
        return $getState['state'];
    }

}
