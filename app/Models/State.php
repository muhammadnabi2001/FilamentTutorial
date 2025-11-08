<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    protected $fillable = [
        'country_id',
        'name',
    ];

    // public function country()
    // {
    //     $this->belongsTo(Country::class);
    // }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class,'country_id');
    }
    public function cities(): HasMany
    {
        return $this->hasMany(City::class,'state_id');
    }
}
