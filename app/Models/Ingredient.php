<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingredient extends Model
{
    // To get the owner of the ingredient
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
