<?php

namespace App\Http\Controllers;

use App\Classes\Utility;
use App\Event as EventModel;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/**
 * TODO -
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


    public function fillData()
    {
        $names = [
            'Avicenna',
//            'Ludwig Wittgenstein',
//            'Charlie Parker',
//            'Dizzy Gillespie',
//
//            'George Bernard Shaw',
//            'Michel de Montaigne',
//            'Bertrand Russell',
//            'Marcel Duchamp',
//            'John Cage',
//            'James Brown',
//            'Isaac Newton',
//            'Friedrich Nietzsche',
//            'Abraham Lincoln',
//            'James Baldwin',
//            'Albert Einstein',
//            'Søren Kierkegaard',
//            'Maimonides',
//
//            'John Locke',
//            'David Hume',
//            'Anton Lavoisier',
        /**
         * Mendelssohn, Moses
         * boethius
         * cicero
         * moses maimonides
         * avicenna
         * averroes
         * magellan
         * columbus
         *
         */
        ];
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
