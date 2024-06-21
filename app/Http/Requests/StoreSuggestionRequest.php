<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuggestionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|min:6',
            'descricao' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'Título é obrigatório',
            'titulo.min' => 'Título precisa ter no mínimo 6 caracteres',
            'descricao' => 'Descrição é obrigatória',
        ];
    }
}
