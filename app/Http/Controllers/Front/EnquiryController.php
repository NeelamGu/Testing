<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Models\Vendor;
use App\Models\VendorsCategory;
use App\Models\EnquiriesVendor;
use App\Models\ProductsEnquiry;
use App\Models\EnquiriesResponse;
use App\Models\User;
use App\Models\Product;
use App\Models\City;
use Image;
use Auth;
use DB;
use Str;

class EnquiryController extends Controller
{

    public function OldsubmitEnquiry(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            DB::beginTransaction();

            $enquiry = new Enquiry;

            // Upload Photo
            if($request->hasFile('photo')){
                $image_tmp = $request->file('photo');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/photos/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                    $enquiry->photo = $imageName;
                }
            }else{
                $enquiry->photo = "";
            }



            if(Auth::check()){
                $enquiry->user_id = Auth::user()->id;    
            }            
            $enquiry->category_id = $data['category_id'];
            $enquiry->title = $data['title'];
            $enquiry->name = $data['name'];
            $enquiry->address = $data['address'];
            $enquiry->city = $data['city'];
            $enquiry->radius = $data['radius'];
            $enquiry->email = $data['email'];
            $enquiry->phone = $data['phone'];
            $enquiry->pincode = $data['pincode'];
            $enquiry->description = $data['description'];
            $enquiry->desired_price = $data['desired_price'];
            $enquiry->assignment_date = $data['assignment_date'];
            if(isset($data['picked_up'])&&!empty($data['picked_up'])){
                $enquiry->picked_up = $data['picked_up'];
            }else{
                $enquiry->picked_up = "No";
            }
            $enquiry->save();
            $enquiry_id = DB::getPdo()->lastInsertId();

            // Get Vendors Ids from city
            $vendorIds = Vendor::where('city',$data['city'])->pluck('id');
            /*echo $data['category_id']; die;
            dd($vendorIds);*/

            $selectedVendors = VendorsCategory::where('category_id',$data['category_id'])->whereIn('vendor_id',$vendorIds)->get()->toArray();

            /*dd($selectedVendors);*/
            
            foreach ($selectedVendors as $key => $vendor) {
                $enquiryv = new EnquiriesVendor;
                $enquiryv->enquiry_id = $enquiry_id;
                $enquiryv->vendor_id = $vendor['vendor_id'];
                $enquiryv->save();
            }

            DB::commit();

            /*echo "<script>alert('Thanks for your Enquiry! We will get back to you soon');</script>";*/

