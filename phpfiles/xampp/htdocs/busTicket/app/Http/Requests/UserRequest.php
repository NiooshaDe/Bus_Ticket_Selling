<?php

namespace App\Http\Requests;

use App\Models\Users;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return auth()->check();
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

            return [
               'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'required|min:6',
                'phone_number' => 'required|regex:[^09[0-9]{9}]|unique:users',
            ];

    }
}
