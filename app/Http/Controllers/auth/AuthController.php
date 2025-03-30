<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Requests\User\CreateUserValidator;
use App\Requests\User\LoginUserValidator;
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
            return $this->successRedirect('home', [], 'Registration successful!');
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
            $user = Auth::user();
            $roles = $user->roles()->get();
            $role = $roles->isNotEmpty() ? $roles->first()->name : 'user';
            switch ($role) {
                case 'admin':
                    return $this->successRedirect('admin.dashboard', [], 'Login successful!');
                case 'premiumUser':
                    return $this->successRedirect('premium.homme', [], 'Login successful!');
                default:
                    return $this->successRedirect('user.homme', [], 'Login successful!');
            }
        }
        
        return $this->errorRedirect('login', [], 'Invalid login credentials');
    }

    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}
