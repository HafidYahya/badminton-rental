<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Login Admin
    public function showLoginAdminForm(){
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request){
        $credentials = $request->validate(
            [
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);
        $user = User::where('u_username', $credentials['username'])->first();

        if(!$user){
            return back()->withErrors([
                'username' => 'Username tidak terdaftar'
            ])->onlyInput('username');
        }
        if(!Hash::check($credentials['password'], $user->u_password)){
            return back()->withErrors([
                'password' => 'Password salah'
            ])->onlyInput('username');
        }
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/');
        
    }

    
}