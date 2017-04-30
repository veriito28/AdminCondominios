<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GastoExtraUpdateRequest extends FormRequest
{
    protected $errorBag = 'gastoExtraUpdate';
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
            'concepto'        => 'required|max:255',
            'cantidad'      =>'numeric',
            'fecha'      =>'date',
            'anio'      =>'numeric',
            'condominio_id' =>'required|exists:condominios,id',
        ];
    }
}
