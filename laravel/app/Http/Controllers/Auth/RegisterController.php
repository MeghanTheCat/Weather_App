<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // called view for this controller
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // datas validation
        $request -> validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // new user creation
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'pasword' => Hash::make($request->password),
        ]);

        // user connexion
        auth()->login($user);

        // direct redirection after connection
        return redirect()->route('home');
    }
}
