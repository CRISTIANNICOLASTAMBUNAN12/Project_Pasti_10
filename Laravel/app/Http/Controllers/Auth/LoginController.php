<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // tambahkan ini

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password'); 
    
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.home');
        } 
        // Jika login sebagai admin gagal, coba login sebagai user biasa
        elseif (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        } 
        // Jika login sebagai user biasa juga gagal, kembalikan ke halaman login
        else {
            return redirect()->route('login')->withInput()->with('error', 'Invalid email or password.');
        }
    }
    
    
    
}
