<?php

namespace App\Http\Controllers;

use App\Models\RentalContract;
use App\Models\Room;

class RentalContractController extends Controller
{
    public function createContract(Room $room, $contractData = null)
    {
        $requestData = [
            'room_id' => $room->id,
            'user_id' => $contractData['user_id'],
            'team_id' => $room->team_id,
            'started_at' => $contractData['started_at'],
            'rental_price' => $contractData['rental_price'],
        ];

        RentalContract::updateOrCreate(['room_id' => $room->id,], $requestData);

        $room->user_id = $contractData['user_id'];
        $room->save();
    }
}
