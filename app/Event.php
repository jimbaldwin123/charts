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

    public function tileEvents($events)
    {
        $p = 0;
        $i = 1;
        $events_display = [];
        $events_display_first_group_item = array_shift($events);
        $events_display_first_group_item['index'] = $i;
        $events_display[] = $events_display_first_group_item;
        while ($p < count($events) && $p < 2){
            if(strtotime($events_display_first_group_item['send']) <= strtotime($events[$p]['sstart'])){
                $event_item = array_slice($events, $p, 1);
                $event_item['index'] = $p=i;
                $events_display[] = $event_item;
            } else {
                $p++;
            }
            print $p . "\t" . count($events) . "\n";
        dd($events_display);
        }
        dd($events_display);
    }
}
