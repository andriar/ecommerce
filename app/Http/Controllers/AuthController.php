<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Laravel\Passport\Passport;


class AuthController extends Controller
{
    public function login(Request $request){
         $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

       
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            Passport::tokensExpireIn(Carbon::now()->addDays(30));
            Passport::refreshTokensExpireIn(Carbon::now()->addDays(60));

            $user = Auth::user();


            $objToken = $user->createToken('API Access');
            $strToken = $objToken->accessToken;

            $expiration = $objToken->token->expires_at->diffInSeconds(Carbon::now());

            $this->content['token_type'] = 'Bearer';
            $this->content['expires_in'] =  gmdate("H:i:s", $expiration);
            $this->content['token'] = $strToken;
            $this->content['user'] = $user;
            $status = 200;
        }
        else{
            $this->content['error'] = "Could not authenticate with these credentials";
            $status = 401;
        }
        return response()->json($this->content, $status);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
        
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } catch (\Throwable $th) {
            
            return response()->json([
            'message' => 'Failed to Logout'
            ],500);
        }
    }
}
