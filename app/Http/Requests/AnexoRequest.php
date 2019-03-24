<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnexoRequest extends FormRequest
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
        $rol = $this->route('rol');

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'descripcion'        => 'nullable',
                    'user_id'            => 'nullable|exists:users,id',
                    'clasificacion_id'   => 'required_if:anexo_providencia,"Anexo"',
                    'expediente_id'      => 'required|exists:expediente,id',
                    'username'           => 'nullable',
                    'url'                => 'nullable',
                    'fecha_vto'           => 'nullable',
                    'files'              => 'required_if:anexo_providencia,"Anexo"',
                    'anexo_providencia'  => 'nullable',

                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                  'descripcion'        => 'nullable',
                  'user_id'            => 'nullable|exists:users,id',
                  'clasificacion_id'   => 'required_if:anexo_providencia,"Anexo"',
                  'expediente_id'      => 'required|exists:expediente,id',
                  'username'           => 'nullable',
                  'url'                => 'nullable',
                  'fecha_vto'           => 'nullable',
                  'files'              => 'required_if:anexo_providencia,"Anexo"',
                  'anexo_providencia'  => 'nullable',
                ];
            }
            default:
                break;
        }
    }
    public function messages()
    {
        return [
             'expediente_id-required' => 'Deberá Seleccionar un Expediente',
            'clasificacion_id.required_if' => 'Al intentar cargar un Anexo deberá seleccionar la Clasificación del Anexo',
            'files.required_if' => 'Al intentar cargar un Anexo deberá seleccionar un archivo para adjuntar'
        ];
    }
}
