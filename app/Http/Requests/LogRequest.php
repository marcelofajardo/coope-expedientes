<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest
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
        $log = $this->route('log');

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'campo'                  => 'required',
                    'username'               => 'nullable',
                    'user_id'                => 'nullable|exists:users,id',
                    'expediente_id'          => 'required|exists:expediente,id',

                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                  'campo'                  => 'required',
                  'username'               => 'nullable',
                  'user_id'                => 'nullable|exists:users,id',
                  'expediente_id'          => 'required|exists:expediente,id',
                ];
            }
            default:
                break;
        }
    }
}
