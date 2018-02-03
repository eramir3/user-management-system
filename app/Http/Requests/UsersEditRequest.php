<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersEditRequest extends FormRequest
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
            
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'required',
            'is_active' => 'required',
        ];
    }

    public function messages() {

        return [
            
            'name.required' => 'El campo nombre es requerido',
            'email.required' => 'El campo email es requerido',
            'role_id.required' => 'El campo rol es requerido',
            'is_active.required' => 'El campo estado es requerido',
            'phone.required' => 'El campo telefono es requerido'
        ];
    }
}
