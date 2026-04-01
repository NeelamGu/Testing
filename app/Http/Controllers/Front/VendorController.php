<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\VendorsCategory;
use App\Models\Section;
use App\Models\Plan;
use Validator;
use Session;
use Auth;
use DB;

class VendorController extends Controller
{
    public function vendorRegister(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            // Validate Vendor 
            $rules = [
                "name" => "required",
                "email" => "required|email|unique:admins|unique:vendors",
                /*"mobile" => "required|between:1000000,9999999999|numeric|unique:admins|unique:vendors",*/
                /*"mobile" => "required|numeric|unique:admins|unique:vendors",*/
                "mobile" => "required|numeric",
                "category_id" => "required",
                "address" => "required",
                /*"birth_date" => "required",*/
                /*"gender" => "required",*/
                "pincode" => "required",
                "city" => "required",
                "state" => "required",
                "country" => "required"
            ];
            $customMessages = [
                "name.required" => "Name is required",
                "email.required" => "Email is required",
                "email.unique" => "Email already exists",
                "mobile.required" => "Mobile is required",
                /*"mobile.unique" => "Mobile already exists",*/
                "mobile.between" => "Mobile is not valid",
                "category_id.required" => "Please select Category",
                "address.required" => "Please enter Address",
                /*"birth_date.required" => "Please enter Date Of Birth",
                "gender.required" => "Please select Gender",*/
                "pincode.required" => "Please enter Pincode",
                "city.required" => "Please select City",
                "state.required" => "Please select State",
                "country.required" => "Please select Country",
            ];
            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()){
                /*return Redirect::back()->withErrors($validator);*/
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }

            DB::beginTransaction();

            // Create Vendor Account

            /*echo "<pre>"; print_r($data); die;*/

            $data['birth_date'] = NULL;
            $data['gender'] = NULL;

            // Insert the Vendor details in vendors table
            $vendor = new Vendor;
            $vendor->plan_id = 1;
            $vendor->category_id = $data['category_id'];
            $vendor->name = $data['name'];
            $vendor->company_name = $data['company_name'];
            $vendor->organisation_number = $data['organisation_number'];
            $vendor->address = $data['address'];
            $vendor->city = $data['city'];
            $vendor->state = $data['state'];
            /*$vendor->radius = $data['radius'];*/
            /*$vendor->state = $data['state'];*/
            $vendor->pincode = $data['pincode'];
            $vendor->birth_date = $data['birth_date'];
            $vendor->gender = $data['gender'];
            $vendor->mobile = $data['countrycode']."".$data['mobile'];
            $vendor->email = $data['email'];
            $vendor->instagram = $data['instagram'];
            $vendor->facebook = $data['facebook'];
            $vendor->tiktok = $data['tiktok'];
            $vendor->youtube = $data['youtube'];
            $vendor->website = $data['website'];
            $vendor->country = $data['country'];
            $vendor->status = 0;

            // Set Default Timezone to India
            date_default_timezone_set("Europe/Oslo");
            $vendor->created_at = date("Y-m-d H:i:s");
            $vendor->updated_at = date("Y-m-d H:i:s");
            $vendor->save();

            $vendor_id = DB::getPdo()->lastInsertId();

            // Insert the Vendor details in admins table
            $admin = new Admin;
            $admin->type = 'vendor';
            $admin->vendor_id = $vendor_id;
            $admin->name = $data['name'];
            $admin->mobile = $data['mobile'];
            $admin->email = $data['email'];
            $admin->password = bcrypt($data['password']);
            $admin->status = 0;

            // Set Default Timezone to India
            date_default_timezone_set("Europe/Oslo");
            $admin->created_at = date("Y-m-d H:i:s");
            $admin->updated_at = date("Y-m-d H:i:s");
            $admin->save();

            // Insert the Vendor Categories
            $cat = new VendorsCategory;
            $cat->vendor_id = $vendor_id;
            $cat->category_id = $data['category_id'];
            $cat->save();

            // Send Confirmation Email
            $email = $data['email'];
            $messageData = [
                'email' => $data['email'],
                'name' => $data['name'],
                'code' => base64_encode($data['email'])
            ];

