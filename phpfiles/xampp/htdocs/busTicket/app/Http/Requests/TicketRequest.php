<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class TicketRequest extends FormRequest
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
            "number" => 'required',
            "starting_date_time" => 'required|date_format:Y-m-d H:i:s|after:5 hours', //it should be at least 5 hours from now
            "beginning" => 'required|min:2',
            "destination" => 'required|min:2',
            "price" => 'required|integer|min:1000', //the price should be more than 1000 and can't be a negative number
            "bus_id" => 'required',
        ];
    }

    //customizing validation error, preventing from redirecting
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json(["message" => "invalid data sent", "details" => $errors->messages()], Response::HTTP_FORBIDDEN);
        throw new HttpResponseException($response);
    }
}
