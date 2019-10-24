<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function deploy(Request $request)
    {
        \Log::debug($request->input());
        $response = [];
        $response[] = shell_exec('cd ' . base_path());
        $response[] = shell_exec('git pull origin master');
        print_r($response);
    }
}
