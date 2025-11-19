<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permitir siempre
    }

    public function rules()
    {
        return [
            'public_name' => ['nullable', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:users,slug,' . $this->user()->id],
            'bio'         => ['nullable', 'string'],
            'avatar'      => ['nullable', 'url'],
        ];
    }
}
