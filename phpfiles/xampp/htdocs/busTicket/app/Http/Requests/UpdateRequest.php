<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            "id" => 'required',

            //if you wanna update a bus
            "name" => "min:3|unique:buses,name,{$this->bus->id}",
            "grade" => 'regex:/[1-3]/',
            "air_conditioning" => 'boolean',
            "file" => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', //if the image is inserted format checking

            //if you wanna update tickets
            "starting_date_time" => 'date_format:Y-m-d H:i:s|after:5 hours', //it should be at least 5 hours from now
            "beginning" => 'min:2',
            "destination" => 'min:2',
            "price" => 'integer|min:1000', //the price should be more than 1000 and can't be a negative number
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json(["message" => "invalid data sent", "details" => $errors->messages()], Response::HTTP_FORBIDDEN);
        throw new HttpResponseException($response);
    }
}
