<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscriber;
use Session;
use Auth;
use DB;

class UserController extends Controller
{
    public function users(){
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType=="vendor"){
            $message = "You have no right to access this functionality";
            return redirect('admin/dashboard')->with('error_message',$message);
        }
        Session::put('page','users');
        if(isset($_GET['email'])){
            $users = User::where('email',$_GET['email'])->where('is_delete',0)->get()->toArray(); 
        }else{
            $users = User::get()->where('is_delete',0)->toArray();    
        }
        /*dd($users);*/
        return view('admin.users.users')->with(compact('users'));
    }

    public function subscribers(){
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType=="vendor"){
            $message = "You have no right to access this functionality";
            return redirect('admin/dashboard')->with('error_message',$message);
        }
        Session::put('page','subscribers');
        $subscribers = Subscriber::orderby('id','Desc')->get()->toArray();
        return view('admin.subscribers.subscribers')->with(compact('subscribers'));
    }

    public function updateUserStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            User::where('id',$data['user_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'user_id'=>$data['user_id']]);
        }
    }

    public function updateSubscriberStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Subscriber::where('id',$data['user_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'user_id'=>$data['user_id']]);
        }
    }

    public function deleteUser($id){
        try {

            // Disable User
            User::where('id', $id)->update(['is_delete' => 1, 'status' => 0]);

            return redirect()->back()->with('success_message', 'User has been deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack(); // Important to roll back on failure
            \Log::error("Error deleting vendor: " . $e->getMessage());
            return redirect()->back()->with('error_message', 'Something went wrong. Please try again later.');
        }
    }

}
