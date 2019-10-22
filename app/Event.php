<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Event extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','start','end','created_at','updated_at','deleted_at'];

    public static function updateEvent($data)
    {
        $event = Event::firstOrNew([
            'name'=>$data[0]
        ]);
        $event->start = $data[1];
        $event->end = $data[2];
        // $event->parse_result = '';
        $event->save();
    }

    public static function updateEventError($data)
    {
        $event = Event::firstOrNew([
            'name'=>$data[0]
        ]);
        $event->parse_result = substr($data[1],0,2000);
        $event->save();
    }

    public static function prepareData()
    {
        $events = Event::where('show',1)->orderBy('start')->get();
        foreach($events as $event){
            $start = explode('-',$event->start);
            $end = explode('-',$event->end);

            $parsed_event[] = [
                'name' => $event->name,
                'start' => $start,
                'end' => $end,
            ];
        }
        return $parsed_event;
    }
}
