<?php

namespace App\Policies;

use App\Models\User;

class ProductPolicy
{
    public function create(User $user){
        return $user->role === 'admin';
    }

    public function delete(User $user){
        return $user->role === 'admin'; //Todo: add new roles for admin can delete
    }
}
