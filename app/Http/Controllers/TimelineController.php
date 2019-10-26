<?php

namespace App\Http\Controllers;

use App\Classes\Utility;
use App\Event as EventModel;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/**
 * TODO -
 * short names on tile if it won't fit (eg 'Locke" without dates)
 * cache tile results
 * alert/log/report scrape results
 * other data sources
 * if scrape date invalid, set show=0 (and report)
 * IP restriction for github hook
 * non-overlapping dates on same row.
 * try-catch dd() for failed date parsing
 * Year-only dates
 * organize methods into proper classes
 * render to zoomable, and scrollable
 * keywords
 * comparison via drag/drop boxes, checkboxes, typeahead
 * category tags such as politics, science, art, philosophy, religion, fictional
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
        $events = EventModel::prepareData();
        $results = EventModel::tileEvents($events);
        $data = [
            'events'=>$results,
        ];
        return view('timeline',$data);
    }


    public function fillData($names)
    {

        /**
         * Mendelssohn, Moses
         * boethius
         * cicero
         * moses maimonides
         * avicenna
         * averroes
         */

        foreach($names as $name){
            \Log::debug('NAME: ', [$name]);
            $data = $this->getWikipediaData($name);
            if(isset($data['error'])){
                EventModel::updateEventError($data);
            } else{
                EventModel::updateEvent($data);
            }

        }
    }

    public function getWikipediaData($title = 'George Washington')
    {
        \Log::debug('TITLE', [$title]);
        $utitle = urlencode($title);
        $url = 'https://en.wikipedia.org/w/api.php?action=query&titles='. $utitle . '&rvslots=*&prop=revisions&rvprop=content&format=json';
        $response = $this->api_client->request('GET', $url);
        $data = json_decode($response->getBody('true'),true);
        $body = Utility::array_search_key('*',$data);
        $data_line = Utility::get_data_line([$title,$body]);
        return $data_line;
    }

}
