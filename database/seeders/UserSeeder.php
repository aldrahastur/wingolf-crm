<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Willi',
            'last_name' => 'Helwig',
            'email' => 'admin-wingolf@ideaboard.dev',
        ]);

        $user->assignRole('Super Admin');

        $team = Team::factory()->create([
            'name' => 'Hallenser Wingolf',
        ]);

        $user->team_id = $team->id;
        $user->save();

        $team->users()->sync($user);

        $secondUser = User::factory()->create([
            'first_name' => 'Team',
            'last_name' => 'Leader',
            'email' => 'team-wingolf@ideaboard.dev',
        ]);

        User::factory()->create([
            'first_name' => 'Simple',
            'last_name' => 'User',
            'email' => 'user-wingolf@ideaboard.dev',
        ]);
    }
}
