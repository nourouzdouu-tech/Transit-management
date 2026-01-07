<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'agent') {
                return redirect()->route('agent.dashboard');
            }
            return redirect()->route('client.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
}
public function showRegister()
{
    return view('auth.register'); // Vue register.blade.php à créer
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'phone' => 'nullable|string|max:20',
        'ville' => 'nullable|string|max:100',
        'role' => 'required|in:client,agent',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'ville' => $request->ville,
        'role' => $request->role,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('login')->with('success', 'Compte créé avec succès. Veuillez vous connecter.');
}

}
