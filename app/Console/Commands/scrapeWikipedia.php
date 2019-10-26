<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TimelineController;

class scrapeWikipedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timeline:wikipedia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape data from Wikipedia';

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
        $controller = new TimelineController;
        $controller->fillData();
    }
}
