<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupportRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cualquier visitante puede enviar apoyo
    }

    public function rules()
    {
        return [
            'supporter_name' => ['required', 'string', 'max:255'],
            'amount'         => ['required', 'integer', 'min:1', 'max:100'],
            'message'        => ['nullable', 'string', 'max:500'],
        ];
    }
}
