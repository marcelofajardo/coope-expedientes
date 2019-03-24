<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificacionRequest extends FormRequest
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
        $notificacion = $this->route('notificacion');

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'nombre'            => 'required',
                    'descripcion'       => 'required',
                    'anexo_id'          => 'nullable',
                    'expediente_id'     => 'nullable',
                    'user_id'           => 'nullable',
                    'anexo_providencia' => 'nullable',
                    'fecha_vto'         => 'nullable',
                    'leida'             => 'nullable|in:SI,NO',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                  'nombre'            => 'required',
                  'descripcion'       => 'required',
                  'anexo_id'          => 'nullable',
                  'expediente_id'     => 'nullable',
                  'user_id'           => 'nullable',
                  'anexo_providencia' => 'nullable',
                  'fecha_vto'         => 'nullable',
                  'leida'             => 'nullable|in:SI,NO',
                ];
            }
            default:
                break;
        }
    }
}
