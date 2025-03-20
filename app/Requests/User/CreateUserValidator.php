<?php
namespace App\Requests\User;

use App\Requests\BaseRequestForm;

class CreateUserValidator extends BaseRequestForm
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'plan' => 'required|string|in:free,premium',
        ];
    }

    public function authorize()
    {
        return true;
    }
}