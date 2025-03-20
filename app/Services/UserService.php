<?php
namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $userData)
    {
        try {
            $userData['password'] = Hash::make($userData['password']);
            $user = User::create($userData);
            $plan = $userData['plan'] ?? 'free';

            $roleName = ($plan === 'premium') ? 'premiumUser' : 'freeUser';
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                $user->roles()->attach($role->id);
                Log::info("User {$user->id} assigned role: {$roleName}");
            } else {
                Log::warning("Role '{$roleName}' not found when creating user {$user->id}");
            }

            return $user;
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            throw $e;
        }
    }
}