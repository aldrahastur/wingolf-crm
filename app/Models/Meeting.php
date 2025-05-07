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
        'type',
        'team_id',
        'membership_id',
        'visibility',
        'protocol',
        'file_path',
    ];

    public function team(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
