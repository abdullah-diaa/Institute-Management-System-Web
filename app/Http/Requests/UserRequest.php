<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'gender' => 'nullable|in:male,female',
            'role' => 'required|in:admin,student',
            'status' => 'boolean',
            'member' => 'boolean',

        ];
    }
}
