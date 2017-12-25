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
 * try-catch dd() for failed date parsing
 * Year-only dates
 * organize methods into proper classes
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

//            'George Bernard Shaw',
//            'Michel de Montaigne',
//            'Bertrand Russell',
//            'Marcel Duchamp',
            'John Cage',
//            'George Washington',
//            'Isaac Newton',
//            'Friedrich Nietzsche',
//            'Abraham Lincoln',
//            'James Baldwin',
//            'Albert Einstein',
//            'Søren Kierkegaard',
//            'Maimonides',

//            //'John Locke',
//            'David Hume',
//            'Anton Lavoisier',
        /**
         * Mendelssohn, Moses
         * boethius
         * cicero
         * moses maimonides
         * avicenna
         * averroes
         *
         */
        ];
        foreach($names as $name){
            // print $name . "\n";
            $data = $this->getWikipediaData($name);

            if(isset($data['error'])){
                Event::updateEventError($data);
            } else{
                Event::updateEvent($data);
            }

        }
    }

    public function getWikipediaData($title = 'George Washington')
    {
        $utitle = urlencode($title);
        $url = 'https://en.wikipedia.org/w/api.php?action=query&titles='. $utitle . '&prop=revisions&rvprop=content&format=json';
        // print $url . "\n";
        $response = $this->api_client->request('GET', $url);
        $data = json_decode($response->getBody('true'),true);
        $d2 = Utility::array_search_key('*',$data);
        $body = $d2['*'];
        $data_line = Utility::get_data_line([$title,$body]);
        return $data_line;
    }

}
