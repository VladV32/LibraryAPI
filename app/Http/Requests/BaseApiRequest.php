<?php

namespace App\Http\Requests;

use App\Http\Responses\BaseApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BaseApiRequest
 * @package App\Http\Requests
 */
abstract class BaseApiRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $statusCode = $this->getValidationStatusCode($validator);

        throw new HttpResponseException(
            (new BaseApiResponse())
                ->error(
                    (new ValidationException($validator))->errors(),
                    null,
                    null,
                    $statusCode
                )
        );
    }

    /**
     * Determine the appropriate status code for the validation failure.
     *
     * @param  Validator  $validator
     * @return int
     */
    private function getValidationStatusCode(Validator $validator): int
    {
        foreach ($validator->failed() as $field => $failures) {
            if (isset($failures['Exists'])) {
                return Response::HTTP_NOT_FOUND;
            }
        }

        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }
}