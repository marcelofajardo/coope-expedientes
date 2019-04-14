<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpedienteRequest extends FormRequest
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
        $expediente = $this->route('expediente');

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'caratula'               => 'required',
                    'usuario'                => 'nullable',
                    'numero'                 => 'nullable',
                    'nombre'                 => 'required',
                    'nombre_usuario'         => 'nullable',
                    'rol_usuario'            => 'nullable',
                    'fecha'                  => 'required',
                    'slug'                   => 'nullable',
                    'archivado'              => 'nullable',
                    'user_id'                => 'nullable|exists:users,id',
                    'tipo_expediente_id'     => 'required|exists:tipoexpediente,id',

                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                  'caratula'               => 'required',
                  'usuario'                => 'nullable',
                  'nombre_usuario'         => 'nullable',
                  'rol_usuario'            => 'nullable',
                  'numero'                 => 'nullable',
                  'nombre'                 => 'required',
                  'fecha'                  => 'required',
                  'archivado'              => 'nullable',
                  'slug'                   => 'nullable|unique:expediente,slug,' . $expediente->id,
                  'user_id'                => 'nullable|exists:users,id',
                  'tipo_expediente_id'     => 'required|exists:tipoexpediente,id',
                ];
            }
            default:
                break;
        }
    }
    public function messages()
    {
        return [
            'tipo_expediente_id.required' => 'Deberá seleccionar un Tipo de Expediente',
            'fecha.required' => 'Deberá completar la Fecha del Expediente',
            'caratula.required' => 'Deberá completar la Carátula del Expediente',
            'nombre.required' => 'Deberá completar el Nombre del Expediente',

        ];
    }
}
