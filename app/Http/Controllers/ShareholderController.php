<?php

namespace App\Http\Controllers;


use App\Helpers\ExtApiUtils;
use App\Post;
use App\Shareholder;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Generator;

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
        $posts = Post::where('Active', 1)->whereNull('deleted_at')->orderBy('created_at')->paginate(3);
        return view('shareholder.home', ['posts' => $posts]);
    }

    public function qrCode($text)
    {
        $qrcode = new Generator;
        $qrcode = $qrcode
            ->encoding('UTF-8')
            ->format('png')
            ->margin(1)
            ->size(224)->generate($text);
        $png = base64_encode($qrcode);
        return  response()->json($png);
    }

}
