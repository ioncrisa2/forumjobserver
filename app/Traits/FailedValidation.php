<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


trait FailedValidation
{
    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
                'success'   => false,
                'message'   => 'Validasi Gagal!',
                'errors'    => $validator->errors()
            ],Response::HTTP_UNPROCESSABLE_ENTITY
        );
        throw new ValidationException($validator, $response);
    }
}
