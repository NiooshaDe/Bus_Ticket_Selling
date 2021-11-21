<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use App\Http\Traits\ProjectResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BusRequest extends FormRequest
{
    use ProjectResponse;
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
            "name" => 'required|min:3|unique:buses',
            "sites" => 'required',
            "grade" => 'required|regex:/[1-3]/',
            "air_conditioning" => 'required|boolean',
            "file" => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', //if the image is inserted format checking
//            "company_id" => 'required',
        ];
    }

    //customizing validation error, preventing from redirecting
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = $this->getErrors($errors->messages(), Response::HTTP_FORBIDDEN);
        throw new HttpResponseException($response);
    }
}
