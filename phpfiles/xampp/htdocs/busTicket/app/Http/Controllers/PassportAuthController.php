<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Laravel\Passport\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ProjectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CompanyRequest;
use App\Repositories\UserRepositories;
use App\Repositories\CompanyRepository;


class PassportAuthController extends Controller
{
    use ProjectResponse;
    public $registerData;

    public function register(UserRequest $request, UserRepositories $userRepositories)
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

        $user = $userRepositories->create($this->registerData); //insert into database
        $register_access_token = $user->createToken("$request->name")->accessToken;
        return $this->showToken($register_access_token);
    }

    public function companyRegister(CompanyRequest $request, UserRepositories $userRepositories, CompanyRepository $companyRepository)
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


        $company = $companyRepository->create($companyData); //insert into companies table
        $user = $userRepositories->create($userData);//insert into users table
        $register_access_token = $user->createToken("$request->name")->accessToken;
        return $this->showToken($register_access_token);
    }


    public function login(LoginRequest $request)
    {
        $request_array = $request->only('name', 'password');

       //user authenticated successfully
        if (Auth::attempt($request_array)) {
            $user_login_token = auth()->user()->createToken("$request->name")->accessToken;

            return $this->showToken($user_login_token);
        }

        //authentication has failed
        else {

            return $this->getErrors('UnAuthorised Access', Response::HTTP_FORBIDDEN);
        }
    }

    }
