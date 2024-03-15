<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string|min:1|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:8|max:15'
        ];
    }

    public function getData(){
        $data = $this->validated();
        $data['password'] = Hash::make($data['password']);
        return $data;
    }
}