<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ImageValidationRequest extends FormRequest
{
    public function rules(): array
    {
        switch ($this->route()->getActionMethod()) {
            case 'createImage': 
                return [
                    'image' => 'required|image|max:204800',
                ];
            case 'PatchImage':
                return [
                    'name' => 'nullable|string|max:255',
                    'image' => 'nullable|image',
                ];
                // Definir reglas de validación para los otros métodos
            default:
                return [];
            }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'The data entered is invalid',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
