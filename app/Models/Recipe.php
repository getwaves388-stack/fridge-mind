<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    // To get the owner of the recipe
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
