<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Section;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use Session;

class IndexController extends Controller
{

    public function comingSoon(){
        return view('front.coming_soon');
    }

    public function phpinfo(){
        echo phpinfo();
    }
    
    public function index(){
        Session::forget('product_id');
        Session::forget('event_id');
        $productIds = [];
        $allproductIds = [];
        $popularProductIds = [];
        $popularItems = [];
        $featuredItems = [];
        $newItems = [];
        $categories = [];
        $popularCategories = [];
        $countries = collect();

        try {
            if (Schema::hasTable('products_enquiries')) {
                $productIds = DB::table('products_enquiries')->select('product_id')->pluck('product_id')->toArray();
            }

            if (Schema::hasTable('products')) {
                $allproductIds = DB::table('products')
                    ->select('id')
                    ->where('status', 1)
                    ->whereNotIn('id', $productIds)
                    ->pluck('id')
                    ->toArray();

                $popularProductIds = array_merge($productIds, $allproductIds);

                /*if(count($popularProductIds)>0){
                    $ids_ordered = implode(',', $popularProductIds);
                    $popularItems = Product::where(['status'=>1])->wherein('id',$popularProductIds)->orderByRaw("FIELD(products.id, $ids_ordered)")->get()->toArray();
                }*/
                $popularItems = Product::where(['status'=>1])
                    ->where('is_delete', 0)
                    ->orderBy('count', 'Desc')
                    ->limit(6)
                    ->get()
                    ->toArray();

                $featuredItems = Product::where(['is_featured'=>'Yes','status'=>1])
                    ->where('is_delete', 0)
                    ->inRandomOrder()
                    ->limit(6)
                    ->get()
                    ->toArray();

                //$newItems = Product::where(['is_new'=>'Yes','status'=>1])->inRandomOrder()->get()->toArray();
                $back_date = date('Y-m-d', strtotime('-7 days'));
                $newItems = Product::where(['status'=>1])
                    ->where('created_at', '<', $back_date)
                    ->where('is_delete', 0)
                    ->orderBy('id', 'Desc')
                    ->limit(6)
                    ->get()
                    ->toArray();
            }

            if (Schema::hasTable('sections')) {
                $categories = Section::with('categories')->where('id', 1)->get()->toArray();
            }

            if (Schema::hasTable('categories')) {
                $popularCategories = Category::where(['status'=>1,'is_popular'=>'Yes'])->get()->toArray();
            }

            if (Schema::hasTable('countrycode')) {
                $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupBy('name')->pluck('name');
            }
        } catch (\Throwable $e) {
            // Keep fallback empty collections/arrays if DB is unavailable.
        }

        $meta_title = "Samling.no - Catering, tjenester og lokaler i Oslo og hele Norge!";
        $meta_description = "Ute etter catering, kake, underholdning eller fotograf til ditt bryllup eller event i Oslo eller Norge? Vi har leverandører som vil hjelpe deg!";
        $meta_keywords = "";
        return view('front.index')->with(compact('popularItems','featuredItems','newItems','categories','popularCategories','countries','meta_title','meta_description','meta_keywords'));
    }

    public function login(){
        return redirect('/?login=1');
    }

    public function enquiryDone(){
        return redirect('/?enquiry=1');
    }

    public function listing(){
        return view('front.venues');
    }

    public function detail(){
        return view('front.detail');
    }

    public function blog(){
        return view('front.blog');
    }
    public function blogDetail(){
        return view('front.blog-detail');
    }
    public function blogDetail_1(){
        return view('front.blog-detail_1');
    }
    public function blogDetail_2(){
        return view('front.blog-detail_2');
    }

    public function aboutus(){
        return view('front.about');
    }

    public function termsconditions(){
        return view('front.terms-conditions');
    }
    public function suppliertermsconditions(){
        return view('front.supplier-terms-conditions');
    }

    public function privacypolicy(){
        return view('front.privacy-policy');
    }

     public function cookiepolicy(){
        return view('front.cookie-policy');
    }

    public function contact(){
        $countries = collect();
        try {
            if (Schema::hasTable('countrycode')) {
                $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupBy('name')->pluck('name');
            }
        } catch (\Throwable $e) {
            $countries = collect();
        }
        return view('front.contact')->with(compact('countries'));
    }
    
    public function WishList(){
        return view('front.wishlist');
    }

    public function enquiry(){
        $categories = [];
        $cities = collect();
        $states = collect();
        $countries = collect();

        try {
            if (Schema::hasTable('sections')) {
                $categories = Section::with('categories')->where('id',1)->get()->toArray();
            }
            if (Schema::hasTable('cities')) {
                $cities = DB::table('cities')->select('city')->where('status',1)->groupBy('city')->pluck('city');
                $states = DB::table('cities')->select('state')->where('status',1)->groupBy('state')->pluck('state');
            }
            if (Schema::hasTable('countrycode')) {
                $countries = DB::table('countrycode')->select('name')->where('enable','yes')->groupBy('name')->pluck('name');
            }
        } catch (\Throwable $e) {
            // Keep fallback values if DB is unavailable.
        }
        /*dd($countries);*/
        return view('front.enquire_us')->with(compact('categories','cities','countries','states'));
    }

    public function addSubscriber(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                    'email' => 'bail|required|email|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i'
                ],
                ['email.regex'=>'This email is not a valid email address']
            );
            if($validator->passes()) {
                $check = Subscriber::where('email',$data['email'])->count();
                if($check == 0){
                    $subscriber = new Subscriber;
                    $subscriber->email = $data['email'];
                    $subscriber->status = 1;
                    $subscriber->save();
                    /*if(env('MAIL_MODE') =="live"){
                        $email = $data['email'];  
                        $messageData = [];
                        Mail::send('emails.newsletter-subscribe', $messageData, function($message) use ($email){
                            $message->to($email)->subject('Welcome to '.config('constants.project_name'));
                        });
                    }*/
                    return response()->json(['status'=>true,'message'=>'Thanks for Subscribing!']);
                }else{
                    return response()->json(['status'=>false,'message'=>'This email is already in our subscription list!','type'=>'validation','errors'=>array('email'=>'This email is already in our subscription list')]);
                }
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
            echo "<pre>"; print_r($data); die;
        }
    }
}
