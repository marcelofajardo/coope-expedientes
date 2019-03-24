<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $user = $this->route('user');

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'documento'        => 'nullable',
                    'nombre'           => 'required',
                    'email'            => 'required|email',
                    'password'         => 'required',
                    'avatar'           => 'nullable',
                    'rol_id'           => 'nullable|exists:roles,id',
                    'uep_id'           => 'nullable|exists:ueps,id',
                    'estado'           => 'nullable',
                    'last_login'       => 'nullable',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'documento'        => 'nullable',
                    'nombre'           => 'required',
                    'email'            => 'required|email',
                    'password'         => 'required',
                    'avatar'           => 'nullable',
                    'rol_id'           => 'nullable',
                    'uep_id'           => 'nullable',
                    'estado'           => 'nullable',
                    'last_login'       => 'nullable',
                ];
            }
            default:
                break;
        }
    }

     public function messages()
    {
        return [
            'nombre.required' => 'Deberá completar el nombre del Usuario',
            'email.required' => 'Deberá completar el e-mail del Usuario',
            'password.required' => 'Deberá completar la password del Usuario',
        ];
    }
}
