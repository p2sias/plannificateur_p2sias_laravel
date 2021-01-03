<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    /**
     * Fonction d'enregistrement d'un utilisateur
     * 
     * @param Illuminate\Http\Request $request;
     * @return Illuminate\Http\Response;
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string|required',
            'email' => 'string|required|max:255|unique:users,email',
            'password' => 'string|required|max:255|min:8',
            'password-confirmation' => 'same:password|required|max:255|string'
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->save();

        return redirect()->route('login.login');
    }

    /**
     * Affiche la page du formulaire d'enregistreement
     * 
     * @return Illuminate\Http\Response;
     */
    public function show()
    {
        return view('auth.register');
    }
}
