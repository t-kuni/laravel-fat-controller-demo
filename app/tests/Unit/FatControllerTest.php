<?php

namespace Tests\Unit;

use App\Http\Controllers\FatController;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class FatControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $request = Request::create('https://fenixjob.jp/', 'GET', [
        ]);

        $controller = new FatController();
        $controller->fatAction($request);


    }
}
