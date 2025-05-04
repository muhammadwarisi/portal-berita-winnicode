<?php

namespace App\Services\User;

use App\Models\Roles;
use App\Models\User;
use App\Services\User\UserServiceInterface;

class UserServices implements UserServiceInterface
{
    public function getAllUser()
    {
        return User::with('roles')->get();
    }

    public function createUser($data)
    {
        return User::create($data);
    }

    public function getUserRoles()
    {
      return Roles::all();
    }
}
