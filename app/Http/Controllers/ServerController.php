<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function deploy()
    {
        SSH::into('production')->run(array(
            'cd ' . base_path(),
            'git pull origin master'
        ), function($line){
            echo $line.PHP_EOL; // outputs server feedback
        });
    }
}
