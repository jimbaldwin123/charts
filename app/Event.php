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
                'sstart'=> $event->start,
                'send'=> $event->end,
            ];
        }
        return $parsed_event;
    }

    /**
     * iterate through events and tile non-overlapping events into
     * the same row
     * @param $events
     * @return mixed
     */
    public static function tileEvents($events)
    {
        $i = 0;
        while(self::arrayTagsComplete($events) !== true){
            $i++;
            $test_date = '0000-00-00';
            foreach($events as $p=>$event){
                if(!array_key_exists('index',$event)){
                    if(strtotime($test_date) <= strtotime($event['sstart'])){
                        $events[$p]['index'] = $i;
                        $test_date = $event['send'];
                    }
                }
            }
        }
        return $events;
    }

    /**
     * check array to see if all elements have been
     * assigned to an index
     * @param $events
     * @return bool
     */
    public static function arrayTagsComplete($events){
        $complete = true;
        foreach($events as $event){
            if(!array_key_exists('index',$event)){
                $complete = false;
            }
        }
        return $complete;
    }
}
