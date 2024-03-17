<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'max' => ':attribute tidak boleh lebih dari 1MB'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'generation' => 'required|numeric',
            'born_date' => 'required|date',
            'parent_id' => 'required',
            'gender' => 'required',
            'image' => 'nullable|max:1024|mimes:jpg,jpeg,png,gif'
        ];
    }
}
