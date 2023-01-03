<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DaftarRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'input-nama' => 'required','regex:/^[a-zA-Z \']*$/',
            'input-delegasi' => 'required', 'regex:/^(PR|PK) (IPNU|IPPNU) (.*)$/',
            'input-as' => 'required', 'in:Ketua,Sekretaris,Anggota',
            'input-selfie' => 'required', 'mimetypes:image/*'
        ];
    }
}
