<?php

namespace App\Http\Controllers;

use App\Classes\Utility;
use App\Event;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/**
 * TODO -
 * non-contiguous dates on same line.
 * better parsing of dates
 * render to zoomable SVG
 * keywords
 * comparison via drag/drop boxes, checkboxes, typeahead
 * Class TimelineController
 * @package App\Http\Controllers
 */

class TimelineController extends Controller
{
    private $api_client;
    public function __construct()
    {
        $this->api_client = new Client();
    }
    public function show()
    {
        $events = Event::prepareData();
        $data = [
            'events'=>$events,
        ];
        return view('timeline',$data);
    }


    public function fillData()
    {
        $names = [
//            //'Isaac Newton',
//            //'John Locke',
//            'David Hume',
//            'Anton Lavoisier',
        ];
        foreach($names as $name){
            print $name . "\n";
            $data = $this->getWikipediaData($name);
            Event::updateEvent($data);
        }
    }

    public function getWikipediaData($title = 'George Washington')
    {
        $utitle = urlencode($title);
        $url = 'https://en.wikipedia.org/w/api.php?action=query&titles='. $utitle . '&prop=revisions&rvprop=content&format=json';
        print $url . "\n";
        $response = $this->api_client->request('GET', $url);
        $data = json_decode($response->getBody('true'),true);
        $d2 = Utility::array_search_key('*',$data);
        $body = $d2['*'];
        $data_line = Utility::get_data_line([$title,$body]);
        return $data_line;
    }

}
