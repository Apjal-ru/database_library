<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek role user
            $user = Auth::user();
            $redirectRoute = '/';

            if ($user->role === 'admin') {
                $redirectRoute = '/index';
            } elseif ($user->role === 'user') {
                $redirectRoute = '/peminjaman';
            }

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'redirect' => $redirectRoute
            ]);
        }

        return response()->json([
            'message' => 'Username atau password salah'
        ], 401);
    }
}
