<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permitir siempre (podrías agregar lógica luego)
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'url'   => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation()
    {
        // Agregar https:// si no tiene protocolo
        if ($this->url && !preg_match('/^https?:\/\//i', $this->url)) {
            $this->merge([
                'url' => 'https://' . $this->url
            ]);
        }
    }
}
