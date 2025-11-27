<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $guarded = [];
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
