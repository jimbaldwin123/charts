<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TimelineController;

class scrapeFacebook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:friends';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape data from friends.json, write to csv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = '/home/ninge/Documents/Facebook_data/friends/';
        $json = file_get_contents($path.'friends.json');
        $recs = json_decode($json,true)['friends'];
        $fh = fopen($path .'friends.csv','w');
        foreach($recs as $rec){
            fwrite($fh, '"' . $rec['name'] . '"' . ',' . date('Y-m-d',$rec['timestamp']). "\n");
        }
        fclose($fh);
        print count($recs);
    }
}
