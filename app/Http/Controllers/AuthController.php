<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister(){
        return view('auth.register');
    }
    public function register(Request $request){

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'role'=>'required',
            'provider_badge' => 'required_if:role,provider|in:registered,unregistered'
        ]);

        // Determine provider badge
        $providerBadge = null;
        if($request->role === 'provider'){
            $providerBadge = $request->provider_badge;
        }

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
            'provider_badge'=>$providerBadge
        ]);

        return redirect()->route('login')->with('success','Registration successful. Please login.');
    }
    public function showLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        if(Auth::attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ])){
            if(Auth::user()->role == 'customer'){
                return redirect()->route('customer.dashboard');
            }
                return redirect()->route('provider.dashboard');
        }

        return back()->with('error','Invalid credentials');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
