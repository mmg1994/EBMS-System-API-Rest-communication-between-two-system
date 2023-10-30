<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // view
    public function index()
    {
        return view('register');
    }
    // get data from form
    public function storeRegister(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:registers',
            'password'   => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        
        $first_name = $request->first_name;
        $last_name  = $request->last_name;
        $email      = $request->email;
        $password   = $request->password;

        User::create([
            'first_name'=> $first_name,
            'last_name' => $last_name,
            'email'     => $email,
            'password'  => Hash::make($password),
        ]);

        return redirect('home/page');

    }
    // view
    public function viewLogin()
    {
        return view('login');
    }

    // login
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string',
        ]);

        $email    = $request->email;
        $password = $request->password;
        
        if(Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return redirect()->intended('home/page');
        }
        return redirect('form/login/view/new')->with('error','Wrong Password or Username');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('form/login/view/new');
    }
}
