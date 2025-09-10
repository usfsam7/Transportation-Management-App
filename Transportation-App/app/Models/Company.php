<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

     protected $fillable = ['name','timezone'];
    public function drivers(): HasMany { return $this->hasMany(Driver::class); }
    public function vehicles(): HasMany { return $this->hasMany(Vehicle::class); }
    public function trips(): HasMany { return $this->hasMany(Trip::class); }
}
