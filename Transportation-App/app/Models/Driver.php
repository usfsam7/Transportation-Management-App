<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
    use HasFactory;

     protected $fillable = ['company_id','name','license_number','active'];
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function vehicles(): BelongsToMany { return $this->belongsToMany(Vehicle::class); }
    public function trips(): HasMany { return $this->hasMany(Trip::class); }

    // check if free between given times
    public function isAvailableBetween($startsAt, $endsAt) : bool {
        return !$this->trips()
            ->where(function($q) use ($startsAt, $endsAt) {
                $q->where('starts_at','<',$endsAt)->where('ends_at','>',$startsAt);
            })->exists();
    }
}
