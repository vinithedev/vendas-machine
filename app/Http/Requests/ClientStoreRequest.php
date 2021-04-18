<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'documento' => 'required|cpf_ou_cnpj|unique:clients',
            'email' => 'required|email:rfc|unique:clients',
        ];
    }

    public function messages()
    {
        return [
            'email:rfc'  => ':attribute invalido.',
            'required'  => ':attribute e necessario.',
            'unique:clients'  => ':attribute nao e unico.',
            'unique:clients'  => ':attribute invalido.',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            "success" => "false",
            "errors" => [
                "field" => $validator->errors()
                ]
        ], 400)); 
    }
}
