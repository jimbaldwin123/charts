<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Event extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','start','end'];

    public static function updateEvent($data)
    {
        $event = Event::firstOrNew([
            'name'=>$data[0]
        ]);
        $event->start = $data[1];
        $event->end = $data[2];
        $event->save();
    }

    public static function prepareData()
    {
        $events = Event::orderBy('start')->get();
        foreach($events as $event){
            $start = self::parseDate($event->start);
            $end = self::parseDate($event->end);
            $parsed_event[] = [
                'name' => $event->name,
                'start' => $start,
                'end' => $end,
            ];
        }
        return $parsed_event;
    }

    public static function parseDate($date)
    {
        return explode('-',$date);
    }
}
