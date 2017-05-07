<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CuentaUpdateRequest extends FormRequest
{
    protected $errorBag = 'cuentaUpdate';

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
            'mensaje'      => 'required|max:255',
            'imagen'       => 'nullable|image|max:2048',
            'usuario_id'   => 'required|exists:usuarios,id',
        ];
    }
}
