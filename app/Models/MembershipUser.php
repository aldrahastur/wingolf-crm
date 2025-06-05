<?php

namespace App\Models;

use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MembershipUser extends Pivot
{
    use HasWallet;

    protected $table = 'membership_user';

    protected $fillable = [
        'membership_id',
        'user_id',
    ];
}
