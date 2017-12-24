<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class TimelineController extends Controller
{
    public function show()
    {
        return view('timeline');
    }

    public function getWikipediaData()
    {

    }
}
