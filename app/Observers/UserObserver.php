<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user): void
    {
        if (auth()->hasUser()) {
            $user->team()->associate(auth()->user()->team_id);
        }
    }
}
