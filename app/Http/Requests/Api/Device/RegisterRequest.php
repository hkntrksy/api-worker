<?php

namespace App\Http\Requests\Api\Device;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'uuid' => [
                'required',
                'uuid'
            ],
            'app_id' => 'required',
            'language' => 'required',
            'operating_system' => [
                'required',
                'string',
                'in:android,ios'
            ]
        ];
    }
}
