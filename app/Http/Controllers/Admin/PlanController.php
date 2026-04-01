<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use Session;
use Image;
use Auth;

class PlanController extends Controller
{
    public function plans(){
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType=="vendor"){
            $message = "You have no right to access this functionality";
            return redirect('admin/dashboard')->with('error_message',$message);
        }
        Session::put('page','plans');
        $plans = Plan::get()->toArray();
        /*dd($plans);*/
        return view('admin.plans.plans')->with(compact('plans'));
    }

    public function updatePlanStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Plan::where('id',$data['plan_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'plan_id'=>$data['plan_id']]);
        }
    }

    public function addEditPlan(Request $request, $id=null){
        ini_set('memory_limit','256M');
        Session::put('page','plans');
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType=="vendor"){
            $message = "You have no right to access this functionality";
            return redirect('admin/dashboard')->with('error_message',$message);
        }
        if($id==""){
            // Add Plan Functionality
            $title = "Add Plan";
            $plan = new Plan;
            $message = "Plan added successfully!";
        }else{
            // Edit Plan Functionality
            $title = "Edit Plan";
            $plan = Plan::find($id);
            /*echo "<pre>"; print_r($plan['plan_name']); die;*/
            $message = "Plan updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'price' => 'required',
            ];

            $customMessages = [
                'name.required' => 'Plan Name is required',
                'name.regex' => 'Valid Plan Name is required',
                'price.required' => 'Plan Price is required',
            ];

            $this->validate($request,$rules,$customMessages);

            // Upload Plan Image
            if($request->hasFile('plan_image')){
                $image_tmp = $request->file('plan_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/plan_images/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                    $plan->image = $imageName;
                }
            }

            $plan->name = $data['name'];
            $plan->price = $data['price'];
            $plan->short_description = $data['short_description'];
            $plan->description = $data['description'];
            $plan->features = $data['features'];
            $plan->responses_limit = $data['responses_limit'];
            $plan->products_limit = $data['products_limit'];
            if(!empty($data['is_popular'])){
                $plan->is_popular = $data['is_popular'];
            }else{
                $plan->is_popular = "No";
            }
            $plan->save();

            return redirect('admin/plans')->with('success_message',$message);

        }

        return view('admin.plans.add_edit_plan')->with(compact('title','plan'));
    }

    public function deletePlanImage($id){
        // Get Plan Image
        $planImage = Plan::select('image')->where('id',$id)->first();
        
        // Get Plan Image Path
        $plan_image_path = 'front/images/plans_images/';

        // Delete Plan Image from plan_images folder if exists
        if(file_exists($plan_image_path.$planImage->plan_image)){
            unlink($plan_image_path.$planImage->plan_image);
        }

        // Delete Plan image from categories folder 
        Plan::where('id',$id)->update(['image'=>'']);

        $message = "Plan Image has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }
}
