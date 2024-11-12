<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductsEnquiry;
use App\Models\EnquiriesResponse;
use App\Models\Product;
use App\Models\Event;
use App\Models\User;
use App\Models\Country;
use App\Models\Wishlist;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\EnquiriesVendor;
use App\Models\Vendor;
use Image;
use Auth;
use Validator;
use Session;
use Hash;
use DB;

class UserController extends Controller
{
    public function userLogin(Request $request){
        if($request->Ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required|min:6'
            ]);

            if($validator->passes()){

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                    if(Auth::user()->status==0){
                        Auth::logout();
                        return response()->json(['type'=>'inactive','message'=>'Your account is not activated! Please confirm your account to activate your account.']);
                    }

                    Auth::loginUsingId(Auth::user()->id);

                    if(Session::has('product_id')){
                        $getProductName = Product::select('product_name')->where('id',Session::get('product_id'))->first()->toArray();
                        $getProductURL = Product::productURL($getProductName['product_name']);
                        $redirectTo = url('product/'.$getProductURL.'/'.Session::get('product_id'));
                    }else if(Session::has('event_id')){
                        $getTitle = Event::select('title')->where('id',Session::get('event_id'))->first()->toArray();
                        $getEventURL = Event::getEventURL($getTitle['title']);
                        $redirectTo = url('event/'.$getEventURL.'/'.Session::get('event_id'));
                    }else{
                        $redirectTo = url('/');
                    }

                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }else{
                    return response()->json(['type'=>'incorrect','message'=>'Incorrect Email or Password!']);
                }

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }
    }

    public function userRegister(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                /*'gender' => 'required|string|max:100',*/
                /*'birth_date' => 'required|string|max:100',*/
                'country' => 'required',
                'mobile' => 'required',
                'email' => 'required|email|max:150|unique:users',
                'password' => 'required|min:6',
                'confirm_password' => 'required|min:6|same:password',
                'agree' => 'required'
            ]
        );

            if($validator->passes()){
                // Register the User
                $user = new User;
                $user->name = $data['first_name']." ".$data['last_name'];
                $user->first_name = $data['first_name'];
                $user->last_name = $data['last_name'];
                $user->gender = $data['gender'];
                $user->birth_date = $data['birth_date'];
                $user->mobile = $data['countrycode']."".$data['mobile'];
                $user->email = $data['email'];
                $user->country = $data['country'];
                $user->password = bcrypt($data['password']);
                $user->status = 1;
                $user->save();

                /* Activate the user only when user confirms his email account */

                /*$email = $data['email'];
                $messageData = ['name'=>$user->name,'email'=>$data['email'],'code'=>base64_encode($data['email'])];
                Mail::send('emails.customer_confirmation',$messageData,function($message)use($email){
                    $message->to($email)->subject('Kunderegistrering');
                });*/

                /*$bcc = array("admin@samling.no");
                $messageData = ['name'=>$user->name,'email'=>$data['email'],'code'=>base64_encode($data['email'])];
                Mail::send('emails.customer_confirmation',$messageData,function($message)use($bcc){
                    $message->to($bcc)->subject('Kunderegistrering');
                });*/

                // Redirect back user with success message
                /*$redirectTo = url('/');
                return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>'Vennligst bekreft e-posten din for å aktivere kontoen din!']);*/

                /* Activate the user straight way without sending any confirmation email */

                /*// Send Register Email
                $email = $data['email'];
                $messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];
                Mail::send('emails.register',$messageData,function($message)use($email){
                    $message->to($email)->subject('Welcome to Samling');
                });*/

                // Send Welcome Email
                $email = $data['email'];
                $messageData = ['name'=>$data['first_name']." ".$data['last_name'],'mobile'=>$data['countrycode']."".$data['mobile'],'email'=>$email];
                Mail::send('emails.customer_confirmed',$messageData,function($message)use($email){
                    $message->to($email)->subject('Kunderegistrering');
                });

                $bcc = array("admin@samling.no");
                $messageData = ['name'=>$data['first_name']." ".$data['last_name'],'mobile'=>$data['countrycode']."".$data['mobile'],'email'=>$email];
                Mail::send('emails.customer_confirmed',$messageData,function($message)use($bcc){
                    $message->to($bcc)->subject('Kunderegistrering');
                });

                /*// Send Register SMS
                $message = "Dear Customer, you have been successfully registered with Samling. Login to your account to access orders, addresses & available offers.";
                $mobile = $data['mobile'];
                Sms:sendSms($message,$mobile);*/

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    $redirectTo = url('/');
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }




            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
            
        }
    }

    public function confirmAccount($code){
        $email = base64_decode($code);
        $userCount = User::where('email',$email)->count();
        if($userCount>0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status==1){
                // Redirect the user to Login Page with error message
                return redirect('/?login=1')->with('error_message','Kontoen din er allerede aktivert. Du kan logge inn nå.');
            }else{
                User::where('email',$email)->update(['status'=>1]);

                // Send Welcome Email
                $messageData = ['name'=>$userDetails->name,'mobile'=>$userDetails->mobile,'email'=>$email];
                Mail::send('emails.customer_confirmed',$messageData,function($message)use($email){
                    $message->to($email)->subject('Kunderegistrering');
                });

                // Redirect the user to Login Page with success message
                return redirect('/?login=1')->with('success_message','Kontoen din er aktivert. Du kan logge inn nå.');
            }
        }else{
            abort(404);
        }
    }

    public function userEnquiry(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $user = User::find(Auth::user()->id);
            $enquiryCount = ProductsEnquiry::where(['user_id'=>Auth::user()->id,'product_id'=>$data['product_id'],'vendor_id'=>$data['vendor_id']])->count();
            if($enquiryCount>0){
                $enquiryDetails = ProductsEnquiry::where(['user_id'=>Auth::user()->id,'product_id'=>$data['product_id'],'vendor_id'=>$data['vendor_id']])->first();
                $response = new EnquiriesResponse;
                $response->enquiry_id = $enquiryDetails->id;
                $response->sender_id = Auth::user()->id;
                $response->sender_type = 'Customer';
                $response->message = $data['message'];
                $response->save();

                // Send Enquiry Email to User
                $email = Auth::user()->email;
                $messageData = [
                    'email' => Auth::user()->email,
                    'name' => Auth::user()->name
                ];

                /*Mail::send('emails.customer_enquiry_detail',$messageData,function($message)use($email){
                    $message->to($email)->subject('Forespørsel sendt');
                });*/

                /*$bcc = array("admin@samling.no");
                $messageData = ['name'=>$user->name,'email'=>$email];
                Mail::send('emails.customer_enquiry_detail',$messageData,function($message)use($bcc){
                    $message->to($bcc)->subject('Forespørsel sendt');
                });*/

                $productDetails = Product::select('product_name')->where('id',$data['product_id'])->first()->toArray();

                // Send Enquiry Email to Vendor
                $vendorDetails = Vendor::where('id',$data['vendor_id'])->first()->toArray();
                $email = $vendorDetails['email'];
                $messageData = [
                    'email' => $vendorDetails['email'],
                    'name' => $vendorDetails['name'],
                    'product_name' => $productDetails['product_name'],
                    'customer_name' => Auth::user()->first_name
                ];

                Mail::send('emails.vendor_enquiry_detail',$messageData,function($message)use($email){
                    $message->to($email)->subject('Ny melding fra kunde');
                });

                // Send Enquiry Email to Admin
                $vendorDetails = Vendor::where('id',$data['vendor_id'])->first()->toArray();
                $admin_email = "admin@samling.no";
                $messageData = [
                    'email' => $vendorDetails['email'],
                    'name' => $vendorDetails['name'],
                    'product_name' => $productDetails['product_name'],
                    'customer_name' => Auth::user()->first_name
                ];

                Mail::send('emails.vendor_enquiry_detail',$messageData,function($message)use($admin_email){
                    $message->to($admin_email)->subject('Ny melding fra kunde');
                });


            }else{
                DB::beginTransaction();

                /*$enquiry = new ProductsEnquiry;
                $enquiry->user_id = Auth::user()->id;
                $enquiry->product_id = $data['product_id'];
                $enquiry->vendor_id = $data['vendor_id'];
                $enquiry->save();
                $enquiry_id = DB::getPdo()->lastInsertId();

                $response = new EnquiriesResponse;
                $response->enquiry_id = $enquiry_id;
                $response->sender_id = Auth::user()->id;
                $response->sender_type = 'Customer';
                $response->message = $data['message'];
                $response->save(); */
                
                $productDetails = Product::where('id',$data['product_id'])->first();

                $enquiry = new Enquiry;
                $enquiry->photo = "";
                $enquiry->user_id = Auth::user()->id;  
                $enquiry->name = Auth::user()->name;
                $nameArr = explode(" ",$enquiry->name);
                $enquiry->first_name = $nameArr[0];
                if(isset($nameArr[1]) && $nameArr[1]!=""){
                    $enquiry->last_name = $nameArr[1];     
                }else{
                    $enquiry->last_name = "";
                }
                $enquiry->phone = Auth::user()->mobile;  
                $enquiry->email = Auth::user()->email;  
                
                $enquiry->category_id = $productDetails->category_id;
                /*$enquiry->title = $productDetails->product_name;*/
                $enquiry->address = Auth::user()->address;
                $enquiry->city = Auth::user()->city;
                $enquiry->pincode = Auth::user()->pincode;
                $enquiry->description = $data['message'];
                $enquiry->desired_price = 0;
                $enquiry->picked_up = "No";
                $enquiry->want_delivery = "No";
                $enquiry->save();
                $enquiry_detail_id = DB::getPdo()->lastInsertId();


                $enquiryv = new EnquiriesVendor;
                $enquiryv->enquiry_id = $enquiry_detail_id;
                $enquiryv->vendor_id = $data['vendor_id'];
                $enquiryv->product_id = $data['product_id'];
                $enquiryv->save();

                $enquiryp = new ProductsEnquiry;
                $enquiryp->user_id = Auth::user()->id;
                $enquiryp->vendor_id = $data['vendor_id'];
                $enquiryp->product_id = $data['product_id'];
                $enquiryp->enquiry_detail_id = $enquiry_detail_id;
                $enquiryp->save();
                $enquiry_id = DB::getPdo()->lastInsertId();

                $response = new EnquiriesResponse;
                $response->enquiry_id = $enquiry_id;
                $response->sender_id = Auth::user()->id;
                $response->sender_type = 'Customer';
                $response->message = $data['message'];
                $response->save();


                // Send Enquiry Email to User
                $email = Auth::user()->email;
                $messageData = [
                    'email' => Auth::user()->email,
                    'name' => Auth::user()->name
                ];

                /*Mail::send('emails.customer_enquiry_detail',$messageData,function($message)use($email){
                    $message->to($email)->subject('Forespørsel sendt');
                });*/

                /*$bcc = array("admin@samling.no");
                $messageData = ['name'=>$user->name,'email'=>$user->email];
                Mail::send('emails.customer_enquiry_detail',$messageData,function($message)use($bcc){
                    $message->to($bcc)->subject('Forespørsel sendt');
                });*/

                // Send Enquiry Email to Vendor
                $vendorDetails = Vendor::where('id',$data['vendor_id'])->first()->toArray();
                $email = $vendorDetails['email'];
                $messageData = [
                    'email' => $vendorDetails['email'],
                    'name' => $vendorDetails['name'],
                    'product_name' => $productDetails->product_name,
                    'customer_name' => Auth::user()->name
                ];

                Mail::send('emails.vendor_enquiry_detail',$messageData,function($message)use($email){
                    $message->to($email)->subject('Ny melding fra kunde');
                });

                DB::commit();   

            }
            
            return response()->json(['type'=>'success','message'=>'Melding sendt']);
        }
    }

    public function userAccount(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:100',
                    'last_name' => 'required|string|max:100',
                    'city' => 'required|string|max:100',
                    'state' => 'required|string|max:100',
                    'address' => 'required|string|max:100',
                    'mobile' => 'required|numeric',
                    'pincode' => 'required|digits:4',

                ]
            );

            if($validator->passes()){

                $name = $data['first_name']." ".$data['last_name'];

                // Update User Details
                User::where('id',Auth::user()->id)->update(['name'=>$name,'first_name'=>$data['first_name'],'last_name'=>$data['last_name'],'mobile'=>$data['mobile'],'city'=>$data['city'],'state'=>$data['state'],'pincode'=>$data['pincode'],'address'=>$data['address']]);

                // Redirect back user with success message
                return response()->json(['type'=>'success','message'=>'Your contact details successfully updated!']);

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            //$countries = Country::where('status',1)->get()->toArray();
            $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupby('name')->pluck('name');
            return view('front.users.account')->with(compact('countries'));
        }
    }

    public function userWishlist(){
        $wishlists = Wishlist::with('product')->where('user_id',Auth::user()->id)->get()->toArray();
        $title="Wishlist";
        return view('front.users.wishlist')->with(compact('wishlists'));
    }

    public function removeWishlist($wishid){
        $check = Wishlist::where(['user_id'=>Auth::user()->id,'id'=>$wishid])->first();
        if($check){
            Wishlist::where('id',$wishid)->delete();
            return redirect()->back()->with('flash_message_success','Wishlist item has been deleted successfully');
        }else{
            return redirect()->back()->with('flash_message_error','Something Went Wrong');
        }
    }

    public function userEnquiries(){
        $enquiries = ProductsEnquiry::query();
        $enquiries = $enquiries->where('user_id',Auth::user()->id);
        if(isset($_GET['cat'])&&$_GET['cat']!=""){
            $catIds = Category::select('id')->where('category_name',$_GET['cat'])->get()->pluck('id');
            /*dd($catIds);*/
            $productIds = Product::select('id')->whereIn('category_id',$catIds)->get()->pluck('id');
            /*dd($productIds);*/
            $enquiries = $enquiries->with(['product'=>function($query)use($productIds){
                $query->whereIn('id',$productIds);
            },'user','vendor'])->orderBy('id','Desc')->get()->toArray();
        }else{
            $enquiries = $enquiries->with(['product','user','vendor'])->orderBy('id','Desc')->get()->toArray();
            /*dd($enquiries);*/
        }
        
        
        foreach ($enquiries as $key => $enquiry) {
            $responseCount = EnquiriesResponse::where('enquiry_id',$enquiry['id'])->where('sender_type','Vendor')->count();
            if($responseCount>0){
                $enquiryResponse = EnquiriesResponse::where('enquiry_id',$enquiry['id'])->first();
                $enquiries[$key]['response'] = $enquiryResponse->response;    
            }else{
                $enquiries[$key]['response'] = "";
            }
            $unreadCount = EnquiriesResponse::where('enquiry_id',$enquiry['id'])->where('sender_type','Vendor')->where('is_unread',1)->count();
            $enquiries[$key]['unreadCount'] = $unreadCount;
        }
        /*dd($enquiries);*/
        $catenquiries = ProductsEnquiry::with('product')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
        $allcategories = array();
        foreach($catenquiries as $key => $enq){
            if(isset($enq['product']['category']['category_name'])){
                $allcategories[] = $enq['product']['category']['category_name'];    
            }
        }
        $allcategories = array_unique($allcategories);
        /*dd($enquiries);*/
        $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupby('name')->pluck('name');
        return view('front.users.enquiries')->with(compact('enquiries','allcategories','countries'));    
    }

    public function getUserEnquiries(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $enquiries = ProductsEnquiry::query();
            $enquiries = $enquiries->where('user_id',Auth::user()->id);

            // Get Pin/Unpin User Enquiries
            if(isset($data['pin_unpin'])&&$data['pin_unpin']!=""){
                $pin_unpin = $data['pin_unpin'];
                $enquiries = $enquiries->where('pin',$data['pin_unpin']);
            }else{
                $pin_unpin = "";
            }

            // Get Active/Close User Enquiries
            if(isset($data['active_close'])&&$data['active_close']!=""){
                $active_close = $data['active_close'];
                $enquiries = $enquiries->where('status',$data['active_close']);
            }else{
                $active_close = "";
            }

            // Get Category User Enquiries
            if(isset($data['cat'])&&$data['cat']!=""){
                $enqCat = $data['cat'];
                $catIds = Category::select('id')->where('category_name',$data['cat'])->get()->pluck('id');
                /*dd($catIds);*/
                $productIds = Product::select('id')->whereIn('category_id',$catIds)->get()->pluck('id');
                /*dd($productIds);*/
                $enquiries = $enquiries->with(['product'=>function($query)use($productIds){
                    $query->whereIn('id',$productIds);
                },'user','vendor'])->orderBy('id','Desc')->get()->toArray();
            }else{
                $enqCat = "";
                $enquiries = $enquiries->with(['product','user','vendor'])->orderBy('id','Desc')->get()->toArray();    
            }
        
            foreach ($enquiries as $key => $enquiry) {
                $responseCount = EnquiriesResponse::where('enquiry_id',$enquiry['id'])->where('sender_type','Vendor')->count();
                if($responseCount>0){
                    $enquiryResponse = EnquiriesResponse::where('enquiry_id',$enquiry['id'])->first();
                    $enquiries[$key]['response'] = $enquiryResponse->response;    
                }else{
                    $enquiries[$key]['response'] = "";
                }
                $unreadCount = EnquiriesResponse::where('enquiry_id',$enquiry['id'])->where('sender_type','Vendor')->where('is_unread',1)->count();
                $enquiries[$key]['unreadCount'] = $unreadCount;
            }
            /*dd($enquiries);*/
            $catenquiries = ProductsEnquiry::with('product')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
            $allcategories = array();
            foreach($catenquiries as $key => $enq){
                if(isset($enq['product']['category']['category_name'])){
                    $allcategories[] = $enq['product']['category']['category_name'];
                }
            }
            $allcategories = array_unique($allcategories);
            /*dd($allcategories);*/

            // Return the Updated Cart Item via Ajax
            return response()->json([
                'status'=>true,
                'view'=>(String)View::make('front.users.load_enquiries')->with(compact('enquiries','allcategories','pin_unpin','enqCat','active_close'))
            ]);

        }
            
    }

    public function userEnquiriesDetail($enqid){
        Session::put('page','user_enquiries_detail');
        $enquiries = EnquiriesResponse::query();
        $enquiries = $enquiries->where('enquiry_id',$enqid);
        $enquiries = $enquiries->with(['enquiry'])->get()->toArray();
        /*dd($enquiries);*/
        $enquiry_id = $enqid;
        // Update is_unread to 0
        EnquiriesResponse::where('enquiry_id',$enqid)->where('sender_type','Vendor')->update(['is_unread'=>0]);
        return view('front.users.enquiries_detail')->with(compact('enquiries','enquiry_id'));    
    }

    public function userEnquiryResponse(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            /*$validator = Validator::make($request->all(), [
                    'message' => 'required|string|max:100',
                    'image' => 'mimes:jpeg,jpg,png|max:1024',
                ]
            );*/

            if(isset($data['images'])){

                $countImages = count($data['images']);

                $rules = [
                    'message' => 'required|string|max:100',
                    'images.*' => 'mimes:jpeg,jpg,png|max:1024',
                ];

                if($countImages==1){
                    $customMessages = [
                        'images.*.mimes' => 'Error: Image must be of type jpeg, jpg or png',
                    ]; 
                    $validator = Validator::make($data, $rules, $customMessages);   
                }else{
                    $validator = Validator::make($data, $rules);  
                }

                //Now check validation:
                if ($validator->fails()){ 
                    return redirect()->back()->with('errors',$validator->errors());
                }    
            }

            $validator = Validator::make($request->all(), [
                    'message' => 'required|string|max:100',
                ]
            );

            if($validator->passes()){
                $response = new EnquiriesResponse;
                $response->enquiry_id = $data['enquiry_id'];
                $response->sender_id = Auth::user()->id;
                $response->sender_type = 'Customer';
                $response->message = $data['message'];
                
                // Upload Multiple Images
                if($request->hasFile('images')){
                    $images = $request->file('images');
                    /*echo "<pre>"; print_r($images); die;*/
                    $imageNames = "";
                    foreach ($images as $key => $image) {
                        // Generate Temp Image
                        $image_tmp = Image::make($image);
                        // Get Image Name
                        $image_name = $image->getClientOriginalName();
                        // Get Image Extension
                        $extension = $image->getClientOriginalExtension();
                        // Generate New Image Name
                        $imageName = 'image-'.rand(1111,999999).'.'.$extension;
                        $imagePath = 'front/images/enquiries_images/'.$imageName;
                        // Upload the Image
                        Image::make($image_tmp)->save($imagePath);
                        $imageNames .= $imageName.","; 
                    }
                    $response->images = $imageNames;
                }

                $response->save();

                $message = 'Meldingen er sendt';
                return redirect()->back()->with('success_message',$message);
            }else{
                $message = 'Error';
                return redirect()->back()->with('error_message',$message)->withErrors($validator,'response');
            }
        }
    }

    public function userUpdatePassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'new_password' => 'required|min:6',
                    'confirm_password' => 'required|min:6|same:new_password'

                ]
            );

            if($validator->passes()){

                $current_password = $data['current_password'];
                $checkPassword = User::where('id',Auth::user()->id)->first();
                if(Hash::check($current_password,$checkPassword->password)){

                    // Update User Current Password
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($data['new_password']);
                    $user->save();

                    // Redirect back user with success message
                return response()->json(['type'=>'success','message'=>'Account password successfully updated!']);

                }else{
                    // Redirect back user with error message
                    return response()->json(['type'=>'incorrect','message'=>'Your current password is incorrect!']);    
                }


                // Redirect back user with success message
                return response()->json(['type'=>'success','message'=>'Your contact/billing details successfully updated!']);

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            return view('front.users.update_password');
        }
    }

    public function forgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $validator = Validator::make($request->all(), [
                    'email' => 'required|email|max:150|exists:users'
                ],
                [
                    'email.exists'=>'Email does not exists!'
                ]
            );

            if($validator->passes()){
                // Generate New Password
                $new_password = Str::random(16);

                // Update New Password
                User::where('email',$data['email'])->update(['password'=>bcrypt($new_password)]);

                // Get User Details
                $userDetails = User::where('email',$data['email'])->first()->toArray();

                // Send Email to User
                $email = $data['email'];
                $messageData = ['name'=>$userDetails['name'],'email'=>$email,'password'=>$new_password];
                Mail::send('emails.user_forgot_password',$messageData,function($message) use($email){
                    $message->to($email)->subject('Glemt passord');
                });

                // Send Email to Admin
                $bcc = array("admin@samling.no");
                Mail::send('emails.user_forgot_password',$messageData,function($message) use($bcc){
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

    public function userLogout(){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
