<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    
    public function login(Request $request) {
        
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            if(Auth::user()->status=='1') {
                if(Auth::user()->role_id == config('rcc.admin_type',1)) {
                    return response()->json([
                        'result' => true,
                        'message' => 'You have successfully logged in !',
                    ]);
                }
                else {
                    return response()->json([
                        'result' => false,
                        'message' => 'You have no permission to access here !',
                    ]);
                }
            }
            else {
                return response()->json([
                    'result' => false,
                    'message' => 'Your account has been deactivated !',
                ]);
            }
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'Username or password you have entered is incorrect !',
            ]);
        }

    }

    public function logout(Request $request) {
        
        Auth::logout();
        Session::flush();
        return redirect('/');

    }

}
