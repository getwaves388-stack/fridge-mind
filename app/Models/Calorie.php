<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calorie extends Model
{
    use HasFactory;

    // Specify the name of the associated table (this prevents errors caused by Laravel's automatic pluralization).
    protected $table = 'calories';

    // List of columns permitted for batch saving (create/update) from the controller.
    protected $fillable = [
        'key_name', // Ingredient keywords
        'calories', // Approximate calorie 
    ];
}
