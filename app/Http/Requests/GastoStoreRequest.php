<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GastoStoreRequest extends FormRequest
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
            'condominio_id'=>'required|exists:condominios,id',
            '*.*'=>'nullable|numeric'
        ];
    }
}
