<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Response;
use Laravel\Passport\Client;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CompanyRequest;


class PassportAuthController extends Controller
{
    public $registerData;

    public function register(UserRequest $request)
    {
        $this->registerData = [
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "gender" => $request->gender,
            "role_id" => 3,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];

       $request->validated(); //applying validations which have been made in request

        $user = User::create($this->registerData); //insert into database
        $register_access_token = $user->createToken("$request->name")->accessToken;
        return response()->json(['token' => $register_access_token], 200);
    }

    public function companyRegister(CompanyRequest $request)
    {
        $companyData = [
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "owner_name" => $request->owner_name,
            "created_at" =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];

        $userData = [
            "name" => $request->name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role_id" => 4,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];

        $request->validated(); //applying validations which have been made in request

        $company = Company::create($companyData); //insert into companies table
        $user = User::create($userData);//insert into users table
        $register_access_token = $user->createToken("$request->name")->accessToken;
        return response()->json(['token' => $register_access_token], Response::HTTP_OK);
    }


    public function login(Request $request)
    {
        $request_array = $request->only('name', 'password');

//        user authenticated successfully
        if (Auth::attempt($request_array)) {
            $user_login_token = auth()->user()->createToken("$request->name")->accessToken;

//            dd($user_login_token);
            return response()->json(['token' => $user_login_token, 'name' => $request->name], Response::HTTP_OK);
        } //authentication has failed
        else {

            return response()->json(['error' => 'UnAuthorised Access'], Response::HTTP_FORBIDDEN);
        }
    }

    }