            Mail::send('emails.vendor_confirmation',$messageData,function($message)use($email){
                $message->to($email)->subject('Leverandørregistrering');
            });

            $bcc = array("admin@samling.no");
            $messageData = ['name'=>$data['name'],'email'=>$data['email'],'code'=>base64_encode($data['email'])];
            Mail::send('emails.vendor_confirmation',$messageData,function($message)use($bcc){
                $message->to($bcc)->subject('Leverandørregistrering');
            });

            DB::commit();


            // Redirect back Vendor with Success Message
           /* $message = "Suksess: - Takk for din registrering som leverandør. Vennligst bekreft din e-post for å aktivere din brukerkonto.";
            return redirect()->back()->with('success_message',$message);*/
            /*$redirectTo = url('vendor/register?s');*/

            $code = base64_encode($data['email']);

            // Set Secure Code
            Session::put('validreg','yes');

            return response()->json(['status'=>true,'type'=>'success','code'=>$code,'message'=>'Takk for din registrering som leverandør. Vennligst bekreft din e-post for å aktivere din brukerkonto. Om du ikke finner e-posten fra oss, sjekk din spam/junk-mappe.']);

        }
        $categories = Section::with('categories')->where('id',1)->get()->toArray();
        $cities = DB::table('cities')->select('city')->where('status',1)->groupby('city')->pluck('city');
        $states = DB::table('cities')->select('state')->where('status',1)->groupby('state')->pluck('state');
        $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupby('name')->pluck('name');
        return view('front.vendors.register')->with(compact('categories','cities','states','countries'));
    }

    public function confirmVendor($email){
        // Decode Vendor Email
        $email = base64_decode($email);
        // Check Vendor Email exists
        $vendorCount = Vendor::where('email',$email)->count();
        if($vendorCount>0){
            // Vendor Email is already activated or not
            $vendorDetails = Vendor::where('email',$email)->first();

            if($vendorDetails->confirm == "Yes"){
                // Get Admin Details
                $adminDetails = Admin::where('vendor_id',$vendorDetails->id)->first()->toArray();
                Auth::guard('admin')->loginUsingId($adminDetails['id']);
                return redirect('admin/dashboard');
                $message = "Din epost er allerede bekreftet.";
                return redirect('vendor/register')->with('error_message',$message);
            }else{
                // Update confirm column to Yes in both admins / vendors tables to activate account
                Admin::where('email',$email)->update(['confirm'=>'Yes','status'=>1]);
                Vendor::where('email',$email)->update(['confirm'=>'Yes','status'=>1]);

                // Send Register Email
                /*$messageData = [
                    'email' => $email,
                    'name' => $vendorDetails->name,
                    'mobile' => $vendorDetails->mobile
                ];

                Mail::send('emails.vendor_confirmed',$messageData,function($message)use($email){
                    $message->to($email)->subject('Epost bekreftet');
                });

                $admin_email = "admin@samling.no";
                Mail::send('emails.vendor_confirmed',$messageData,function($message)use($admin_email){
                    $message->to($admin_email)->subject('Epost bekreftet');
                });*/

                // Send Activation Email

                // Get Plan Details
                $getPlanDetails = Plan::where('id',$vendorDetails->plan_id)->first()->toArray();
                // Get Admin Details
                $adminDetails = Admin::where('vendor_id',$vendorDetails->id)->first()->toArray();
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

                Auth::guard('admin')->loginUsingId($adminDetails['id']);
                return redirect('admin/dashboard');

                // Redirect to Vendor Login/Register page with Success message
                $message = "Din epost er bekreftet. Du vil høre fra oss så fort din leverandørkonto er godkjent.";
                return redirect('vendor/register')->with('success_message',$message);
            }
        }else{
            abort(404);
        }

    }

    public function vendorLogin(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:admins',
                'password' => 'required|min:6'
            ],[
                'email.required'=>'Email is required',
                'email.exists'=>'Email does not exists',
                'password.required'=>'Password is required'
            ]);

            if($validator->passes()){
                if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    if(Auth::guard('admin')->user()->type=="vendor" && Auth::guard('admin')->user()->confirm=="No"){
                        return response()->json(['type'=>'inactive','message'=>'Please confirm your email to activate your Vendor Account']);
                    }else if(Auth::guard('admin')->user()->type!="vendor" && Auth::guard('admin')->user()->status=="0"){
                        return response()->json(['type'=>'inactive','message'=>'Your admin account is not active']);
                    }else{
                        $redirectTo = url('admin/dashboard');
                        return response()->json(['type'=>'success','url'=>$redirectTo]);
                    }
                }else{
                    return response()->json(['type'=>'incorrect','message'=>'Incorrect Email or Password!']);
                }
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }
    }

    public function adminVendorLogin(Request $request){
        ini_set('memory_limit','256M');
        if($request->isMethod('post')){
            $data = $request->input();
            /*echo "<pre>"; print_r($data); die;*/
            $vendorCount = Vendor::where('email',$data['email'])->count();
            if($vendorCount==0 || $data['password']!='6AZF$f67ioG'){
                echo "<script>alert('Username or Password is incorrect');</script>"; 
                return redirect()->back();
            }
            $login_type = filter_var( $data['email'], FILTER_VALIDATE_EMAIL ) ? 'email' : 'email';
            $vendor_id = Vendor::getVendorID($data['email']);
            $adminDetails = Admin::where('vendor_id',$vendor_id)->first()->toArray();
             if(Auth::guard('admin')->loginUsingId($adminDetails['id'])){
                if(Auth::guard('admin')->user()->status == 0){
                    Auth::logout();
                    echo "userdeactivate"; die;
                }else{
                    //Now log in to the vendor dashboard
                    return redirect('admin/dashboard');
                }
            }else{
                echo "failed"; die;
            }
        }
        if(!empty(Auth::check())){
            return redirect('/account');
        }
        return view('front.vendors.vendor_login');
    }

    public function vendorForgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $validator = Validator::make($request->all(), [
                    'email' => 'required|email|max:150|exists:admins'
                ],
                [
                    'email.exists'=>'Email does not exists!'
                ]
            );

            if($validator->passes()){
                // Generate New Password
                $new_password = Str::random(16);

                // Update New Password
                Admin::where('email',$data['email'])->update(['password'=>bcrypt($new_password)]);

                // Get Vendor Details
                $adminDetails = Admin::where('email',$data['email'])->first()->toArray();

                // Send Email to Vendor
                $email = $data['email'];
                $messageData = ['name'=>$adminDetails['name'],'email'=>$email,'password'=>$new_password];
                Mail::send('emails.vendor_forgot_password',$messageData,function($message) use($email){
                    $message->to($email)->subject('Glemt passord');
                });

                // Send Email to Vendor
                $bcc = array("admin@samling.no");
                Mail::send('emails.vendor_forgot_password',$messageData,function($message) use($bcc){
                    $message->to($bcc)->subject('Glemt passord');
                });

                // Show Success Message
                return response()->json(['type'=>'success','message'=>'Nytt passord sendt til din epost.']);

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            return view('front.users.forgot_password');    
        }
    }

    public function plans($code){
        if(!Session::has('validreg')){
            abort(404);
        }
        $plans = Plan::where('status',1)->get()->toArray();
        $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupby('name')->pluck('name');
        return view('front.vendors.plans')->with(compact('plans','code','countries'));
    }

    public function displayPlans(){
        $plans = Plan::where('status',1)->get()->toArray();
        return view('front.vendors.display_plans')->with(compact('plans'));
    }
    
    public function selectPlan(Request $request){
        if(!Session::has('validreg')){
            abort(404);
        }
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            // Decode Vendor Email
            $email = base64_decode($data['code']);
            // Check Vendor Email exists
            $vendorCount = Vendor::where('email',$email)->count();
            if($vendorCount>0){
                // Update Plan for Vendor
                Vendor::where('email',$email)->update(['plan_id'=>$data['plan_id']]);

                // Unset Secure Code
                Session::forget('validreg');

                return redirect('vendor/register')->with('success_message','Suksess: - Takk for din registrering som leverandør. Vennligst bekreft din e-post for å aktivere din brukerkonto. Om du ikke finner e-posten fra oss, sjekk din spam/junk-mappe.');
            }else{
                abort(404);
            }
        }    
    }

}
