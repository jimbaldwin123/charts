<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function deploy()
    {
        $response = ['deployed'];
        $response[] = shell_exec('cd ' . base_path());
        $response[] = shell_exec('git pull origin master');
        $response[] = $_SERVER['REMOTE_ADDR'];
        $data = ['response'=>implode('|',$response)];
        \Log::debug('DEPLOY ' . date('Y-m-d h:m:s'),$data);
        return view('deploy-response', $data);
    }

}
