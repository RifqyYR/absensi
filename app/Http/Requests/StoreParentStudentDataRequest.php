<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParentStudentDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required',
            'phone_number' => 'required|unique:student_parents,phone_number',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute harus diisi',
            'unique' => ':attribute sudah terdaftar',
        ];
    }
}
