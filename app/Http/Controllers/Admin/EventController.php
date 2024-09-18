<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Session;

class EventController extends Controller
{
    public function events(){
        Session::put('page','events');
        $events = Event::query();
        $events = $events->where('is_delete',0);
        $events = $events->get()->toArray();     
        return view('admin.events.events')->with(compact('events'));
    }

    public function updateEventStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Event::where('id',$data['event_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'event_id'=>$data['event_id']]);
        }
    }
}
