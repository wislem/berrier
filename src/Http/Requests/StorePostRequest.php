<?php

namespace Wislem\Berrier\Http\Requests;

use App\Http\Requests\Request;

class StorePostRequest extends Request
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
            config('app.locale') . '.slug' => 'required|unique:post_translations,slug',
            config('app.locale') . '.title' => 'required',
            'categories' => 'required'
        ];
    }
}
