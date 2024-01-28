<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class LoginRegisterController extends Controller
{
    /**
    *Register api 
    
    
    */

        public function register(Request $request){

            //data validation

            $request->validate([
                "name" => "required|min:3",
                "email" => "required|email|unique:users",
                "password" => "required|min:8|confirmed"
            ]);

            //data creation

            User::create([

                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password)

            ]);

            //Generated Token Expire time 
            Passport::personalAccessTokensExpireIn(now()->addMinutes(15));
            
            //token generation
            $token = $user->createToken("myToken")->accessToken;
            
            // Response
            return response()->json([
                "status" => true,
                "message" => "user created successfully",
                "token" => $token

            ]);


        }

    

    /**
     * login api
     */

     public function login (Request $request){

        //validation
        
        $request -> validate([
            "email" => "required",
            "password" => "required"
        ]);

        //checking user login
        if(Auth::attempt([
            "password" => $request->password,
            "email" => $request->email
        ])){

                //User exists
                $user = Auth::user();

// setting expiry time to the generated token
                Passport::personalAccessTokensExpireIn(now()->addMinutes(15));

                $token = $user->createToken("myToken")->accessToken;

                return response()->json([
                    "status" => true,
                    "message" => "user login successfully",
                    "token" => $token
                ]);


        }else{
                return response()->json([
                    "status" => false,
                    "message" => "invalid login credetials"
                ]);
        }


       
    }


    // index api


    public function index (){

            $user = Auth::user();
            
            return response()->json([
                "status" => true,
                "message" => "Welcome to the landing page",
                "data" => $user
            ]);
       
    }

    
 


     // log out user from application

     public function logout (){

            auth()->user()->token()->revoke();

            return response()->json([
                "status" => true,
                "message" => "user logout"
            ]);

     }
    

}
