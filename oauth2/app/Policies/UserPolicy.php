<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function addRole(User $user)
    {
        return $user->role_id === 1; 
    }

    public function addUser(User $user)
    {
        return $user->role_id === 1; 
    }

    public function deleteRole(User $user)
    {
        return $user->role_id === 1; 
    }
}
