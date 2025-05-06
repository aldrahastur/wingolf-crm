<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::first();

        $counter = 1;
        while ($counter < 12) {
            $team->rooms()->create([
                'house_number' => 35,
                'room_number' => $counter,
                'name' => 'Zimmer '.$counter,
                'team_id' => $team->id,
                'rental_price' => 180
            ]);

            $counter++;
        }
    }
}
