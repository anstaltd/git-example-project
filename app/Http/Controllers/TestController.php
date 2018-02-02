<?php

namespace App\Http\Controllers;

/**
 * TestController
 * @author Aaryanna Simonelli <ashleighsimonelli@gmail.com>
 */
class TestController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('welcome');
    }
}
