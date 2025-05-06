<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends \Spatie\Permission\Models\Role
{
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
