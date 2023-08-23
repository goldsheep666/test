<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('account', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->status === '待審核') {
                return redirect()->back()->with('message', '此帳號待審核開通');
            }
            
            return redirect('/');
        }

        return redirect()->back()->with('message', '登入失敗');
    }
}
