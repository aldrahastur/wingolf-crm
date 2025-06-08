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
        'membership_admission_date',
        'membership_leave_date',
        'fee_required',
        'voluntary_payer'
    ];

    protected $casts = [
        'fee_required' => 'boolean',
    ];

    public function isFeeRequired(): bool
    {
        return $this->fee_required;
    }
}
