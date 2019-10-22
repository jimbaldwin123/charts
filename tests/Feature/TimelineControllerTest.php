<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\TimelineController;

class TimelineControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    public function testgetWikipediaData()
    {
        $controller = new TimelineController();
        $result = $controller->getWikipediaData();
        print_r($result);
    }

    public function testFillData()
    {
        $controller = new TimelineController();
        $result = $controller->fillData();
        print_r($result);
    }
}
