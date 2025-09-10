<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class Trip extends Model
{
    /** @use HasFactory<\Database\Factories\TripFactory> */
    use HasFactory;

    protected $fillable = ['company_id', 'driver_id', 'vehicle_id', 'starts_at', 'ends_at', 'status'];
    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime'];

    public function scopeActive($query)
    {
        return $query->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Boot model to validate overlaps before saving
    protected static function booted()
    {
        static::saving(function (Trip $trip) {
            // ensure ends_at exists
            if (!$trip->ends_at) {
                $trip->ends_at = $trip->starts_at->copy()->addHours(2);
            }

            $validator = Validator::make($trip->toArray(), [
                'driver_id' => 'required|exists:drivers,id',
                'vehicle_id' => 'required|exists:vehicles,id',
                'starts_at' => 'required|date',
                'ends_at' => 'required|date|after:starts_at',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // overlapping check (driver)
            $driverConflicts = Trip::where('driver_id', $trip->driver_id)
                ->where('id', '!=', $trip->id ?? 0)
                ->where(function ($q) use ($trip) {
                    $q->where('starts_at', '<', $trip->ends_at)
                        ->where('ends_at', '>', $trip->starts_at);
                })->exists();

            if ($driverConflicts) {
                throw ValidationException::withMessages(['driver_id' => 'Driver is already assigned to an overlapping trip.']);
            }

            // overlapping check (vehicle)
            $vehicleConflicts = Trip::where('vehicle_id', $trip->vehicle_id)
                ->where('id', '!=', $trip->id ?? 0)
                ->where(function ($q) use ($trip) {
                    $q->where('starts_at', '<', $trip->ends_at)
                        ->where('ends_at', '>', $trip->starts_at);
                })->exists();

            if ($vehicleConflicts) {
                throw ValidationException::withMessages(['vehicle_id' => 'Vehicle is already assigned to an overlapping trip.']);
            }
        });
    }
}
