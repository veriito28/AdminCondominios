<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CasaStoreRequest extends FormRequest
{
    protected $errorBag = 'casaStore';
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
            'nombre'        => 'required|max:255',
            'contacto'      =>'max:255',
            'email'         => 'nullable|email',
            'telefono'         => 'nullable|numeric',
            'celular'         => 'nullable|numeric',
            'condominio_id' =>'required|exists:condominios,id',
        ];
    }
}
