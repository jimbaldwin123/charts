<?php

namespace Tests\Feature;

use App\Event as EventModel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testTileEvents()
    {
        $events = EventModel::prepareData();
        $results = EventModel::tileEvents($events);
        foreach($results as $result){
            print $result['name'] . ' ' . ($result['index'] ?? 'none') . "\n";
        }
    }
}
