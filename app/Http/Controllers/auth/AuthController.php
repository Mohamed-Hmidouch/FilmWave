<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Requests\User\CreateUserValidator;
use App\Requests\Users\LoginUserValidator;

class AuthController extends BaseController
{
    public $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }   

    public function register(CreateUserValidator $createUserValidator)
    {
        if(!empty($createUserValidator->getErrors()))
        {
            return $this->backWithErrors($createUserValidator->getErrors(), 'Please check the registration form');
        }
        
        $user = $this->userService->createUser($createUserValidator->request()->all());
        if ($user instanceof \Illuminate\Contracts\Auth\Authenticatable) {
            Auth::login($user);
            return $this->successRedirect('admin.dashboard', [], 'Registration successful!');
        }
        
        return $this->errorRedirect('register', [], 'Registration failed. Please try again.');
    }


    public function login(LoginUserValidator $loginUserValidator)
    {
        if(!empty($loginUserValidator->getErrors()))
        {
            return $this->backWithErrors($loginUserValidator->getErrors(), 'Please check your login details');
        }
        
        $credentials = $loginUserValidator->request()->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            return $this->successRedirect('admin.dashboard', [], 'Login successful!');
        }
        
        return $this->errorRedirect('login', [], 'Invalid login credentials');
    }
}
