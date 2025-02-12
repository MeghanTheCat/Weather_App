<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserCity;

class UserCityPolicy
{
    public function update(User $user, UserCity $city)
    {
        return $user->id === $city->user_id;
    }
}
