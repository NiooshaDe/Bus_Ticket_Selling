<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Users;
use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Http\ResponseTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CompanyRequest;


class PassportAuthController extends Controller
{
    public $registerData;

    public function register(UserRequest $request)
    {
//        $api_token = Str::random(60);

        $this->registerData = [
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role_id" => 3,
//            "api_token" => \hash("sha256", $api_token)
        ];

//        $request->validated(); //applying validations which have been made in request

        $user = Users::create($this->registerData); //insert into database
        $access_token_example = $user->createToken("$request->name")->accessToken;
        return response()->json(['token' => $access_token_example], 200);
    }

    public function companyRegister(CompanyRequest $request)
    {
        $companyData = [
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "owner_name" => $request->owner_name
        ];

        $userData = [
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ];

        $request->validated(); //applying validations which have been made in request

        $company = Company::create($companyData); //insert into database
        $user = Users::create($userData);//insert into users table
        $access_token_example = $user->createToken("$request->name")->accessToken;
        return response()->json(['token' => $access_token_example], 200);
    }


    public function login(Request $request)
    {
        $request_array = $request->only('name', 'password');

//        user authenticated successfully
        if (Auth::attempt($request_array)) {
            $user_login_token = auth()->user()->createToken("$request->name")->accessToken;

            return response()->json(['token' => $user_login_token->token, 'name' => $request->name], 200);
        } //authentication has failed
        else {

            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

    }
