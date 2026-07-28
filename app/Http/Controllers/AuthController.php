<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on role
            if ($user->role && $user->role->role_name === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role && $user->role->role_name === 'cashier') {
                return redirect()->route('cashier.orders');
            } elseif ($user->role && $user->role->role_name === 'chef') {
                return redirect()->route('chef.orders');
            }

            return redirect()->route('menu');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function registerForm()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'required|string|max:20',
            'role_id'  => 'required|exists:roles,id',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);

        // Auto login setelah registrasi
        Auth::login($user);

        // Redirect berdasarkan role yang dipilih
        if ($user->role && $user->role->role_name === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang ' . $user->fullname);
        } elseif ($user->role && $user->role->role_name === 'cashier') {
            return redirect()->route('cashier.orders')->with('success', 'Pendaftaran berhasil! Selamat datang ' . $user->fullname);
        } elseif ($user->role && $user->role->role_name === 'chef') {
            return redirect()->route('chef.orders')->with('success', 'Pendaftaran berhasil! Selamat datang ' . $user->fullname);
        }

        return redirect()->route('menu')->with('success', 'Pendaftaran berhasil! Selamat datang ' . $user->fullname);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
