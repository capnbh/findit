<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseRecord extends Model
{
    protected $table = 'cases';

    protected $fillable = [
        'vine_id',
        'title',
    ];

    public function casePeople(): HasMany
    {
        return $this->hasMany(CasePerson::class, 'case_id')->orderBy('id');
    }
}
