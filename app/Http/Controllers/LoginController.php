<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Models used in this Controller
 */
use App\Models\User;

/**
 * Classes used in this controller
 */
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * This is the login function
     * 
     * @param Illuminate\Http\Request
     * 
     * @return response json
     */
    public function login(Request $request)
    {
        $credentials = filter_var($request->get('username'), FILTER_VALIDATE_EMAIL) ?  ['email' => $request->get('username')] : ['username' => $request->get('username')];
        $credentials['password'] = $request->get('password');
        $user = User::where(array_key_exists('username',$credentials) ? "username" : "email",$request->get('username'))->first();

        if(!$user){
            return response()->json([
                "status" => true,
                "message" => "No account found",
            ],200);
        }

        if(Hash::check($request->get('password'),$user->password)){
            $token = $user->createToken('auth-token');
            return response()->json([
                "status" => true,
                "token" => $token->plainTextToken,
                "user" => $user,
            ],200);
        } else {
            return response()->json([
                "status" => true,
                "message" => "Wrong login credentials",
            ],200);
        }
        
    }

    /**
     * This is to check if the token is valid
     * if the spa is refreshed
     * 
     * @param Illuminate\Http\Request
     * 
     * @return response json
     */
    public function check_token(Request $request)
    {
        $user = Auth::user();
        if($user){
            return response()->json([
                "status" => true,
                "user" => $user,
            ],200);
        }
    }
}
