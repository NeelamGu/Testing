<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductsEnquiry;
use App\Models\EnquiriesResponse;
use App\Models\EnquiriesVendor;
use App\Models\Enquiry;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Validator;
use Session;
use Image;
use Auth;
use Carbon\Carbon;

class EnquiryController extends Controller
{

    public function enquiries(){
        Session::put('page','enquiries');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        $enquiries = Enquiry::with('vendors');
        if($adminType=="vendor"){
            $enquiries = $enquiries->join('enquiries_vendors','enquiries_vendors.enquiry_id','=','enquiries.id')->where('enquiries_vendors.vendor_id',$vendor_id)->join('products_enquiries','products_enquiries.enquiry_detail_id','=','enquiries.id')->where('enquiries_vendors.vendor_id',$vendor_id);
        }
        $enquiries = $enquiries->get()->toArray();
        /*dd($enquiries);*/      
        return view('admin.enquiries.enquiries')->with(compact('enquiries'));
    }

    public function productsEnquiries(){
        Session::put('page','products_enquiries');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        $enquiries = ProductsEnquiry::orderby('updated_at','Desc');
        $enquiriesCatAll = ProductsEnquiry::query();
        if($adminType=="vendor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/dashboard")->with('error_message','Din leverandør-konto er foreløpig inaktiv.');
            }
            $enquiries = $enquiries->where('vendor_id',$vendor_id);
            $enquiriesCatAll = $enquiriesCatAll->where('vendor_id',$vendor_id);
        }

        $enquiriesCatAll = $enquiriesCatAll->get()->toArray();
        $userIds = array();
        foreach ($enquiriesCatAll as $key => $enquiryAll) {
            $userIds[] = $enquiryAll['user_id'];
        }
        $userIds = array_unique($userIds);
        
        if(isset($_GET['cat'])&&$_GET['cat']!=""){
            $catIds = Category::select('id')->where('category_name',$_GET['cat'])->get()->pluck('id');
            /*dd($catIds);*/
            $productIds = Product::select('id')->whereIn('category_id',$catIds)->get()->pluck('id');
            /*dd($productIds);*/
        }
        if(isset($_GET['status'])&&$_GET['status']!=""){
            $enquiries = $enquiries->where('status',$_GET['status']);
                
        }
        if(isset($_GET['pin'])&&$_GET['pin']!=""){
            $enquiries = $enquiries->where('pin',$_GET['pin']);
                
        }
        if(isset($_GET['cat'])&&$_GET['cat']!=""){
            $enquiries = $enquiries->with(['product'=>function($query)use($productIds){
                $query->whereIn('id',$productIds);
            },'user','vendor']);
        }else{
            $enquiries = $enquiries->with(['product','user','vendor']);   
        }
        $enquiries = $enquiries->get()->toArray();  
        //dd($enquiries);
        foreach ($enquiries as $key => $enquiry) {
            $responseCount = EnquiriesResponse::where(['enquiry_id'=>$enquiry['id'],'sender_type'=>'Customer'])->count();
            if($responseCount>0){
                $enquiryResponse = EnquiriesResponse::where('enquiry_id',$enquiry['id'])->orderBy('id','Asc')->get();
                foreach ($enquiryResponse as $rkey => $response) {
                    if($rkey==0){
                        $enquiries[$key]['response'] = $response['message']; 
                    }
                }
                /*$enquiries[$key]['response'] = $enquiryResponse->response; */   
            }else{
                $enquiries[$key]['response'] = "";
            }
            $unreadCount = EnquiriesResponse::where(['enquiry_id'=>$enquiry['id'],'sender_type'=>'Customer'])->where('is_unread',1)->count();
            $enquiries[$key]['unreadCount'] = $unreadCount;
        }
        
        $catenquiries = ProductsEnquiry::with('product')->whereIn('user_id',$userIds)->orderBy('id','Desc')->get()->toArray();
        $allcategories = array();
        foreach($catenquiries as $key => $enq){
            if(isset($enq['product']['category']['category_name'])){
                $allcategories[] = $enq['product']['category']['category_name'];    
            }
        }
        $allcategories = array_unique($allcategories);
        //dd($enquiries);
        return view('admin.enquiries.products_enquiries')->with(compact('enquiries','vendor_id','allcategories'));
    }

    public function productsEnquiriesDetail($enqid){
        Session::put('page','products_enquiries_detail');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        $enquiries = EnquiriesResponse::query();
        if($adminType=="vendor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/dashboard")->with('error_message','Din leverandør-konto er foreløpig inaktiv.');
            }
            $enquiries = $enquiries->with(['enquiry'])->where('enquiry_id',$enqid);
        }
        $enquiries = $enquiries->get()->toArray();
        $enquiry_id = $enqid;
        /*dd($enquiries);*/
        // Update is_unread to 0
        EnquiriesResponse::where(['enquiry_id'=>$enqid,'sender_type'=>'Customer'])->update(['is_unread'=>0]);
        return view('admin.enquiries.enquiries_responses')->with(compact('enquiries','enquiry_id'));
    }

    public function enquiriesResponses(){
        Session::put('page','enquiries_responses');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        $responses = EnquiriesResponse::query();
        if($adminType=="vendor"){
            $responses = $responses->where('vendor_id',$vendor_id);
        }
        $responses = $responses->with(['product','user','vendor','enquiry'])->get()->toArray();
        /*dd($responses);*/
        return view('admin.enquiries.enquiries_responses')->with(compact('responses'));
    }

    public function replyEnquiry(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            /*$validator = Validator::make($request->all(), [
                    'message' => 'required|string|max:2000',
                    'images.*' => 'mimes:jpeg,jpg,png|max:1024',
                ]
            );*/


            if(isset($data['images'])){

                $countImages = count($data['images']);

                $rules = [
                    'message' => 'required|string|max:2000',
                    'images.*' => 'mimes:jpeg,jpg,png|max:1024',
                ];

                if($countImages==1){
                    $customMessages = [
                        'images.*.mimes' => 'Image must be of type jpeg, jpg or png',
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
                    'message' => 'required|string|max:2000',
                ]
            );

            if($validator->passes()){

                /*echo "<pre>"; print_r($data); die;*/

                // Update updated_at date in enquiries table
                $updated_at = Carbon::now();
                ProductsEnquiry::where('id',$data['enquiry_id'])->update(['updated_at'=>$updated_at]);

                $enquiryStatus = ProductsEnquiry::enquiryStatus($data['enquiry_id']);
                if($enquiryStatus==0){
                    $message = 'Forespørsel er avsluttet av Kunden';
                    return redirect()->back()->with('close_error_message',$message);
                }

                $getUserId = ProductsEnquiry::select('user_id','product_id')->where('id',$data['enquiry_id'])->first();
                $getUserDetails = User::where('id',$getUserId->user_id)->first()->toArray();
                $getProductDetails = Product::select('product_name')->where('id',$getUserId->product_id)->first()->toArray();
                //dd($getProductDetails);

                
                $user_email2 = $getUserDetails['email'];
                $messageData = [
                    'email' => $getUserDetails['email'],
                    'name' => $getUserDetails['name'],
                    'product_name' => $getProductDetails['product_name']
                ];

                // Send Enquiry Email to User
                Mail::send('emails.vendor_response_to_customer',$messageData,function($message)use($user_email2){
                    $message->to($user_email2)->subject('Melding fra leverandør');
                });

                // Send Enquiry Email to Admin
                $bcc = array("admin@samling.no");
                Mail::send('emails.vendor_response_to_customer',$messageData,function($message)use($bcc){
                    $message->to($bcc)->subject('Melding fra leverandør');
                });

                $enquiry = new EnquiriesResponse;
                $enquiry->sender_id = $data['sender_id'];
                $enquiry->enquiry_id = $data['enquiry_id'];
                $enquiry->sender_type = 'Vendor';
                $enquiry->message = $data['message'];

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
                    $enquiry->images = $imageNames;
                }

                
                $enquiry->message = $data['message'];
                $enquiry->save();
                $message = 'Ditt svar ble sendt til kunden!';
                return redirect()->back()->with('success_message',$message);

            }else{
                return redirect()->back()->with('errors',$validator->errors());
            }
        }
    }

    public function updateEnquiryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsEnquiry::where('id',$data['enquiry_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'enquiry_id'=>$data['enquiry_id']]);
        }
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
            ProductsEnquiry::where('id',$data['enquiry_id'])->update(['pin'=>$status]);
            return response()->json(['status'=>$status,'enquiry_id'=>$data['enquiry_id']]);
        }
    }
}
