<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class ShareholderLoginController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
   {
        $this->middleware('guest:shareholder');
   }

    public function showLoginForm()
   {
       return view('shareholder.auth.login');
   }

    public function login(Request $request)
    {
        $formatedPhone = str_replace('+7', '', $request->phone);
        $formatedPhone = preg_replace('/[^0-9]/', '', $formatedPhone);

        $request['phone'] = $formatedPhone;

        $this->validate($request, [
            'phone' => 'required|min:10|max:10|exists:shareholders,phone',
            'password' => 'required'
        ]);

        if (Auth::guard('shareholder')->attempt(['phone'=> $formatedPhone, 'password' => $request->password]))
        {
            return redirect('/client/home');
        }
        return redirect()->back()->withInput($request->only('phone'));
    }

    public function username()
    {
        return 'phone';
    }

}
