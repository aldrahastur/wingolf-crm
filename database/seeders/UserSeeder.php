<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $team = Team::factory()->create([
            'name' => 'Hallenser Wingolf',
        ]);

        $user = User::factory()->create([
            'first_name' => 'Willi',
            'last_name' => 'Helwig',
            'email' => 'admin-wingolf@ideaboard.dev',
            'team_id' => $team->id,
        ]);

        $user->assignRole('Super Admin');
        $team->users()->sync($user);

        $secondUser = User::factory()->create([
            'first_name' => 'Team',
            'last_name' => 'Leader',
            'email' => 'team-wingolf@ideaboard.dev',
            'team_id' => $team->id,
        ]);

        $team->users()->attach($secondUser);

        User::factory()->create([
            'first_name' => 'Simple',
            'last_name' => 'User',
            'email' => 'user-wingolf@ideaboard.dev',
        ]);
    }
}
