<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{

    /**
     * Affiche la page de connexion
     * 
     * @return Illuminate\Http\Response;
     */
    public function show()
    {
        if(Auth::check()) return redirect('/');
        else return view('auth.login');
    }

    /**
     * Connecte l'utilisateur
     * 
     * @param Illuminate\Http\Request $request;
     * @return Illuminate\Http\Response;
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'string|required|exists:users,email',
            'password' => 'string|required'
        ]);

        if(Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']]))
        {

            $user = User::where('email', $validatedData['email'])->first();
            //on recréer la session, (si elle n'existait pas par défaut)
            $request->session()->regenerate();
            $request->session()->put('user_id', $user->id);

            return redirect('/');
        }
        return back()->withErrors([
            'email' => 'Les informations fournies sont fausses'
        ]);
    }


    /**
     * Déconnecte l'utilisateur
     * 
     * @param Illuminate\Http\Request $request;
     * @return Illuminate\Http\Response;
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show');
    }
}
