<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Poll extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = [
        'team_id',
        'title',
        'description',
        'public_token',
    ];

    public static function booted(): void
    {
        static::creating(function (Poll $poll) {
            $poll->public_token = Str::uuid(); // oder Str::random(20), je nach Vorliebe
        });
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function pollOptions()
    {
        return $this->hasMany(PollOption::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
