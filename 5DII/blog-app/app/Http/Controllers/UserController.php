<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function login(): View
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        //validate() throwa automaticamente un'eccezione se non va a buon fine
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //dell'oggetto user only() prende solo email e password
        $input = $request->only(['email', 'password']);

        //query per cercare se esiste un utente con quella mail
        $user = User::where([
            'email' => $input['email']
        ])->first();

        if (!is_null($user)) {

            if (Hash::check($input['password'], $user->password)) {
                //session() ottiene la sessione (laravel crea una session automaticamente, anche senza loggarsi)
                //put() aggiunge una variabile di sessione
                $request->session()->put('logged', true);
                $request->session()->put('user', $user);

                return redirect()->route('news');
            }

            $msg = "Credenziali errate.";
        }
        else {
            $msg = "Non esiste un account con la mail " . $input['email'];
        }
        
        return view('error')->with('msg', $msg);
    }


    public function register(): View
    {
        return view('sign-up');
    }

    public function doRegister(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'name' => 'required|max:50',
            'surname' => 'required|max:50',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $input = $request->only(['name', 'surname', 'email', 'password']);

        //metodo per cyptare la password
        $input['password'] = bcrypt($input['password']);

        //controllo se nel database c'è già un utente con quella mail
        $user = User::where('email', $input['email'])->get();

        // se l'utente esiste già dà errore
        if(!$user->isEmpty())
        {
            return redirect()->route('auth.register-error');
        }


        $input['remember_token'] = Str::random(40);
        
        //creo il nuovo utente e lo salvo nel database
        $createdUser = User::create($input);

        if($createdUser)
        {
            $msg = "Thank you for registering.</br>
                    We have sent you an email.";

            $emailLink = $this->sendEmail($createdUser);

            $msg .= "</br> $emailLink";

            return view('auth.register-success')->with('msg', $msg);
        }
        /*    
        $user = User::create(request(['name', 'email', 'password']));

        auth()->login($user);

        return redirect()->to('/news');
        */
    }

    public function sendEmail($user) {
        
    }
}
