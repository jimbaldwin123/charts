<?php

namespace Tests\Feature;

use App\Http\Controllers\TimelineController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuzzleTest extends TestCase
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

    public function testFillData()
    {
        $timeline_controller = new TimelineController();
        $timeline_controller->fillData();
        $this->assertTrue(true);
    }
}
