<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use App\Http\Traits\ProjectResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReserveRequest extends FormRequest
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
            "items.*.ticket_id" => 'required|integer',
            "items.*.seat_number" => 'required|integer',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = $this->getErrors($errors->messages(), Response::HTTP_FORBIDDEN);
        throw new HttpResponseException($response);
    }
}
