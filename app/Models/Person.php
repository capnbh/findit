<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $fillable = [
        'vine_id',
        'first_name',
        'last_name',
        'name',
        'is_player_character',
        'primary_building_id',
    ];

    protected function casts(): array
    {
        return [
            'is_player_character' => 'boolean',
        ];
    }

    public function casePeople(): HasMany
    {
        return $this->hasMany(CasePerson::class, 'person_id')->orderBy('id');
    }

    public function primaryBuilding(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'primary_building_id');
    }
}
