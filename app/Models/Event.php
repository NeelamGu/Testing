<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public static function getEventURL($title){
        $title = strtolower($title);
        $title = str_replace(' ','-',$title);
        return $title;
    }

    public static function interestedUsers($event_id){
        $interested = array();
        $interested['interestedUsers'] = EventsUser::where('event_id',$event_id)->where('is_interested','Yes')->count();
        $interested['notInterestedUsers'] = EventsUser::where('event_id',$event_id)->where('is_interested','No')->count();
        $interested['notSureUsers'] = EventsUser::where('event_id',$event_id)->where('is_interested','Not Sure')->count();
        return $interested;
    }
}
