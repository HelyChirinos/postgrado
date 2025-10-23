<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'nombre' => [
                'required',
                'string',
                'max:101',
            ],
            'apellido' => [
                'required',
                'string',
                'max:101',
            ],
            'cedula' => [
                'required',
                'string',
                'max:101',
                Rule::unique('users', 'cedula')->ignore($this->user),
            ],
            'email' => [
                'required',
                'string',
                'max:191',
                'email',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'fecha_nac' => [
                'nullable',
                'date',
                'max:101',
            ], 
            'telefono' => [
                'nullable',
                'string',
                'max:101',
            ], 
            'is_propietario' => [
                'required',
                'string',
                'min:1',
                'max:1',
            ],

        ];
    }
}
