<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventsUser;
use Session;
use Image;
use Auth;

class EventController extends Controller
{
    public function addEvent(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $rules = [
                'title' => 'required',
                'description' => 'required',
                'filename' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                /*'interested' => 'required',*/
            ];

            $this->validate($request,$rules);

            $event = new Event;
            $event->user_id = Auth::user()->id;
            $event->title = $data['title'];
            $event->description = $data['description'];
            $event->start_date = $data['start_date'];
            $event->end_date = $data['end_date'];
            /*$event->interested = $data['interested'];*/

            // Upload Image
            if($request->hasFile('filename')){
                $image_tmp = $request->file('filename');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'front/images/events/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                    $event->image = $imageName;
                }
            }else{
                $event->image = "";
            }
            $event->status = 0;
            $event->is_delete = 0;
            $event->save();

            $message = "Event added successfully and will approve by admin soon!";
            return redirect()->back()->with('success_message',$message);
        }
        $events = Event::query();
        $events = $events->where('user_id',Auth::user()->id)->where('is_delete',0);
        $events = $events->get()->toArray();
        return view('front.events.add_event')->with(compact('events'));
    }

    public function deleteEvent($id){
        // Delete Event
        Event::where('id',$id)->update(['is_delete'=>1]);
        $message = "Event has been deleted successfully!";
        return redirect()->back()->with('success_message',$message);
    }

    public function viewEvent($title,$id){
        Session::put('event_id',$id);
        $eventCount = Event::where('id',$id)->where('status',1)->count();
        if($eventCount>0){
            $eventDetails = Event::where('id',$id)->where('status',1)->first()->toArray();    
        }else{
            abort(404);
        }
        
        return view('front.events.view_event')->with(compact('eventDetails'));
    }

    public function attendEvent(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $eventCount = EventsUser::where(['event_id'=>$data['event_id'],'user_id'=>Auth::user()->id])->count();
            if($eventCount>0){
                $message = "Your feedback is already submitted earlier!";
                return redirect()->back()->with('error_message',$message);    
            }
            $event = new EventsUser;
            $event->event_id = $data['event_id'];
            $event->user_id = Auth::user()->id;
            $event->is_interested = $data['is_interested'];
            $event->save();
            $message = "Thanks for your feedback!";
            return redirect()->back()->with('success_message',$message);    
        }
    }
}
