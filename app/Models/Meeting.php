<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = [
        'title',
        'team_id',
        'membership_id',
        'visibility',
        'protocol',
        'file_path',
    ];

    protected $casts = [
        'date' => 'datetime:d.m.Y',
    ];

    public function team(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(MeetingParticipant::class);
    }
}
