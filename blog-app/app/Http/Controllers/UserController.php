<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function login(): View
    {
        return view('login');
    }

    public function doLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->to('/news');
        }
        dd($request);
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function register(): View
    {
        return view('sign-up');
    }

    public function doRegister(Request $request): RedirectResponse
    {
        $input = $request->all();

        $this->validate(request(), [
            'name' => 'required',
            //'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        
        $user = User::create(request(['name', 'email', 'password']));
        
        auth()->login($user);
        
        return redirect()->to('/news');
    }



    // public function checkLogin(Request $request)
    // {
    //     $data = $request->only('email','password');

    //     if (Auth::attempt($data,$request->remember)) {
    //         return view('news');
    //     }else{
    //         return view('error');//->with(array('error' => 1));
    //     }
    // }
}
