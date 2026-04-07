<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
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
use App\Models\UserInvitation;
use Image;
use Auth;
use Validator;
use Session;
use Hash;
use DB;
use Carbon\Carbon;

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
                    $this->refreshProfileNoteMessage(Auth::user()->first_name ?? null);

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
                'birth_date' => 'date_format:Y-m-d',
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
                    $this->refreshProfileNoteMessage($data['first_name'] ?? null);
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
        Session::put('page','user_enquiry');
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

                // Update updated_at date in enquiries table
                $updated_at = Carbon::now();
                ProductsEnquiry::where('id',$enquiryDetails->id)->update(['updated_at'=>$updated_at]);

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

                // Send Test Email
                $testEmail = "jaspreet@rtpltech.com";
                Mail::send('emails.vendor_enquiry_detail',$messageData,function($message)use($testEmail){
                    $message->to($testEmail)->subject('Ny melding fra kunde');
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

                $bcc = array("admin@samling.no");
                $messageData = ['name'=>$user->name,'email'=>$user->email];
                Mail::send('emails.customer_enquiry_detail',$messageData,function($message)use($bcc){
                    $message->to($bcc)->subject('Forespørsel sendt');
                });

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

                // Send Test Email
                $testEmail = "jaspreet@rtpltech.com";
                Mail::send('emails.vendor_enquiry_detail',$messageData,function($message)use($testEmail){
                    $message->to($testEmail)->subject('Ny melding fra kunde');
                });

                DB::commit();   

            }
            
            return response()->json(['type'=>'success','message'=>'Melding sendt']);
        }
    }

    public function userAccount(Request $request){
        Session::put('page','user_account');
        if($request->ajax()){
            if($request->hasFile('profile_image') && !$request->has('first_name')){
                $imageValidator = Validator::make($request->all(), [
                    'profile_image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
                ]);

                if(!$imageValidator->passes()){
                    return response()->json(['type'=>'error','errors'=>$imageValidator->messages()],422);
                }

                try{
                    $targetDir = public_path('front/images/user_images');
                    if(!File::exists($targetDir)){
                        File::makeDirectory($targetDir,0755,true);
                    }

                    $targetFilename = 'profile-'.Auth::user()->id.'.jpg';
                    $targetPath = $targetDir.DIRECTORY_SEPARATOR.$targetFilename;

                    Image::make($request->file('profile_image'))
                        ->fit(320,320,function($constraint){
                            $constraint->upsize();
                        })
                        ->save($targetPath,85,'jpg');

                    return response()->json([
                        'type' => 'success',
                        'message' => 'Profilbildet er oppdatert.',
                        'image_url' => asset('front/images/user_images/'.$targetFilename).'?v='.time(),
                    ]);
                }catch(\Throwable $e){
                    \Log::error('Failed to save user profile image',[
                        'userId' => Auth::id(),
                        'error' => $e->getMessage(),
                    ]);

                    return response()->json([
                        'type' => 'error',
                        'message' => 'Kunne ikke oppdatere profilbildet. Prøv igjen.',
                    ],500);
                }
            }

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
                    'panel_bg_color' => ['nullable','regex:/^#[A-Fa-f0-9]{6}$/'],
                    'panel_accent_color' => ['nullable','regex:/^#[A-Fa-f0-9]{6}$/'],

                ]
            );

            if($validator->passes()){

                $name = $data['first_name']." ".$data['last_name'];

                $panelBgColor = $data['panel_bg_color'] ?? null;
                $panelAccentColor = $data['panel_accent_color'] ?? null;

                // Update User Details
                User::where('id',Auth::user()->id)->update([
                    'name'=>$name,
                    'first_name'=>$data['first_name'],
                    'last_name'=>$data['last_name'],
                    'mobile'=>$data['mobile'],
                    'city'=>$data['city'],
                    'state'=>$data['state'],
                    'pincode'=>$data['pincode'],
                    'address'=>$data['address'],
                    'panel_bg_color'=>$panelBgColor,
                    'panel_accent_color'=>$panelAccentColor,
                ]);

                // Redirect back user with success message
                return response()->json(['type'=>'success','message'=>'Your contact details successfully updated!']);

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            //$countries = Country::where('status',1)->get()->toArray();
            $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupby('name')->pluck('name');

            if(!Session::has('profile_note_message')){
                $this->refreshProfileNoteMessage(Auth::user()->first_name ?? null);
            }
            $profileNoteMessage = Session::get('profile_note_message');

            $userId = Auth::user()->id;
            $enquiryIds = ProductsEnquiry::where('user_id', $userId)->pluck('id');

            $responseStats = collect();
            if ($enquiryIds->count() > 0) {
                $responseStats = EnquiriesResponse::select(
                    'enquiry_id',
                    DB::raw('MAX(created_at) as last_message_at'),
                    DB::raw("SUM(CASE WHEN sender_type='Vendor' THEN 1 ELSE 0 END) as vendor_responses"),
                    DB::raw("SUM(CASE WHEN sender_type='Vendor' AND is_unread=1 THEN 1 ELSE 0 END) as unread_vendor")
                )->whereIn('enquiry_id', $enquiryIds)
                 ->groupBy('enquiry_id')
                 ->get()
                 ->keyBy('enquiry_id');
            }

            $recentEnquiries = ProductsEnquiry::with(['product', 'vendor'])
                ->where('user_id', $userId)
                ->orderBy('updated_at', 'desc')
                ->limit(6)
                ->get();

            foreach ($recentEnquiries as $enquiry) {
                $stats = $responseStats->get($enquiry->id);
                $enquiry->vendor_responses = $stats ? (int) $stats->vendor_responses : 0;
                $enquiry->unread_vendor = $stats ? (int) $stats->unread_vendor : 0;
                $enquiry->last_message_at = $stats ? $stats->last_message_at : $enquiry->updated_at;

                $latestResponse = EnquiriesResponse::where('enquiry_id', $enquiry->id)
                    ->orderBy('id', 'desc')
                    ->first();
                $latestMessage = $latestResponse ? (string)($latestResponse->message ?? '') : '';
                $enquiry->latest_message_preview = !empty($latestMessage)
                    ? Str::limit(strip_tags($latestMessage), 88)
                    : '';
                $enquiry->latest_sender_type = $latestResponse ? (string)($latestResponse->sender_type ?? '') : '';
            }

            $dashboardStats = [
                'total_enquiries' => ProductsEnquiry::where('user_id', $userId)->count(),
                'active_enquiries' => ProductsEnquiry::where('user_id', $userId)->where('status', 1)->count(),
                'closed_enquiries' => ProductsEnquiry::where('user_id', $userId)->where('status', 0)->count(),
                'vendor_replied_enquiries' => EnquiriesResponse::whereIn('enquiry_id', $enquiryIds)
                    ->where('sender_type', 'Vendor')
                    ->distinct()
                    ->count('enquiry_id'),
                'unread_vendor_messages' => EnquiriesResponse::whereIn('enquiry_id', $enquiryIds)
                    ->where('sender_type', 'Vendor')
                    ->where('is_unread', 1)
                    ->count(),
                'wishlist_count' => Wishlist::where('user_id', $userId)->count(),
            ];

            $wishlistPreview = Wishlist::with('product')
                ->where('user_id', $userId)
                ->orderBy('id', 'desc')
                ->limit(4)
                ->get();

            return view('front.users.account')->with(compact(
                'countries',
                'dashboardStats',
                'recentEnquiries',
                'wishlistPreview',
                'profileNoteMessage'
            ));
        }
    }

    private function refreshProfileNoteMessage($firstName = null){
        $name = trim((string)$firstName);
        if($name === ''){
            $name = trim((string)(Auth::user()->first_name ?? ''));
        }
        if($name === ''){
            $name = 'venn';
        }

        $messages = [
            'Velkommen tilbake, '.$name.'! Klar for å planlegge noe hyggelig?',
            'Hei '.$name.'! Sjokolade eller bløtkake til neste feiring?',
        ];

        Session::put('profile_note_message', $messages[array_rand($messages)]);
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

    public function userEnquiries(Request $request){
        Session::put('page','user_enquiries');
        $message_type = $request->get('message_type', '');
        $active_close = $request->get('active_close', '');
        $enqCat = $request->get('cat', '');
        $enquiries = ProductsEnquiry::query();
        $enquiries = $enquiries->where('user_id',Auth::user()->id);

        if($enqCat!=""){
            $catIds = Category::select('id')->where('category_name',$enqCat)->get()->pluck('id');
            /*dd($catIds);*/
            $productIds = Product::select('id')->whereIn('category_id',$catIds)->get()->pluck('id');
            /*dd($productIds);*/
            $enquiries = $enquiries->with(['product'=>function($query)use($productIds){
                $query->whereIn('id',$productIds);
            },'user','vendor','enquiryDetail'])
            ->orderBy('status','Desc')
            ->orderBy('updated_at','Desc')
            ->get()->toArray();
        }else{
            $enquiries = $enquiries->with(['product','user','vendor','enquiryDetail'])
            ->orderBy('status','Desc')
            ->orderBy('updated_at','Desc')
            ->get()->toArray();
            //dd($enquiries);
        }
        
        $enquiries = $this->attachEnquiryConversationMeta($enquiries);

        if($message_type!=""){
            $enquiries = array_values(array_filter($enquiries,function($enquiry) use ($message_type){
                $type = strtolower($enquiry['messageType'] ?? 'direkte');
                if($message_type=="assignment"){
                    return $type=="oppdrag";
                }
                if($message_type=="direct"){
                    return $type=="direkte";
                }
                return true;
            }));
        }else{
            // Messages tab should contain only actual conversations.
            $enquiries = array_values(array_filter($enquiries,function($enquiry){
                return !empty($enquiry['hasMessages']);
            }));
        }

        // Keep a status-scope copy for filter counters before applying status filter
        $statusScopeEnquiries = $enquiries;
        $totalAssignments = count($statusScopeEnquiries);
        $activeAssignments = count(array_filter($statusScopeEnquiries, function($enquiry){
            return (int)($enquiry['status'] ?? 0) === 1;
        }));
        $completedAssignments = count(array_filter($statusScopeEnquiries, function($enquiry){
            return (int)($enquiry['status'] ?? 0) === 0;
        }));

        if($active_close!=="" && ($active_close==='0' || $active_close==='1')){
            $enquiries = array_values(array_filter($enquiries, function($enquiry) use ($active_close){
                return (int)($enquiry['status'] ?? 0) === (int)$active_close;
            }));
        }

        usort($enquiries, function($a, $b){
            $statusA = (int)($a['status'] ?? 0);
            $statusB = (int)($b['status'] ?? 0);
            if($statusA !== $statusB){
                return $statusB <=> $statusA;
            }

            $dateA = strtotime($a['updated_at'] ?? $a['created_at'] ?? '1970-01-01');
            $dateB = strtotime($b['updated_at'] ?? $b['created_at'] ?? '1970-01-01');
            return $dateB <=> $dateA;
        });

        $desktopEnquiries = $this->buildDesktopGroupedEnquiries($enquiries);
        $selectedEnquiryId = $this->resolveSelectedEnquiryId($desktopEnquiries, $request->get('selected_enquiry_id', ''));
        $selectedConversation = $this->buildSelectedConversationPayload($selectedEnquiryId);

        /*dd($enquiries);*/
        $catenquiries = ProductsEnquiry::with('product')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
        $allcategories = array();
        foreach($catenquiries as $key => $enq){
            if(isset($enq['product']['category']['category_name'])){
                $allcategories[] = $enq['product']['category']['category_name'];    
            }
        }
        $allcategories = array_values(array_unique($allcategories));
        sort($allcategories, SORT_NATURAL | SORT_FLAG_CASE);
        /*dd($enquiries);*/
        return view('front.users.enquiries')->with(compact('enquiries','desktopEnquiries','selectedEnquiryId','selectedConversation','allcategories','message_type','active_close','enqCat','totalAssignments','activeAssignments','completedAssignments'));    
    }

    public function getUserEnquiries(Request $request){
        Session::put('page','user_enquiries');
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $enquiries = ProductsEnquiry::query();
            $enquiries = $enquiries->where('user_id',Auth::user()->id)
            ->orderBy('status','Desc')
            ->orderBy('updated_at','Desc');

            if(isset($data['active_close'])&&$data['active_close']!=""){
                $active_close = $data['active_close'];
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
                },'user','vendor','enquiryDetail'])->get()->toArray();
            }else{
                $enqCat = "";
                $enquiries = $enquiries->with(['product','user','vendor','enquiryDetail'])->get()->toArray();    
            }

            if(isset($data['message_type'])&&$data['message_type']!=""){
                $message_type = $data['message_type'];
            }else{
                $message_type = "";
            }
        
            $enquiries = $this->attachEnquiryConversationMeta($enquiries);

            if($message_type!=""){
                $enquiries = array_values(array_filter($enquiries,function($enquiry) use ($message_type){
                    $type = strtolower($enquiry['messageType'] ?? 'direkte');
                    if($message_type=="assignment"){
                        return $type=="oppdrag";
                    }
                    if($message_type=="direct"){
                        return $type=="direkte";
                    }
                    return true;
                }));
            }else{
                // Messages tab should contain only actual conversations.
                $enquiries = array_values(array_filter($enquiries,function($enquiry){
                    return !empty($enquiry['hasMessages']);
                }));
            }

            // Keep a status-scope copy for filter counters before applying status filter
            $statusScopeEnquiries = $enquiries;
            $totalAssignments = count($statusScopeEnquiries);
            $activeAssignments = count(array_filter($statusScopeEnquiries, function($enquiry){
                return (int)($enquiry['status'] ?? 0) === 1;
            }));
            $completedAssignments = count(array_filter($statusScopeEnquiries, function($enquiry){
                return (int)($enquiry['status'] ?? 0) === 0;
            }));

            if($active_close!=="" && ($active_close==='0' || $active_close==='1')){
                $enquiries = array_values(array_filter($enquiries, function($enquiry) use ($active_close){
                    return (int)($enquiry['status'] ?? 0) === (int)$active_close;
                }));
            }

            usort($enquiries, function($a, $b){
                $statusA = (int)($a['status'] ?? 0);
                $statusB = (int)($b['status'] ?? 0);
                if($statusA !== $statusB){
                    return $statusB <=> $statusA;
                }

                $dateA = strtotime($a['updated_at'] ?? $a['created_at'] ?? '1970-01-01');
                $dateB = strtotime($b['updated_at'] ?? $b['created_at'] ?? '1970-01-01');
                return $dateB <=> $dateA;
            });

            $desktopEnquiries = $this->buildDesktopGroupedEnquiries($enquiries);
            $selectedEnquiryId = $this->resolveSelectedEnquiryId($desktopEnquiries, $data['selected_enquiry_id'] ?? '');
            /*dd($enquiries);*/
            $catenquiries = ProductsEnquiry::with('product')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
            $allcategories = array();
            foreach($catenquiries as $key => $enq){
                if(isset($enq['product']['category']['category_name'])){
                    $allcategories[] = $enq['product']['category']['category_name'];
                }
            }
            $allcategories = array_values(array_unique($allcategories));
            sort($allcategories, SORT_NATURAL | SORT_FLAG_CASE);
            /*dd($allcategories);*/

            // Return the Updated Cart Item via Ajax
            return response()->json([
                'status'=>true,
                'view'=>(String)View::make('front.users.load_enquiries')->with(compact('enquiries','desktopEnquiries','selectedEnquiryId','allcategories','enqCat','active_close','message_type','totalAssignments','activeAssignments','completedAssignments'))
            ]);

        }
            
    }

    public function userEnquiriesDetail($enqid){
        Session::put('page','user_enquiries_detail');
        $baseEnquiry = ProductsEnquiry::with(['product','enquiryDetail','vendor'])
            ->where('id',$enqid)
            ->where('user_id',Auth::user()->id)
            ->first();

        if(!$baseEnquiry){
            abort(404);
        }

        $enquiryIds = [$baseEnquiry->id];

        $enquiries = EnquiriesResponse::whereIn('enquiry_id',$enquiryIds)
            ->with(['enquiry'])
            ->orderBy('id','Asc')
            ->get()
            ->toArray();

        $enquiry_id = $enqid;

        // Update is_unread to 0
        EnquiriesResponse::whereIn('enquiry_id',$enquiryIds)
            ->where('sender_type','Vendor')
            ->update(['is_unread'=>0]);

        $conversationTitle = 'Samtale med';
        $conversationVendorName = 'Leverandør';
        $conversationVendorUrl = '';
        if(!empty($baseEnquiry->product) && !empty($baseEnquiry->product->product_name)){
            $conversationVendorName = $baseEnquiry->product->product_name;
            $conversationTitle = 'Samtale med '.$conversationVendorName;
            $productSlug = Product::productURL($conversationVendorName);
            if(!empty($productSlug) && !empty($baseEnquiry->product->id)){
                $conversationVendorUrl = url('product/'.$productSlug.'/'.$baseEnquiry->product->id);
            }
        }

        $activeTopTab = !empty($baseEnquiry->enquiry_detail_id) ? 'oppdrag' : 'meldinger';
        $conversationSubtitle = !empty($baseEnquiry->enquiry_detail_id)
            ? 'Melding i dette oppdraget mellom deg og leverandør.'
            : 'Direkte melding mellom deg og leverandør.';
        $backUrl = !empty($baseEnquiry->enquiry_detail_id)
            ? url('user/enquiries/'.$baseEnquiry->id.'/overview')
            : url('user/enquiries/');
        [$customerLabel, $vendorLabel] = $this->getChatParticipantLabels($baseEnquiry);

        return view('front.users.enquiries_detail')->with(compact('enquiries','enquiry_id','conversationTitle','conversationVendorName','conversationVendorUrl','activeTopTab','conversationSubtitle','backUrl','customerLabel','vendorLabel'));
    }

    public function userEnquiryOverview($enqid){
        Session::put('page','user_enquiries_detail');
        $baseEnquiry = ProductsEnquiry::with(['product','enquiryDetail'])
            ->where('id',$enqid)
            ->where('user_id',Auth::user()->id)
            ->first();

        if(!$baseEnquiry){
            abort(404);
        }

        // Direct enquiries do not have assignment overviews.
        if(empty($baseEnquiry->enquiry_detail_id)){
            return redirect()->to(url('user/enquiries/'.$baseEnquiry->id));
        }

        $allAssignmentThreads = ProductsEnquiry::with(['product','vendor'])
            ->where('user_id',Auth::user()->id)
            ->where('enquiry_detail_id',$baseEnquiry->enquiry_detail_id)
            ->orderBy('status','Desc')
            ->orderBy('updated_at','Desc')
            ->get();

        $threads = [];
        foreach($allAssignmentThreads as $thread){
            $lastMessage = EnquiriesResponse::where('enquiry_id',$thread->id)
                ->orderBy('id','Desc')
                ->first();

            $vendorMessagesCount = EnquiriesResponse::where('enquiry_id',$thread->id)
                ->where('sender_type','Vendor')
                ->count();

            $unreadCount = EnquiriesResponse::where('enquiry_id',$thread->id)
                ->where('sender_type','Vendor')
                ->where('is_unread',1)
                ->count();

            $threads[] = [
                'id' => $thread->id,
                'title' => $thread->product->product_name ?? 'Ukjent leverandør',
                'city' => $thread->product->city ?? '',
                'status' => (int)$thread->status,
                'has_vendor_message' => $vendorMessagesCount > 0,
                'unread_count' => (int)$unreadCount,
                'preview' => $lastMessage && !empty($lastMessage->message)
                    ? Str::limit(strip_tags($lastMessage->message), 110)
                    : 'Ingen ny melding ennå, åpne dialogen for detaljer.',
                'last_date' => $lastMessage
                    ? date('d.m.y, H:i', strtotime($lastMessage->created_at))
                    : date('d.m.y, H:i', strtotime($thread->updated_at ?? $thread->created_at)),
                'message_url' => url('user/enquiries/'.$thread->id),
            ];
        }

        $threadsWithMessages = array_values(array_filter($threads, function($thread){
            return !empty($thread['has_vendor_message']);
        }));

        if(count($threadsWithMessages) > 0){
            $threads = $threadsWithMessages;
        }

        usort($threads, function($a, $b){
            $unreadCompare = (int)($b['unread_count'] ?? 0) <=> (int)($a['unread_count'] ?? 0);
            if($unreadCompare !== 0){
                return $unreadCompare;
            }

            $dateA = strtotime($a['last_date'] ?? '1970-01-01');
            $dateB = strtotime($b['last_date'] ?? '1970-01-01');
            return $dateB <=> $dateA;
        });

        $assignmentTitle = 'Oppdrag';
        if(!empty($baseEnquiry->enquiryDetail) && !empty($baseEnquiry->enquiryDetail->title)){
            $assignmentTitle = $baseEnquiry->enquiryDetail->title;
        }

        return view('front.users.enquiries_assignment_overview')
            ->with(compact('threads','assignmentTitle','baseEnquiry'));
    }

    public function userEnquiryMessages(Request $request, $enqid){
        $baseEnquiry = ProductsEnquiry::with(['vendor','product'])->where('id',$enqid)->where('user_id',Auth::user()->id)->first();
        if(!$baseEnquiry){
            return response()->json(['status'=>false,'message'=>'Not allowed'],403);
        }
        [$customerLabel, $vendorLabel] = $this->getChatParticipantLabels($baseEnquiry);

        $enquiryIds = [$baseEnquiry->id];

        $afterId = (int)$request->get('after_id',0);
        $query = EnquiriesResponse::whereIn('enquiry_id',$enquiryIds)->orderBy('id','Asc');
        if($afterId>0){
            $query->where('id','>',$afterId);
        }

        $messages = $query->get();

        if($messages->count()>0){
            $vendorIds = $messages->where('sender_type','Vendor')->pluck('id')->toArray();
            if(!empty($vendorIds)){
                EnquiriesResponse::whereIn('id',$vendorIds)->update(['is_unread'=>0]);
            }
        }

        $messageHtml = "";
        foreach($messages as $message){
            $messageHtml .= (string)View::make('front.users.partials.enquiry_message')->with(['enquiry'=>$message,'customerLabel'=>$customerLabel,'vendorLabel'=>$vendorLabel]);
        }

        $lastMessage = EnquiriesResponse::whereIn('enquiry_id',$enquiryIds)->orderBy('id','Desc')->first();
        $lastId = $lastMessage ? (int)$lastMessage->id : $afterId;

        return response()->json([
            'status'=>true,
            'message_html'=>$messageHtml,
            'last_id'=>$lastId
        ]);
    }

    public function userEnquiryResponse(Request $request){
        Session::put('page','user_enquiries_response');
        if($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                    'enquiry_id' => 'required|integer',
                    'message' => 'nullable|string|max:2000',
                    'images.*' => 'mimes:jpeg,jpg,png|max:1024',
                ],
                [
                    'images.*.mimes' => 'Error: Image must be of type jpeg, jpg or png',
                ]
            );

            $validator->after(function($validator) use ($request){
                $messageText = trim((string)$request->input('message',''));
                $uploadedImages = $request->file('images',[]);
                $hasImage = false;

                if(is_array($uploadedImages)){
                    foreach($uploadedImages as $image){
                        if(!empty($image)){
                            $hasImage = true;
                            break;
                        }
                    }
                }elseif(!empty($uploadedImages)){
                    $hasImage = true;
                }

                if($messageText === '' && !$hasImage){
                    $validator->errors()->add('message','Skriv en melding eller velg minst ett bilde.');
                }
            });

            if($validator->passes()){
                $enquiry = ProductsEnquiry::with(['vendor','product'])->where('id',$data['enquiry_id'])
                    ->where('user_id',Auth::user()->id)
                    ->first();

                if(!$enquiry){
                    if($request->ajax()){
                        return response()->json(['status'=>false,'message'=>'Not allowed'],403);
                    }
                    return redirect()->back()->with('error_message','Not allowed');
                }

                $response = new EnquiriesResponse;
                $response->enquiry_id = $enquiry->id;
                $response->sender_id = Auth::user()->id;
                $response->sender_type = 'Customer';
                $response->message = trim((string)($data['message'] ?? ''));
                
                // Upload Multiple Images
                if($request->hasFile('images')){
                    $images = $request->file('images');
                    $imageNames = [];

                    try{
                        $targetDir = public_path('front/images/enquiries_images');
                        if(!File::exists($targetDir)){
                            File::makeDirectory($targetDir,0755,true);
                        }

                        foreach($images as $image){
                            if(empty($image)){
                                continue;
                            }

                            $extension = strtolower((string)$image->getClientOriginalExtension());
                            if($extension === ''){
                                $extension = 'jpg';
                            }

                            $imageName = 'image-'.rand(1111,999999).'.'.$extension;
                            $imagePath = $targetDir.DIRECTORY_SEPARATOR.$imageName;
                            Image::make($image)->save($imagePath);
                            $imageNames[] = $imageName;
                        }
                    }catch(\Throwable $e){
                        \Log::error('Failed to save enquiry image',[
                            'userId' => Auth::id(),
                            'enquiryId' => $enquiry->id ?? null,
                            'error' => $e->getMessage(),
                        ]);

                        if($request->ajax()){
                            return response()->json([
                                'status' => false,
                                'message' => 'Kunne ikke lagre bildet. Prøv igjen.'
                            ],500);
                        }

                        return redirect()->back()->with('error_message','Kunne ikke lagre bildet. Prøv igjen.');
                    }

                    if(!empty($imageNames)){
                        $response->images = implode(',',$imageNames);
                    }
                }

                $response->save();

                // Update updated_at date in enquiries table
                $updated_at = Carbon::now();
                ProductsEnquiry::where('id',$enquiry->id)->update(['updated_at'=>$updated_at]);

                if($request->ajax()){
                    [$customerLabel, $vendorLabel] = $this->getChatParticipantLabels($enquiry);
                    $messageHtml = (string)View::make('front.users.partials.enquiry_message')->with(['enquiry'=>$response,'customerLabel'=>$customerLabel,'vendorLabel'=>$vendorLabel]);
                    return response()->json([
                        'status'=>true,
                        'message'=>'Meldingen er sendt',
                        'message_html'=>$messageHtml,
                        'message_id'=>$response->id
                    ]);
                }

                $message = 'Meldingen er sendt';
                return redirect()->back()->with('success_message',$message);
            }else{
                $message = 'Error';
                if($request->ajax()){
                    return response()->json(['status'=>false,'message'=>$message,'errors'=>$validator->errors()],422);
                }
                return redirect()->back()->with('error_message',$message)->withErrors($validator,'response');
            }
        }
    }

    public function userUpdatePassword(Request $request){
        Session::put('page','user_update_password');
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

    public function userInvitations(Request $request){
        Session::put('page','user_invitations');

        if($request->isMethod('post')){
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'guest_name' => 'required|string|max:150',
                'guest_email' => 'nullable|email|max:150',
                'guest_phone' => 'nullable|string|max:40',
                'event_title' => 'required|string|max:200',
                'event_date' => 'nullable|date',
                'event_location' => 'nullable|string|max:200',
                'message' => 'required|string|max:3000',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $invitation = new UserInvitation();
            $invitation->user_id = Auth::user()->id;
            $invitation->guest_name = $data['guest_name'];
            $invitation->guest_email = $data['guest_email'] ?? null;
            $invitation->guest_phone = $data['guest_phone'] ?? null;
            $invitation->event_title = $data['event_title'];
            $invitation->event_date = !empty($data['event_date']) ? $data['event_date'] : null;
            $invitation->event_location = $data['event_location'] ?? null;
            $invitation->message = $data['message'];
            $invitation->status = 'saved';
            $invitation->save();

            if(!empty($invitation->guest_email)){
                $mailData = [
                    'guest_name' => $invitation->guest_name,
                    'event_title' => $invitation->event_title,
                    'event_date' => $invitation->event_date,
                    'event_location' => $invitation->event_location,
                    'message_text' => $invitation->message,
                    'sender_name' => Auth::user()->name,
                ];

                Mail::send('emails.invitation_guest', $mailData, function($message) use ($invitation){
                    $message->to($invitation->guest_email)->subject('Invitasjon: '.$invitation->event_title);
                });

                $invitation->status = 'sent';
                $invitation->sent_at = Carbon::now();
                $invitation->save();
            }

            return redirect()->back()->with('success_message','Invitasjonen er lagret og sendt.');
        }

        $invitations = UserInvitation::where('user_id',Auth::user()->id)->orderBy('id','Desc')->get();
        return view('front.users.invitations')->with(compact('invitations'));
    }

    public function deleteInvitation($id){
        $invitation = UserInvitation::where('id',$id)->where('user_id',Auth::user()->id)->first();
        if(!$invitation){
            return redirect()->back()->with('error_message','Invitasjonen finnes ikke.');
        }

        $invitation->delete();
        return redirect()->back()->with('success_message','Invitasjonen er slettet.');
    }

    public function forgotPassword(Request $request){
        Session::put('page','user_forgot_password');
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

    private function attachEnquiryConversationMeta(array $enquiries){
        foreach ($enquiries as $key => $enquiry) {
            $responseCount = EnquiriesResponse::where('enquiry_id',$enquiry['id'])->where('sender_type','Vendor')->count();
            $vendorResponseCount = EnquiriesResponse::where('enquiry_id',$enquiry['id'])
                ->where('sender_type','Vendor')
                ->select('sender_id')
                ->distinct()
                ->count('sender_id');
            $unreadVendorCount = EnquiriesResponse::where('enquiry_id',$enquiry['id'])
                ->where('sender_type','Vendor')
                ->where('is_unread',1)
                ->select('sender_id')
                ->distinct()
                ->count('sender_id');
            $senderStats = EnquiriesResponse::where('enquiry_id',$enquiry['id'])
                ->where('sender_type','Vendor')
                ->select('sender_id', DB::raw('COUNT(*) as total_count'), DB::raw('SUM(CASE WHEN is_unread = 1 THEN 1 ELSE 0 END) as unread_count'))
                ->groupBy('sender_id')
                ->get();
            $newVendorCount = 0;
            $newMessageCount = 0;
            foreach($senderStats as $senderStat){
                $senderUnread = (int)($senderStat->unread_count ?? 0);
                if($senderUnread <= 0){
                    continue;
                }
                $senderTotal = (int)($senderStat->total_count ?? 0);
                if($senderTotal === $senderUnread){
                    $newVendorCount++;
                }else{
                    $newMessageCount++;
                }
            }

            $latestResponse = EnquiriesResponse::where('enquiry_id',$enquiry['id'])
                ->orderBy('id','Desc')
                ->first();

            if(!empty($latestResponse) && !empty($latestResponse->message)){
                $enquiries[$key]['response'] = $latestResponse->message;
            }else{
                $enquiries[$key]['response'] = "";
            }

            $enquiries[$key]['last_message_at'] = !empty($latestResponse) ? $latestResponse->created_at : null;

            $totalMessagesCount = EnquiriesResponse::where('enquiry_id',$enquiry['id'])->count();
            $enquiries[$key]['hasMessages'] = $totalMessagesCount > 0;
            $unreadCount = EnquiriesResponse::where('enquiry_id',$enquiry['id'])->where('sender_type','Vendor')->where('is_unread',1)->count();
            $enquiries[$key]['unreadCount'] = $unreadCount;
            $enquiries[$key]['vendorResponseCount'] = $vendorResponseCount;
            $enquiries[$key]['unreadVendorCount'] = $unreadVendorCount;
            $enquiries[$key]['newVendorCount'] = $newVendorCount;
            $enquiries[$key]['newMessageCount'] = $newMessageCount;

            $type = "Direkte";
            if(isset($enquiry['enquiry_detail_id']) && $enquiry['enquiry_detail_id']>0){
                $title = $enquiry['enquiry_detail']['title'] ?? "";
                $assignmentDate = $enquiry['enquiry_detail']['assignment_date'] ?? "";
                if(!empty($title) || !empty($assignmentDate)){
                    $type = "Oppdrag";
                }
            }
            $enquiries[$key]['messageType'] = $type;
            $enquiries[$key]['is_grouped_assignment'] = false;
        }

        return $enquiries;
    }

    private function buildDesktopGroupedEnquiries(array $enquiries){
        $desktopRows = [];

        foreach($enquiries as $enquiry){
            $isAssignment = strtolower((string)($enquiry['messageType'] ?? 'direkte')) === 'oppdrag';
            $assignmentId = (int)($enquiry['enquiry_detail_id'] ?? 0);

            if(!$isAssignment || $assignmentId <= 0){
                $enquiry['is_grouped_assignment'] = false;
                $enquiry['threadIds'] = [(int)($enquiry['id'] ?? 0)];
                $desktopRows[] = $enquiry;
                continue;
            }

            $groupKey = 'assignment_'.$assignmentId;
            $threadDate = strtotime($enquiry['updated_at'] ?? $enquiry['created_at'] ?? '1970-01-01');

            if(!isset($desktopRows[$groupKey])){
                $desktopRows[$groupKey] = $enquiry;
                $desktopRows[$groupKey]['is_grouped_assignment'] = true;
                $desktopRows[$groupKey]['threadIds'] = [];
                $desktopRows[$groupKey]['vendorResponseCount'] = 0;
                $desktopRows[$groupKey]['unreadCount'] = 0;
                $desktopRows[$groupKey]['newVendorCount'] = 0;
                $desktopRows[$groupKey]['newMessageCount'] = 0;
                $desktopRows[$groupKey]['latestThreadTs'] = 0;
                $desktopRows[$groupKey]['groupTitle'] = $enquiry['enquiry_detail']['title'] ?? ($enquiry['product']['product_name'] ?? 'Oppdrag');
            }

            $desktopRows[$groupKey]['threadIds'][] = (int)($enquiry['id'] ?? 0);
            $desktopRows[$groupKey]['vendorResponseCount'] = (int)($desktopRows[$groupKey]['vendorResponseCount'] ?? 0) + 1;
            $desktopRows[$groupKey]['unreadCount'] = (int)($desktopRows[$groupKey]['unreadCount'] ?? 0) + (int)($enquiry['unreadCount'] ?? 0);
            $desktopRows[$groupKey]['newVendorCount'] = (int)($desktopRows[$groupKey]['newVendorCount'] ?? 0) + (int)($enquiry['newVendorCount'] ?? 0);
            $desktopRows[$groupKey]['newMessageCount'] = (int)($desktopRows[$groupKey]['newMessageCount'] ?? 0) + (int)($enquiry['newMessageCount'] ?? 0);

            $groupIsActive = (int)($desktopRows[$groupKey]['status'] ?? 0) === 1;
            if(!$groupIsActive && (int)($enquiry['status'] ?? 0) === 1){
                $desktopRows[$groupKey]['status'] = 1;
            }

            if($threadDate >= (int)$desktopRows[$groupKey]['latestThreadTs']){
                $desktopRows[$groupKey]['latestThreadTs'] = $threadDate;
                $desktopRows[$groupKey]['id'] = $enquiry['id'];
                $desktopRows[$groupKey]['updated_at'] = $enquiry['updated_at'] ?? $enquiry['created_at'];
                $desktopRows[$groupKey]['created_at'] = $enquiry['created_at'] ?? $enquiry['updated_at'];
                $desktopRows[$groupKey]['response'] = $enquiry['response'] ?? '';
                $desktopRows[$groupKey]['product'] = $enquiry['product'] ?? ($desktopRows[$groupKey]['product'] ?? []);
            }
        }

        $desktopRows = array_values($desktopRows);

        usort($desktopRows, function($a, $b){
            $statusA = (int)($a['status'] ?? 0);
            $statusB = (int)($b['status'] ?? 0);
            if($statusA !== $statusB){
                return $statusB <=> $statusA;
            }

            $dateA = strtotime($a['updated_at'] ?? $a['created_at'] ?? '1970-01-01');
            $dateB = strtotime($b['updated_at'] ?? $b['created_at'] ?? '1970-01-01');
            return $dateB <=> $dateA;
        });

        return $desktopRows;
    }

    private function resolveSelectedEnquiryId(array $desktopEnquiries, $requestedEnquiryId){
        $requestedId = (int)$requestedEnquiryId;

        if($requestedId > 0){
            foreach($desktopEnquiries as $row){
                $threadIds = array_filter($row['threadIds'] ?? []);
                if((int)($row['id'] ?? 0) === $requestedId || in_array($requestedId, $threadIds, true)){
                    return $requestedId;
                }
            }
        }

        if(empty($desktopEnquiries)){
            return 0;
        }

        $firstRow = $desktopEnquiries[0];
        $firstThreadIds = array_values(array_filter($firstRow['threadIds'] ?? []));
        if(!empty($firstThreadIds)){
            return (int)$firstThreadIds[0];
        }

        return (int)($firstRow['id'] ?? 0);
    }

    private function buildSelectedConversationPayload($selectedEnquiryId){
        $threadId = (int)$selectedEnquiryId;
        if($threadId <= 0){
            return null;
        }

        $baseEnquiry = ProductsEnquiry::with(['product','enquiryDetail','vendor'])
            ->where('id',$threadId)
            ->where('user_id',Auth::user()->id)
            ->first();

        if(!$baseEnquiry){
            return null;
        }

        $enquiryIds = [$baseEnquiry->id];

        $messages = EnquiriesResponse::whereIn('enquiry_id',$enquiryIds)
            ->with(['enquiry'])
            ->orderBy('id','Asc')
            ->limit(120)
            ->get()
            ->toArray();

        EnquiriesResponse::whereIn('enquiry_id',$enquiryIds)
            ->where('sender_type','Vendor')
            ->update(['is_unread'=>0]);

        $conversationVendorName = 'Leverandør';
        $conversationVendorUrl = '';
        if(!empty($baseEnquiry->product) && !empty($baseEnquiry->product->product_name)){
            $conversationVendorName = $baseEnquiry->product->product_name;
            $productSlug = Product::productURL($conversationVendorName);
            if(!empty($productSlug) && !empty($baseEnquiry->product->id)){
                $conversationVendorUrl = url('product/'.$productSlug.'/'.$baseEnquiry->product->id);
            }
        }

        [$customerLabel, $vendorLabel] = $this->getChatParticipantLabels($baseEnquiry);

        return [
            'thread_id' => (int)$baseEnquiry->id,
            'thread_status' => (int)($baseEnquiry->status ?? 1),
            'assignment_id' => (int)($baseEnquiry->enquiry_detail_id ?? 0),
            'messages' => $messages,
            'vendor_name' => $conversationVendorName,
            'vendor_url' => $conversationVendorUrl,
            'customer_label' => $customerLabel,
            'vendor_label' => $vendorLabel,
            'send_url' => url('user/enquiry/response'),
            'poll_url' => url('user/enquiries/'.$baseEnquiry->id.'/messages'),
            'detail_url' => url('user/enquiries/'.$baseEnquiry->id),
            'overview_url' => !empty($baseEnquiry->enquiry_detail_id) ? url('user/enquiries/'.$baseEnquiry->id.'/overview') : '',
            'is_assignment' => !empty($baseEnquiry->enquiry_detail_id),
        ];
    }

    private function getChatParticipantLabels($baseEnquiry){
        $customerLabel = trim((string)(Auth::user()->first_name ?? ''));
        if($customerLabel === ''){
            $fullName = trim((string)(Auth::user()->name ?? ''));
            if($fullName !== ''){
                $nameParts = preg_split('/\s+/', $fullName);
                $customerLabel = trim((string)($nameParts[0] ?? ''));
            }
        }
        if($customerLabel === ''){
            $customerLabel = 'Kunde';
        }

        $vendorLabel = '';
        if(!empty($baseEnquiry) && !empty($baseEnquiry->product) && !empty($baseEnquiry->product->product_name)){
            $vendorLabel = trim((string)$baseEnquiry->product->product_name);
        }
        if($vendorLabel === '' && !empty($baseEnquiry) && !empty($baseEnquiry->vendor) && !empty($baseEnquiry->vendor->name)){
            $vendorLabel = trim((string)$baseEnquiry->vendor->name);
        }
        if($vendorLabel === ''){
            $vendorLabel = 'Leverandør';
        }

        return [$customerLabel, $vendorLabel];
    }
}
