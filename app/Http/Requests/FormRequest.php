<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use App\Helpers\ResponseEnum;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormRequest extends BaseFormRequest
{
    use ApiResponse;
    protected function failedValidation(Validator $validator)
    {

        $error = $validator->errors()->all();
         $this->throwBusinessException(ResponseEnum::CLIENT_PARAMETER_ERROR,$error[0]);
    }
}
