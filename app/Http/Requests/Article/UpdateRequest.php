<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'Required',
            'description' => 'Required'
        ];
    }

      public function messages()
    {
        return [
            'title.required' => 'Nama Tidak Boleh Kosong.',
            'description.required' => 'Nomor Handphone Tidak Boleh Kosong.'
        ];
    }
}
