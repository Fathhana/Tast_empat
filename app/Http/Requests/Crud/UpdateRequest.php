<?php

namespace App\Http\Requests\Crud;

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
            'nama' => 'Required',
            'phone' => 'Required'
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama Tidak Boleh Kosong.',
            'phone.required' => 'Nomor Handphone Tidak Boleh Kosong.'
        ];
    }
}
