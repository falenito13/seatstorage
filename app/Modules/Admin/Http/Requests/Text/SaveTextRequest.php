<?php

namespace App\Modules\Admin\Http\Requests\Text;

use Illuminate\Foundation\Http\FormRequest;

class SaveTextRequest extends FormRequest
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
            'file'      => 'required',
            'key'       => 'required',
            'text'      => 'required'
        ];
    }
}
