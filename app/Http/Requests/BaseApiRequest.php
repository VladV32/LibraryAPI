<?php

namespace App\Http\Requests;

use App\Http\Responses\BaseApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

/**
 * Class BaseRequest
 * @package App\Http\Requests
 */
abstract class BaseApiRequest extends FormRequest
{
    /**
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException((new BaseApiResponse())->error($errors));
    }
}
