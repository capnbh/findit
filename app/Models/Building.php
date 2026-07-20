<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    protected $fillable = [
        'vine_id',
        'official_name',
        'common_name',
        'building_type',
        'development_fixture',
    ];

    protected function casts(): array
    {
        return [
            'development_fixture' => 'boolean',
        ];
    }

    public function people(): HasMany
    {
        return $this->hasMany(Person::class, 'primary_building_id')->orderBy('id');
    }
}
