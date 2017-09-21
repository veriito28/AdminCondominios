<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdeudoOtroStoreRequest extends FormRequest
{
    protected $errorBag = 'otroAdeudoStore';
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
            'concepto'      => 'required|max:255',
            'cantidad'      =>'numeric',
            'concepto_id'       =>'required|exists:concepto_adeudos,id',
            'casa_id'       =>'nullable|exists:casas,id',
        ];
    }
}
