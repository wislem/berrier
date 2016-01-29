<?php

namespace Wislem\Berrier\Http\Requests;

use App\Http\Requests\Request;

class StoreUserSettingRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(\Auth::user()->can('access-admin')) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:usettings,name',
            'key' => 'required|unique:usettings,key',
            'default' => 'required'
        ];
    }
}
