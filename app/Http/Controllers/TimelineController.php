<?php

namespace App\Http\Controllers;

use App\Classes\Utility;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class TimelineController extends Controller
{
    private $api_client;
    public function __construct()
    {
        $this->api_client = new Client();
    }
    public function show()
    {
        return view('timeline');
    }

    public function getWikipediaData($title = 'George Washington')
    {
        $title = urlencode($title);
        $url = 'https://en.wikipedia.org/w/api.php?action=query&titles='. $title . '&prop=revisions&rvprop=content&format=json';
        $response = $this->api_client->request('GET', $url);
        $data = json_decode($response->getBody('true'),true);

        $d2 = Utility::array_search_key('*',$data);
        $body = $d2['*'];
        $data_line = Utility::get_data_line($body);

        dd($data_line);
    }

}
