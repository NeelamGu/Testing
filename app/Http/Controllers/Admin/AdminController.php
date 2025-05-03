<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
use App\Models\Country;
use App\Models\Section;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Plan;
use Image;
use Session;
use DB;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        if(Auth::guard('admin')->user()->type=="vendor"){
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $productsCount = Product::where('is_delete',0)->where('vendor_id',$vendor_id)->count();
            $messagesCountVendor = messagesCountVendor();
            return view('admin.dashboard')->with(compact('productsCount','messagesCountVendor'));
        }else{
            $sectionsCount = Section::get()->count();
            $categoriesCount = Category::get()->count();
            $brandsCount = Brand::get()->count();
            $productsCount = Product::where('is_delete',0)->get()->count();
            $couponsCount = Coupon::get()->count();
            $usersCount = User::get()->count();
            $vendorsCount = Admin::where('type','vendor')->count();
            return view('admin.dashboard')->with(compact('sectionsCount','categoriesCount','productsCount','brandsCount','couponsCount','usersCount','vendorsCount'));   
        }
    }

    public function updateAdminPassword(Request $request){
        Session::put('page','update_admin_password');
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            // Check if current password enterted by admin is correct
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                // Check if new password is matching with confirm password
                if($data['confirm_password']==$data['new_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message','Password has been updated successfully!');
                }else{
                    return redirect()->back()->with('error_message','New Password and Confirm Password does not match!');    
                }
            }else{
                return redirect()->back()->with('error_message','Your current password is Incorrect!');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function checkAdminPassword(Request $request){
        $data = $request->all();
        /*echo "<pre>"; print_r($data); die;*/
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    public function updateAdminDetails(Request $request){
        Session::put('page','update_admin_details');
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
            ];

            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Mobile is required',
            ];

            $this->validate($request,$rules,$customMessages);

            // Upload Admin Photo
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                }
            }else if(!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
            }else{
                $imageName = "";
            }

            // Update Admin Details
            Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            return redirect()->back()->with('success_message','Admin details updated successfully!');
        }
        return view('admin.settings.update_admin_details');
    }

    public function updateVendorDetails($slug, Request $request){

        if($slug=="personal"){
            Session::put('page','update_personal_details');
            if($request->isMethod('post')){
                $data = $request->all();
                /*echo "<pre>"; print_r($data); die;*/

                $rules = [
                'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'vendor_city' => 'required|regex:/^[\pL\s\-]+$/u',
                'vendor_mobile' => 'required|numeric',
                'vendor_image'  => 'max:10000|mimes:jpeg,bmp,png',
                ];

                $customMessages = [
                    'vendor_name.required' => 'Name is required',
                    'vendor_city.required' => 'City is required',
                    'vendor_name.regex' => 'Valid Name is required',
                    'vendor_city.regex' => 'Valid City is required',
                    'vendor_mobile.required' => 'Mobile is required',
                    'vendor_mobile.numeric' => 'Valid Mobile is required',
                ];

                $this->validate($request,$rules,$customMessages);

                // Upload Admin Photo
                if($request->hasFile('vendor_image')){
                    $image_tmp = $request->file('vendor_image');
                    if($image_tmp->isValid()){
                        // Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate New Image Name
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/photos/'.$imageName;
                        // Upload the Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                }else if(!empty($data['current_vendor_image'])){
                    $imageName = $data['current_vendor_image'];
                }else{
                    $imageName = "";
                }

                // Update in admins table
                Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],'image'=>$imageName]);

                $data['birth_date'] = NULL;
                $data['gender'] = NULL;

                // Update in vendors table
                Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->update([
                    'name'=>$data['vendor_name'],
                    'company_name'=>$data['company_name'],
                    'organisation_number'=>$data['organisation_number'],
                    'mobile'=>$data['vendor_mobile'],
                    'address'=>$data['vendor_address'],
                    'city'=>$data['vendor_city'],
                    'state'=>$data['vendor_state'],
                    'state'=>$data['vendor_state'],
                    /*'country'=>$data['vendor_country'],*/
                    'pincode'=>$data['vendor_pincode'],
                    'radius'=>$data['vendor_radius'],
                    'birth_date'=>$data['birth_date'],
                    'gender'=>$data['gender'],
                    'instagram'=>$data['instagram'],
                    'facebook'=>$data['facebook'],
                    'tiktok'=>$data['tiktok'],
                    'website'=>$data['website']
                ]);
                return redirect()->back()->with('success_message','Leverandør-opplysninger endret');
            }
            $vendorDetails = Vendor::with('plan')->where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }else if($slug=="business"){
            Session::put('page','update_business_details');
            if($request->isMethod('post')){
                $data = $request->all();
                /*echo "<pre>"; print_r($data); die;*/

                $rules = [
                'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'shop_city' => 'required|regex:/^[\pL\s\-]+$/u',
                'shop_mobile' => 'required|numeric',
                'address_proof' => 'required',
                ];

                $customMessages = [
                    'shop_name.required' => 'Name is required',
                    'shop_city.required' => 'Name is required',
                    'shop_name.regex' => 'Valid Name is required',
                    'shop_city.regex' => 'Valid City is required',
                    'shop_mobile.required' => 'Mobile is required',
                    'shop_mobile.numeric' => 'Valid Mobile is required',
                ];

                $this->validate($request,$rules,$customMessages);

                // Upload Admin Photo
                if($request->hasFile('address_proof_image')){
                    $image_tmp = $request->file('address_proof_image');
                    if($image_tmp->isValid()){
                        // Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate New Image Name
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/proofs/'.$imageName;
                        // Upload the Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                }else if(!empty($data['current_address_proof'])){
                    $imageName = $data['current_address_proof'];
                }else{
                    $imageName = "";
                }
                $vendorCount = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                if($vendorCount>0){
                    // Update in vendors_business_details table
                VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['shop_name'=>$data['shop_name'],'shop_mobile'=>$data['shop_mobile'],'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],'shop_state'=>$data['shop_state'],'shop_country'=>$data['shop_country'],'shop_pincode'=>$data['shop_pincode'],'business_license_number'=>$data['business_license_number'],'gst_number'=>$data['gst_number'],'pan_number'=>$data['pan_number'],'address_proof'=>$data['address_proof'],'address_proof_image'=>$imageName]);
                }else{
                    // Update in vendors_business_details table
                    VendorsBusinessDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'shop_name'=>$data['shop_name'],'shop_mobile'=>$data['shop_mobile'],'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],'shop_state'=>$data['shop_state'],'shop_country'=>$data['shop_country'],'shop_pincode'=>$data['shop_pincode'],'business_license_number'=>$data['business_license_number'],'gst_number'=>$data['gst_number'],'pan_number'=>$data['pan_number'],'address_proof'=>$data['address_proof'],'address_proof_image'=>$imageName]);    
                }
                
                return redirect()->back()->with('success_message','Leverandør-opplysninger endret');
            }
            $vendorCount = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount>0){
                $vendorDetails = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();    
            }else{
                $vendorDetails = array();   
            }
            
            /*dd($vendorDetails);*/
        }else if($slug=="bank"){
            Session::put('page','update_bank_details');
            if($request->isMethod('post')){
                $data = $request->all();
                /*echo "<pre>"; print_r($data); die;*/

                $rules = [
                'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'bank_name' => 'required',
                'account_number' => 'required|numeric',
                'bank_ifsc_code' => 'required',
                ];

                $customMessages = [
                    'account_holder_name.required' => 'Account Holder Name is required',
                    'account_holder_name.regex' => 'Valid Account Holder Name is required',
                    'bank_name.required' => 'Bank Name is required',
                    'account_number.required' => 'Account Number is required',
                    'account_number.numeric' => 'Valid Account Number is required',
                    'bank_ifsc_code.required' => 'Bank IFSC Code is required',
                ];

                $this->validate($request,$rules,$customMessages);
                $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                if($vendorCount>0){
                    // Update in vendors_bank_details table
                    VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=>$data['account_holder_name'],'bank_name'=>$data['bank_name'],'account_number'=>$data['account_number'],'bank_ifsc_code'=>$data['bank_ifsc_code']]);
                }else{
                    VendorsBankDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'account_holder_name'=>$data['account_holder_name'],'bank_name'=>$data['bank_name'],'account_number'=>$data['account_number'],'bank_ifsc_code'=>$data['bank_ifsc_code']]);
                }
                return redirect()->back()->with('success_message','Leverandør-opplysninger endret');
            }

            $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount>0){
                $vendorDetails = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();    
            }else{
                $vendorDetails = array();   
            }
        }
        $countries = Country::where('status',1)->get()->toArray();
        $cities = DB::table('cities')->select('city')->where('status',1)->groupby('city')->pluck('city');
        $states = DB::table('cities')->select('state')->where('status',1)->groupby('state')->pluck('state');
        return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails','countries','cities','states'));
    }

    public function login(Request $request){
        // echo $password = Hash::make('123456'); die;

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                // Add Custom Messages here
                'email.required' => 'Email is required!',
                'email.email' => 'Valid Email is required',
                'password.required' => 'Password is required',
            ];

            $this->validate($request,$rules,$customMessages);

            /*if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])){
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }*/

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                if(Auth::guard('admin')->user()->type=="vendor" && Auth::guard('admin')->user()->confirm=="No"){
                    return redirect()->back()->with('error_message','Please confirm your email to activate your Vendor Account');
                }else if(Auth::guard('admin')->user()->type!="vendor" && Auth::guard('admin')->user()->status=="0"){
                    return redirect()->back()->with('error_message','Your admin account is not active');
                }else{
                    return redirect('admin/dashboard');    
                }
            }else{
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }

        }
        return view('admin.login');
    }

    public function admins($type=null){
        $adminType = Auth::guard('admin')->user()->type;
        if($adminType=="vendor"){
            $message = "You have no right to access this functionality";
            return redirect('admin/dashboard')->with('error_message',$message);
        }
        $admins = Admin::where('is_delete',0);
        if(!empty($type)){
            if($type=="vendor"){
                $admins = $admins->with('vendorPersonal')->where('type',$type);
            }else{
                $admins = $admins->where('type',$type);    
            }
               
            $title = ucfirst($type)."s";
            Session::put('page','view_'.strtolower($title));
        }else{
            $title = "All Admins/Subadmins/Vendors";
            Session::put('page','view_all');
        }
        $admins = $admins->orderBy('id','Desc')->get()->toArray();
        /*dd($admins);*/
        return view('admin.admins.admins')->with(compact('admins','title'));
    }

    public function viewVendorDetails(Request $request,$id){
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);
        $admin_id = $id;
        /*dd($vendorDetails);*/

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $rules = [
                'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'vendor_city' => 'required|regex:/^[\pL\s\-]+$/u',
                ];

                $customMessages = [
                    'vendor_name.required' => 'Name is required',
                    'vendor_city.required' => 'City is required',
                    'vendor_name.regex' => 'Valid Name is required',
                    'vendor_city.regex' => 'Valid City is required',
                ];

                $this->validate($request,$rules,$customMessages);

                // Upload Admin Photo
                if($request->hasFile('vendor_image')){
                    $image_tmp = $request->file('vendor_image');
                    if($image_tmp->isValid()){
                        // Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate New Image Name
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/photos/'.$imageName;
                        // Upload the Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                }else if(!empty($data['current_vendor_image'])){
                    $imageName = $data['current_vendor_image'];
                }else{
                    $imageName = "";
                }

                if(!isset($data['birth_date'])){
                    $data['birth_date'] = null;
                }

                if(!isset($data['birth_date'])){
                    $data['gender'] = null;
                }

                // Update in admins table
                Admin::where('id',$admin_id)->update(['name'=>$data['vendor_name'],
                    /*'mobile'=>$data['vendor_mobile'],*/
                    'address'=>$data['vendor_address'],
                    'city'=>$data['vendor_city'],
                    'image'=>$imageName]);
                // Update in vendors table
                Vendor::where('id',$data['vendor_id'])->update([
                    'name'=>$data['vendor_name'],
                    'company_name'=>$data['company_name'],
                    'organisation_number'=>$data['organisation_number'],
                    /*'mobile'=>$data['vendor_mobile'],*/
                    'address'=>$data['vendor_address'],
                    'city'=>$data['vendor_city'],
                    'state'=>$data['vendor_state'],
                    /*'country'=>$data['vendor_country'],*/
                    'pincode'=>$data['vendor_pincode'],
                    'birth_date'=>$data['birth_date'],
                    'gender'=>$data['gender'],
                    'instagram'=>$data['instagram'],
                    'facebook'=>$data['facebook'],
                    'tiktok'=>$data['tiktok'],
                    'radius'=>$data['vendor_radius'],
                    'website'=>$data['website'],
                    'youtube'=>$data['youtube']
                ]);
                return redirect()->back()->with('success_message','Leverandør-opplysninger endret');


        }
        return view('admin.admins.update_vendor_details')->with(compact('vendorDetails','admin_id'));
    }

    public function updateAdminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
            $adminDetails = Admin::where('id',$data['admin_id'])->first()->toArray();
            if($adminDetails['type']=="vendor" && $status==1){
                Vendor::where('id',$adminDetails['vendor_id'])->update(['status'=>$status]);
                // Get Vendor Details
                $getVendorDetails = Vendor::where('id',$adminDetails['vendor_id'])->first()->toArray();
                // Get Plan Details
                $getPlanDetails = Plan::where('id',$getVendorDetails['plan_id'])->first()->toArray();
                // Send Approval Email
                $email = $adminDetails['email'];
                $messageData = [
                    'email' => $adminDetails['email'],
                    'name' => $adminDetails['name'],
                    'mobile' => $adminDetails['mobile'],
                    'plan_name' => $getPlanDetails['name']
                ];

                Mail::send('emails.vendor_approved',$messageData,function($message)use($email){
                    $message->to($email)->subject('Godkjent leverandørkonto');
                });

                // Send Email to Admin
                $bcc = "admin@samling.no";
                Mail::send('emails.vendor_approved',$messageData,function($message)use($bcc){
                    $message->to($bcc)->subject('Godkjent leverandørkonto');
                });
            }

            return response()->json(['status'=>$status,'admin_id'=>$data['admin_id']]);
        }
    }

    public function planUpgrade($code){
        // Decode Vendor Email
        $email = base64_decode($code);
        $plans = Plan::where('status',1)->get()->toArray();
        $currentPlan = Vendor::select('plan_id')->where('email',$email)->first()->toArray();
        $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupby('name')->pluck('name');
        return view('front.vendors.plan_upgrade')->with(compact('plans','code','currentPlan','countries'));
    }

    public function upgradeSelectedPlan(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            // Decode Vendor Email
            $email = base64_decode($data['code']);
            // Check Vendor Email exists
            $vendorCount = Vendor::where('email',$email)->count();
            if($vendorCount>0){
                // Update Plan for Vendor
                Vendor::where('email',$email)->update(['plan_id'=>$data['plan_id'],'status'=>0]);
                Admin::where('email',$email)->update(['status'=>0]);

                // Get Vendor Details
                $getVendorDetails = Vendor::where('email',$email)->first()->toArray();

                // Get Plan Details
                $getPlanDetails = Plan::where('id',$data['plan_id'])->first()->toArray();

                $products_limit = $getPlanDetails['products_limit'];
                // Inactive all vendor products
                Product::where('vendor_id',$getVendorDetails['id'])->update(['status'=>0]);

                $vendorProducts = Product::where('vendor_id',$getVendorDetails['id'])->orderby('id','ASC')->get()->toArray();
                foreach ($vendorProducts as $key => $product) {
                    if($key<$products_limit){
                        // Active vendor product
                        Product::where('id',$product['id'])->update(['status'=>1]);  
                    }
                }

                // Send Plan Upgrade Email to Vendor
                $messageData = [
                    'email' => $email,
                    'name' => $getVendorDetails['name'],
                    'plan_name' => $getPlanDetails['name']
                ];

                Mail::send('emails.plan_upgrade',$messageData,function($message)use($email){
                    $message->to($email)->subject('Bekreftelse på endring av abonnement');
                });

                $bcc = array("admin@samling.no");

                // Send Plan Upgrade Email to Admin
                $messageData = [
                    'email' => $email,
                    'name' => $getVendorDetails['name'],
                    'plan_name' => $getPlanDetails['name']
                ];

                Mail::send('emails.plan_upgrade',$messageData,function($message)use($bcc){
                    $message->to($bcc)->subject('Bekreftelse på endring av abonnement');
                });

                return redirect('admin/dashboard')->with('success_message','Ditt abonnement er endret. Endringen vil snart godkjennes.');
            }else{
                abort(404);
            }
        }    
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function deleteVendor($id){
        try {
            DB::beginTransaction();

            // Get Vendor ID first
            $vendorId = Admin::where('id', $id)->value('vendor_id');

            if (!$vendorId) {
                throw new \Exception("Vendor ID not found for Admin ID: $id");
            }

            // Disable Admin
            Admin::where('id', $id)->update(['is_delete' => 1, 'status' => 0]);

            // Disable Vendor
            Vendor::where('id', $vendorId)->update(['is_delete' => 1, 'status' => 0]);

            // Disable Profiles
            Product::where('vendor_id', $vendorId)->update(['is_delete' => 1, 'status' => 0]);

            DB::commit();

            return redirect()->back()->with('success_message', 'Vendor has been deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack(); // Important to roll back on failure
            \Log::error("Error deleting vendor: " . $e->getMessage());
            return redirect()->back()->with('error_message', 'Something went wrong. Please try again later.');
        }
    }


}
