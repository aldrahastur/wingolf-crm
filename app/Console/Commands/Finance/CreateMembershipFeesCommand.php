<?php

namespace App\Console\Commands\Finance;

use App\Models\Membership;
use Illuminate\Console\Command;

class CreateMembershipFeesCommand extends Command
{
    protected $signature = 'finance:create-membership-fees';

    protected $description = 'Command description';

    public function handle(): void
    {
        $memberships = Membership::all();

        foreach ($memberships as $membership) {

            $users = $membership->users()
                ->whereNull('membership_leave_date')
                ->get();

            foreach ($users as $user) {
                if (!$user->hasWallet('membership_wallet_'.$membership->id)) {
                    $wallet = $user->createWallet([
                        'name' => $user->getFilamentName().' '.$membership->name.' Wallet',
                        'slug' => 'membership_wallet_'.$membership->id,
                    ]);
                } else {
                    $wallet = $user->getWallet('membership_wallet_'.$membership->id);
                }
                $wallet->forceWithdrawFloat($membership->member_fee);
            }
        }
    }
}
