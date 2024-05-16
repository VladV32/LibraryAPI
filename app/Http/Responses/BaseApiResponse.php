<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use OpenApi\Annotations as OA;

/**
 * Class BaseApiResponse
 * @package App\Http\Responses
 */

/**
 * @OA\Schema(
 *      schema="BaseApiResponse",
 *      type="object",
 *      @OA\Property(property="status", type="boolean", description="Bolean status value"),
 *      @OA\Property(property="data", type="string", description="String or array of data"),
 *      @OA\Property(property="errors", type="string", description="String or array of data of response errors"),
 *      @OA\Property(property="notify", type="string", description="String or array of notificaions")
 * )
 */

/**
 * @OA\Schema(
 *      schema="BaseApiBadResponse",
 *      type="object",
 *      @OA\Property(property="status", type="boolean", example=false, description="Bolean status value"),
 *      @OA\Property(property="data", type="string", description="String or array of data"),
 *      @OA\Property(property="errors", type="array", description="String or array of data of response errors",
 *           @OA\Items(
 *                example={
 *                     "attribute":"error of attribute in endpoint"
 *                }
 *           )
 *      ),
 *      @OA\Property(property="notify", type="string", description="String or array of notificaions")
 * )
 */

/**
 * @OA\Schema(
 *      schema="BaseApiModelNotFoundResponse",
 *      type="object",
 *      @OA\Property(property="status", type="boolean", example=false, description="Bolean status value"),
 *      @OA\Property(property="data", type="string", description="String or array of data"),
 *      @OA\Property(property="errors", type="array", description="String or array of data of response errors",
 *           @OA\Items(
 *                example={
 *                     "attribute":"No query results for model [*modelName*]."
 *                }
 *           )
 *      ),
 *      @OA\Property(property="notify", type="string", description="String or array of notificaions")
 * )
 */
class BaseApiResponse extends Response
{
    public const string NOTIFY_INFO_KEY = 'info_notifies';

    /** @var array|null[] */
    protected array $template = [
        'status' => null,
        'data' => null,
        'errors' => null,
        'notify' => null
    ];

    public function data($data, array|string $notify = null): BaseApiResponse
    {
        $this->template['status'] = $this->isSuccessful();
        $this->template['data'] = $data;
        $this->template['notify'] = $this->mergeNotifies($notify);

        return $this->setContent($this->template);
    }

    public function error($error, array|string $notify = null, $data = null, int $statusCode = null): BaseApiResponse
    {
        if ($statusCode) {
            $this->statusCode = $statusCode;
        } elseif ($this->isSuccessful()) {
            $this->statusCode = self::HTTP_UNPROCESSABLE_ENTITY;
        }

        if (!is_null($data)) {
            $this->template['data'] = $data;
        }

        $this->template['status'] = false;

        if ($error) {
            $this->template['errors'] = is_string($error) ? ['global' => [$error]] : $this->transformDotsToArrayErrors(
                $error
            );
        }

        $this->template['notify'] = $this->mergeNotifies($notify);

        return $this->setContent($this->template);
    }

    private function transformDotsToArrayErrors(array $dirtyErrors): array
    {
        $errors = [];
        foreach ($dirtyErrors as $key => $value) {
            /** if key can be parsed (text.text.text) */
            if ((is_string($key) && preg_match('/\./', $key))) {
                $explodedErrors = $this->explodeError($key, $value);

                /** create key with empty array */
                if (!isset($errors[array_key_first($explodedErrors)])) {
                    $errors[array_key_first($explodedErrors)] = [];
                }

                /** merge different errors with the same key */
                $errors[array_key_first($explodedErrors)] = array_merge(
                    $errors[array_key_first($explodedErrors)],
                    $explodedErrors[array_key_first($explodedErrors)]
                );
                /** if key can't be parsed (text.text.text) and value is string */
            } elseif ((is_string($key) && !preg_match('/\./', $key)) && is_array($value) && is_string(
                    $value[array_key_first($value)]
                )) {
                if (!isset($errors[$key])) {
                    $errors[$key] = [];
                }
                $errors[$key] = array_merge($errors[$key], $value);
                /** if value has 0 key and it's array and previous conditions are false */
            } elseif (isset($value[0]) && is_array($value[0])) {
                if (!isset($errors[$key])) {
                    $errors[$key] = [];
                }
                $errors[$key] = $errors[$key] + $this->transformDotsToArrayErrors($value[0]);
            } else {
                if (!isset($errors[$key])) {
                    $errors[$key] = [];
                }
                if (is_string($value)) {
                    $errors[$key] = $value;
                }
                if (is_array($value)) {
                    $errors[$key] = array_merge($errors[$key], $value);
                }
            }
        }

        return $errors;
    }

    private function explodeError(string $errorKey, $value): array
    {
        $explodedError = [];
        $keys = explode('.', $errorKey);

        foreach ($keys as $key) {
            /**
             * if link to previous exists add next key into array
             * else create first key with empty array and add new link to this key
             */
            if (isset($linkToLastKey)) {
                $linkToLastKey[$key] = [];
                $linkToLastKey = &$linkToLastKey[$key];
            } else {
                $explodedError[$key] = [];
                $linkToLastKey = &$explodedError[$key];
            }
        }
        $linkToLastKey = $value;

        return $explodedError;
    }

    private function mergeNotifies($notify = null)
    {
        $response = null;
        $notifies = Session::get(BaseApiResponse::NOTIFY_INFO_KEY);
        Session::forget(BaseApiResponse::NOTIFY_INFO_KEY);

        if (is_array($notifies)) {
            $response = ['info' => $notifies];
        }

        if ($notify) {
            if (is_array($response)) {
                $response[] = $notify;
            } else {
                $response = $notify;
            }
        }

        return $response;
    }
}
