<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function deploy()
    {
        \Log::debug('DEPLOY ' . date('Y-m-d h:m:s'));
        $response = ['deployed'];
        $response[] = shell_exec('cd ' . base_path());
        $response[] = shell_exec('git pull origin master');
        $data = [];
        return view('deploy-response', $data);
    }

}