            $message = 'Thanks for your Enquiry! We will get back to you soon';
            return redirect('/?enquiry=1')->with('success_message',$message);
        }
    }

    public function submitEnquiry(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $pincodeCount = City::where(['postcode'=>$data['postcode'],'status'=>1])->count();
            if($pincodeCount==0){
                $message = 'Pinkoden er ugyldig. Vennligst skriv inn Norges pinkode.';
                return redirect('enquire-us?assignment_date='.$data['assignment_date'].'&address='.$data['address'].'&title='.$data['title'].'&category_id='.$data['category_id'].'&description='.$data['description'])->with('error_message',$message);
            }

            DB::beginTransaction();

            $enquiry = new Enquiry;

            // Upload Photo
            if($request->hasFile('photo')){
                $image_tmp = $request->file('photo');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/photos/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                    $enquiry->photo = $imageName;
                }
            }else{
                $enquiry->photo = "";
            }

            if(Auth::check()){
                $enquiry->user_id = Auth::user()->id;  
                $enquiry->name = Auth::user()->name;
                $nameArr = explode(" ",$enquiry->name);
                $enquiry->first_name = $nameArr[0];
                if($nameArr[1]!=""){
                    $enquiry->last_name = $nameArr[1];     
                }else{
                    $enquiry->last_name = "";
                }
                 
                $enquiry->phone = Auth::user()->mobile;  
                $enquiry->email = Auth::user()->email;  
                if(isset(Auth::user()->country)&&!empty(Auth::user()->country)){
                    $enquiry->country = Auth::user()->country;
                }
            }else{
                $enquiry->name = $data['first_name']." ".$data['last_name'];
                $enquiry->first_name = $data['first_name'];
                $enquiry->last_name = $data['last_name'];
                $enquiry->phone = $data['countrycode']."".$data['phone'];
                $enquiry->email = $data['email'];
                if(isset($data['country'])&&!empty($data['country'])){
                    $enquiry->country = $data['country'];
                }
            }      

            $enquiry->category_id = $data['category_id'];
            $enquiry->title = $data['title'];
            $enquiry->address = $data['address'];
            $enquiry->city = $data['city'];
            if(isset($data['state'])&&!empty($data['state'])){
                $enquiry->state = $data['state'];
            }

            $enquiry->pincode = $data['postcode'];
            $enquiry->description = $data['description'];
            $enquiry->desired_price = $data['desired_price'];
            $enquiry->assignment_date = $data['assignment_date'];
            if(isset($data['picked_up'])&&!empty($data['picked_up'])){
                $enquiry->picked_up = $data['picked_up'];    
            }
            if(isset($data['want_delivery'])&&!empty($data['want_delivery'])){
                $enquiry->want_delivery = $data['want_delivery'];
            }

            $enquiry->save();
            $enquiry_detail_id = DB::getPdo()->lastInsertId();

            // Check User if already exists
            $userCount = User::where('email',$enquiry->email)->count();
            if($userCount>0){
                $userId = User::select('id')->where('email',$enquiry->email)->first();
                $user_id = $userId->id;
                Auth::loginUsingId($user_id);
            }else{
                if(!Auth::check()){
                // Register the User
                    $password = Str::random(6);
                    $user = new User;
                    $user->name = $data['first_name']." ".$data['last_name'];
                    $user->first_name = $data['first_name'];
                    $user->last_name = $data['last_name'];
                    $user->mobile = $enquiry->phone;
                    $user->email = $enquiry->email;
                    /*$user->city = $data['city'];
                    if(isset($data['state'])&&!empty($data['state'])){
                        $user->state = $data['state'];
                    }
                    $user->country = $data['country'];*/
                    $user->mobile = $data['countrycode']."".$data['phone'];
                    $user->birth_date = $data['birth_date'];
                    $user->gender = $data['gender'];
                    $user->password = bcrypt($password);
                    $user->status = 1;
                    $user->save();
                    $user_id = DB::getPdo()->lastInsertId();

                    // Send Welcome Email
                    $email = $enquiry->email;
                    $messageData = ['name'=>$data['first_name']." ".$data['last_name'],'mobile'=>$enquiry->phone,'email'=>$email,'password'=>$password];
                    Mail::send('emails.register_user_from_enquiry',$messageData,function($message)use($email){
                        $message->to($email)->subject('Ny kunde og oppdrag registrert');
                    });

                    // Send Welcome Email to Admin
                    $bcc = "admin@samling.no";
                    Mail::send('emails.register_user_from_enquiry',$messageData,function($message)use($bcc){
                        $message->to($bcc)->subject('Ny kunde og oppdrag registrert');
                    });

                }else{
                    $user_id = Auth::user()->id;
                }    
                Auth::loginUsingId($user_id);
            }

            /*echo $enquiry_detail_id;
            echo $user_id;

            echo "<pre>"; print_r($data); die;*/

            // Update User Id in enquiries table
            Enquiry::where('id',$enquiry_detail_id)->update(['user_id'=>$user_id]);

            // Get Vendors from Pincode & Category
            /*$selectedVendors = Product::where('pincode',$data['postcode'])->where('category_id',$data['category_id'])->where('status',1)->get()->toArray();*/

            if(!Auth::check()){
                $user_name = $data['first_name']." ".$data['last_name'];
            }else{
                $user_name = Auth::user()->name;
            }

            // Send Enquiry Email to User
            $user_email2 = $enquiry->email;
            $messageData = [
                'email' => $enquiry->email,
                'name' => $user_name
            ];

            Mail::send('emails.customer_enquiry_detail2',$messageData,function($message)use($user_email2){
                $message->to($user_email2)->subject('Oppdrag lagt ut');
            });


            // Get Vendors from City & Category
            //$selectedVendors = Product::where('city',$data['city'])->where('category_id',$data['category_id'])->where('status',1)->where('vendor_id','>',0)->get()->toArray();
            $selectedVendors = Product::where('category_id',$data['category_id'])->where('status',1)->where('vendor_id','>',0)->get()->toArray();

            /*echo "<pre>"; print_r($data);
            echo "<pre>"; print_r($selectedVendors); die;*/
            $vendorExists = 0;
            foreach ($selectedVendors as $key => $vendor) { 
                $vendorExists = 1;
                /*dd($vendor);*/
                /*echo $vendor['vendor_id']; echo "--";
                echo $vendor['pincode'];
                echo $data['postcode'];*/

                $googleAPIResult = Enquiry::googleAPIRequest($vendor['pincode'],$data['postcode']);
                /*echo "<pre>"; print_r($googleAPIResult); die;*/
                /*echo $vendor['vendor_id']; die;*/

                if(isset($googleAPIResult['rows'][0]['elements'][0]['distance']['value'])){
                    /*echo $googleAPIResult['rows'][0]['elements'][0]['distance']['value']; die;*/
                    $distance = $googleAPIResult['rows'][0]['elements'][0]['distance']['value']/1000; 
                    $vendor_radius = $vendor['radius'];
                    if($distance<$vendor_radius){

                        $enquiryv = new EnquiriesVendor;
                        $enquiryv->enquiry_id = $enquiry_detail_id;
                        $enquiryv->vendor_id = $vendor['vendor_id'];
                        $enquiryv->product_id = $vendor['id'];
                        $enquiryv->save();

                        $enquiryp = new ProductsEnquiry;
                        $enquiryp->user_id = $user_id;
                        $enquiryp->vendor_id = $vendor['vendor_id'];
                        $enquiryp->product_id = $vendor['id'];
                        $enquiryp->enquiry_detail_id = $enquiry_detail_id;
                        $enquiryp->save();
                        $enquiry_id = DB::getPdo()->lastInsertId();

                        $response = new EnquiriesResponse;
                        $response->enquiry_id = $enquiry_id;
                        $response->sender_id = $user_id;
                        $response->sender_type = 'Customer';
                        $response->message = $data['description'];
                        $response->save(); 

                        // Send Enquiry Email to Vendors
                        $vendorDetails = Vendor::where('id',$vendor['vendor_id'])->first()->toArray();
                        $email = $vendorDetails['email'];
                        $messageData = [
                            'email' => $vendorDetails['email'],
                            'name' => $vendorDetails['name']
                        ];

                        Mail::send('emails.enquiry_to_vendors',$messageData,function($message)use($email){
                            $message->to($email)->subject('Oppdrag publisert');
                        });

                        // Send Email to Admin
                        $bcc = "admin@samling.no";
                        Mail::send('emails.enquiry_to_vendors',$messageData,function($message)use($bcc){
                            $message->to($bcc)->subject('Oppdrag publisert');
                        });

                        // Send Test Email
                        $bcc1 = "jaspreet@rtpltech.com";
                        Mail::send('emails.enquiry_to_vendors',$messageData,function($message)use($bcc1){
                            $message->to($bcc1)->subject('Oppdrag publisert');
                        });

                        if($key==0){
                            // Send Enquiry Email to Admin
                            $vendorDetails = Vendor::where('id',$vendor['vendor_id'])->first()->toArray();
                            $email = "admin@samling.no";
                            $messageData = [
                                'email' => $vendorDetails['email'],
                                'name' => $vendorDetails['name']
                            ];

                            Mail::send('emails.enquiry_to_vendors',$messageData,function($message)use($email){
                                $message->to($email)->subject('Oppdrag publisert');
                            }); 

                            // Send Email to Admin
                            $bcc = "admin@samling.no";
                            Mail::send('emails.enquiry_to_vendors',$messageData,function($message)use($bcc){
                                $message->to($bcc)->subject('Oppdrag publisert');
                            });  

                            // Send Test Email
                            $bcc1 = "jaspreet@rtpltech.com";
                            Mail::send('emails.enquiry_to_vendors',$messageData,function($message)use($bcc1){
                                $message->to($bcc1)->subject('Oppdrag publisert');
                            }); 
                        }

                    }
                }

            }


            /*$selectedVendors = VendorsCategory::where('category_id',$data['category_id'])->whereIn('vendor_id',$vendorIds)->get()->toArray();*/

            /*dd($selectedVendors);*/
            
            /*foreach ($selectedVendors as $key => $vendor) {
                $enquiryv = new EnquiriesVendor;
                $enquiryv->enquiry_id = $enquiry_detail_id;
                $enquiryv->vendor_id = $vendor['vendor_id'];
                $enquiryv->save();

                $enquiryp = new ProductsEnquiry;
                $enquiryp->user_id = $user_id;
                $enquiryp->vendor_id = $vendor['vendor_id'];
                $enquiryp->product_id = $vendor['id'];
                $enquiryp->enquiry_detail_id = $enquiry_detail_id;
                $enquiryp->save();
                $enquiry_id = DB::getPdo()->lastInsertId();

                $response = new EnquiriesResponse;
                $response->enquiry_id = $enquiry_id;
                $response->sender_id = $user_id;
                $response->sender_type = 'Customer';
                $response->message = $data['description'];
                $response->save(); 
            }*/

            DB::commit();

            /*echo "<script>alert('Thanks for your Enquiry! We will get back to you soon');</script>";*/

            if($vendorExists==1){
                if(Auth::loginUsingId($user_id)){
                    $message = 'Ditt oppdrag er registrert og sendt til alle aktuelle leverandører.';
                    return redirect('enquire-thanks?assignment_date='.$data['assignment_date'].'&address='.$data['address'])->with('success_message',$message);    
                }    
            }else{
                $message = 'Beklager. Vi har dessverre ingen leverandører som matcher dine ønsker.';
                return redirect('enquire-thanks?assignment_date='.$data['assignment_date'].'&address='.$data['address'])->with('error_message',$message); 
            }
            

            
        }
    }

    public function thanksEnquiry(){
        return view('front.enquire_thanks');
    }

    public function getCity(Request $request){
        if($request->ajax()){
            $data =$request->all();
            $getdata = DB::table('cities')->where('postcode',$data['pincode'])->first();
            if($getdata){
                $city  = $getdata->city;
                $state  = $getdata->state;
            }else{
                $city  = "";
                $state  = "";
            }
            return array('city'=>$city,'state'=>$state);
        }
    }

    public function getCityState(Request $request){
        if($request->ajax()){
            $data =$request->all();
            $getdata = DB::table('cities')->where('postcode',$data['pincode'])->first();
            if($getdata){
                $city  = $getdata->city;
                $state  = $getdata->state;
            }else{
                $city  = "";
                $state  = "";
            }
            return array('city'=>$city,'state'=>$state);
        }
    }

    public function getCountryCode(Request $request){
        if($request->ajax()){
            $data =$request->all();
            $getdata = DB::table('countrycode')->where('name',$data['country'])->first();
            if($getdata){
                $countrycode  = $getdata->phonecode;
            }else{
                $countrycode  = "";
            }
            return array('countrycode'=>$countrycode);
        }
    }

    public function updateEnquiryStatus(Request $request){
        $data = $request->all();
        $enquiryId = (int)($data['enquiry_id'] ?? 0);

        if($enquiryId <= 0){
            if($request->ajax()){
                return response()->json(['status'=>false,'message'=>'Oppdraget ble ikke funnet.'], 404);
            }
            return redirect()->back()->with('flash_message_error','Oppdraget ble ikke funnet.');
        }

        $enquiry = ProductsEnquiry::where('id',$enquiryId)
            ->where('user_id',Auth::id())
            ->first();

        if(!$enquiry){
            if($request->ajax()){
                return response()->json(['status'=>false,'message'=>'Oppdraget ble ikke funnet.'], 404);
            }
            return redirect()->back()->with('flash_message_error','Oppdraget ble ikke funnet.');
        }

        if(($data['status'] ?? '')=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }

        $enquiry->status = $status;
        $enquiry->save();

        if($request->ajax()){
            return response()->json(['status'=>$status,'enquiry_id'=>$enquiryId]);
        }

        if($status === 0){
            return redirect()->back()->with('flash_message_success','Oppdraget er avsluttet.');
        }

        return redirect()->back()->with('flash_message_success','Oppdraget er aktivt igjen.');
    }

    public function updatePinStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsEnquiry::where('id',$data['pin_id'])->update(['pin'=>$status]);
            return response()->json(['status'=>$status,'pin_id'=>$data['pin_id']]);
        }
    }

    public function deleteEnquiry(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $enquiryId = $data['enquiry_id'] ?? 0;

            $enquiry = ProductsEnquiry::where('id', $enquiryId)
                ->where('user_id', Auth::id())
                ->where('status', 0)
                ->first();

            if(!$enquiry){
                return response()->json(['status'=>false,'message'=>'Oppdraget ble ikke funnet.'], 404);
            }

            EnquiriesResponse::where('enquiry_id', $enquiry->id)->delete();
            $enquiry->delete();

            return response()->json(['status'=>true]);
        }
    }
}
