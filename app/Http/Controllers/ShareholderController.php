<?php

namespace App\Http\Controllers;

use App\DepositContract;
use App\LoanContract;
use App\LoanRequest;
use App\Post;
use Illuminate\Support\Facades\Auth;

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
        $posts = Post::where('Active', 1)->orderBy('created_at')->paginate(3);
        return view('shareholder.home', ['posts' => $posts]);
    }

}
