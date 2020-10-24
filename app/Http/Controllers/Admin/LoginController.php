<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin')->only('logout');
    }

    public function loginForm() 
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->get('email'))->first();

        if ($user == null)
        {
            return back()->with('error', 'Votre email est incorrect');
        } else {
            if (Hash::check($request->get('password'), $user->password)) {

                session()->put('id', $user->id);
                session()->put('name', $user->name);
                session()->put('email', $user->email);

                return redirect()->route('admin.home');
            } else {
                return back()->with('error', 'Mot de passse incorrect');
            }
        }
    }

    public function logout() 
    {
        session()->flush();

        return redirect()->route('admin.loginForm');
    }
}
