<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Login Customer
    public function showLoginCustomerForm(){
        return view('auth.login-customer');
    }
    public function loginCustomer(Request $request){
         $credentials = $request->validate(
            [
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ]);
        $user = Customer::where('c_username', $credentials['username'])->first();

        if(!$user){
            return back()->withErrors([
                'username' => 'Username tidak terdaftar'
            ])->onlyInput('username');
        }
        if(!Hash::check($credentials['password'], $user->c_password)){
            return back()->withErrors([
                'password' => 'Password salah'
            ])->onlyInput('username');
        }
        Auth::guard('customer')->login($user);
        $request->session()->regenerate();
        return redirect()->intended('/');
    }



    
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
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
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
        Auth::guard('web')->login($user);
        $request->session()->regenerate();
        return redirect()->intended('/admin');
        
    }

    
}