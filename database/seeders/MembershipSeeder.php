<?php

namespace Database\Seeders;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        $team = $user->team;

        $memberships = $team->memberships()->createMany([
            ['name' => 'Brüderverein', 'member_fee' => 150],
            ['name' => 'Hausverein', 'member_fee' => 360],
            ['name' => 'Aktivitas', 'member_fee' => 40],
            ['name' => 'Mieter', 'member_fee' => 0],
        ]);

        foreach ($memberships as $membership) {
            $user->memberships()->attach($membership);
        }
    }
}
