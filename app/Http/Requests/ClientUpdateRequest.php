<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
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
            "name" => "required|string",
            "username" => "required|string|unique:users,username," . $this->id,
            "email" => "required|email|unique:users,email," . $this->id,
            "hours" => "required|integer|min:1",
            "image" => "nullable|image|mimes:png,jpg|max:2048",
            "password" => "nullable|min:8"
        ];
    }
}
