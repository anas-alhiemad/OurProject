<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /*
     * Unify the response
     * with 200 status code
     * first validation message
     * and extend all requests from it
     */
    protected function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            "message"    =>  $validator->errors()->first(),
            "data"    =>  null
        ], 400));
    }
}
