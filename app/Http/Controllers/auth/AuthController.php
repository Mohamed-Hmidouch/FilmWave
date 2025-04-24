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

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginUserValidator $loginUserValidator)
    {
        if(!empty($loginUserValidator->getErrors()))
        {
            return $this->backWithErrors($loginUserValidator->getErrors(), 'Please check your login details');
        }
        
        $credentials = $loginUserValidator->request()->only('email', 'password');
        $redirectTo = $loginUserValidator->request()->input('redirect_to');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $roles = $user->roles()->get();
            $role = $roles->isNotEmpty() ? $roles->first()->name : 'user';
            
            // Si une URL de redirection est spécifiée, y rediriger l'utilisateur
            if ($redirectTo) {
                return redirect()->to($redirectTo);
            }
            
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
        
        // Redirection explicite vers la page d'accueil
        return redirect()->route('home')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
