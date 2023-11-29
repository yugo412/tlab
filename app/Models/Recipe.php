<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'portion',
    ];

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);

    }

    public function cooks(): HasMany
    {
        return $this->hasMany(Cook::class);
    }
}


