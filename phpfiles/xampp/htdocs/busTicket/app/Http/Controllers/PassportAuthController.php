<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\UserRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PassportAuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $data = [
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ];

        $request->validated(); //applying validations which have been made in request

        $user = Users::create($data); //insert into database

        $access_token_example = $user->createToken('PassportExample@Section.io')->accessToken;
        return response()->json(['token' => $access_token_example], 200);
    }

    public function companyRegister(CompanyRequest $request)
    {
        $data = [
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "owner_name" => $request->owner_name
        ];

        $request->validated(); //applying validations which have been made in request

        $user = Users::create($data); //insert into database

        $access_token_example = $user->createToken('PassportExample@Section.io')->accessToken;
        return response()->json(['token' => $access_token_example], 200);
    }


    public function login(Request $request)
    {
        $request_array = $request->only('name', 'password');

        //user authenticated successfully
        if (Auth::attempt($request_array)) {
            $user_login_token = auth()->user()->createToken('PassportExample@Section.io')->accessToken;

            return response()->json(['token' => $user_login_token], 200);
        } //authentication has failed
        else {

            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

        public function companyLogin(Request $request)
        {
            $request_array = $request->only('name','phone_number', 'password');

            //user authenticated successfully
            if (Auth::attempt($request_array)) {
                $user_login_token = auth()->user()->createToken('PassportExample@Section.io')->accessToken;

                return response()->json(['token' => $user_login_token], 200);
            } //authentication has failed
            else {

                return response()->json(['error' => 'UnAuthorised Access'], 401);
            }

        }

        //returns details of user
//    public function authenticatedUserDetails(){
//
//        return response()->json(['authenticated-user' => auth()->user()], 200);
//    }


    }
