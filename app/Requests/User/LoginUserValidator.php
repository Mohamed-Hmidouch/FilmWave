<?php
namespace App\Requests\Users;

use App\Requests\BaseRequestForm;

class LoginUserValidator extends BaseRequestForm
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|min:6|max:50',
            'password' => 'required|min:8|max:50',
        ];
    }

    public function authorized()
    {
        return true;
    }
}