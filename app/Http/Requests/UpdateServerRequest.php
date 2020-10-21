<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServerRequest extends FormRequest
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
        $serverId = $this->route('id');
        return [
            'name' => 'required|max:200|unique:servers,name,' . $serverId,
            'ip' => 'required|unique:servers,ip,' . $serverId,
        ];
    }
}
