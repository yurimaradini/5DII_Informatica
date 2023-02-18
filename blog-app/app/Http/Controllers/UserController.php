<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('login');
    }

    public function login(): View
    {
        if(Auth::check()) {
            return view('login');
        }else{
            return view('logout');
        } 
    }

    public function checkLogin(Request $request)
    {
        $data = $request->only('email','password');

        if (Auth::attempt($data,$request->remember)) {
            return view('news');
        }else{
            return view('error');//->with(array('error' => 1));
        }
    }
}
