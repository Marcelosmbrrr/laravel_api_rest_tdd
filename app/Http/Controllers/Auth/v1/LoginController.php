<?php

namespace App\Http\Controllers\Auth\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if(Auth::attempt(['email' => $email, 'password' => $password])){

            // The sanctum token is created with a value that will be hashed
            $ability = "server:".Auth::user()->role->name;
            $sanctum_token = $user->createToken(Str::random(10), [$ability])->plainTextToken;

            return response()->json([
                'message' => 'Successful login.',
                'token' => $sanctum_token
            ], 200);

        }else{

            return response()->json([
                'message' => 'Invalid credentials.'
            ], 404);
        }
    }
}
