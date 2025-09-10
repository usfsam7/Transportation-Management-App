<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory;

     protected $fillable = ['company_id','plate','model','active'];
    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function drivers(): BelongsToMany { return $this->belongsToMany(Driver::class); }
    public function trips(): HasMany { return $this->hasMany(Trip::class); }

    public function isAvailableBetween($startsAt, $endsAt) : bool {
        return !$this->trips()
            ->where(function($q) use ($startsAt, $endsAt) {
                $q->where('starts_at','<',$endsAt)->where('ends_at','>',$startsAt);
            })->exists();
    }
}
