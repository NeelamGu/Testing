<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use Image;
use Session;
use Auth;
use DB;

class RatingController extends Controller
{
    public function ratings(){
        Session::put('page','ratings');
        $ratings = Rating::with(['user','product'])->get();
        $ratings = json_decode(json_encode($ratings),true);
        /*echo "<pre>"; print_r($ratings); die;*/
        return view('admin.ratings.ratings')->with(compact('ratings'));
    }

    public function updateRatingStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Rating::where('id',$data['rating_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'rating_id'=>$data['rating_id']]);
        }
    }

    public function deleteRating($id){
        // Delete Rating
        Rating::where('id',$id)->delete();
        return redirect()->back()->with('success_message','Rating/Review deleted successfully!');
    }
}
