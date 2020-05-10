<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareholderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:shareholder');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('shareholder.home');
    }
}
