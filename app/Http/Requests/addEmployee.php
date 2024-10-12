<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addEmployee extends FormRequest
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
            'username' => 'required|alpha:ascii|lowercase|unique:App\Models\UserAuth,username',
            'nik' => 'required|numeric',
            'fullname' => 'required|regex:/^[a-zA-Z\s]+$/',
            'position' => 'required|regex:/^[a-zA-Z\s]+$/',
            'role' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'username belum diisi',
            'username.alpha' => 'username hanya boleh berisi huruf a-z',
            'username.lowercase' => 'username hanya boleh berisi huruf kecil',
            'username.unique' => 'username sudah terdaftar',
            'fullname.required' => 'nama lengkap belum diisi',
            'fullname.regex' => 'nama lengkap hanya boleh berisi huruf a-z',
            'position.required' => 'posisi belum diisi',
            'position.regex' => 'posisi hanya boleh berisi huruf a-z',
            'role.required' => 'role belum dipilih'
        ];
    }
}
