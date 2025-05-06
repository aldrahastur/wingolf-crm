<?php

namespace App\Console\Commands\Finance;

use App\Models\RentalContract;
use Illuminate\Console\Command;

class CreateRentalTransactionsCommand extends Command
{
    protected $signature = 'finance:create-rental-transactions';

    protected $description = 'Command description';

    public function handle(): void
    {
        $rentalContracts = RentalContract::all();

        foreach ($rentalContracts as $rentalContract) {
            $rentalContract->forceWithdrawFloat($rentalContract->rental_price);
            $this->info($rentalContract);
        }
    }
}
