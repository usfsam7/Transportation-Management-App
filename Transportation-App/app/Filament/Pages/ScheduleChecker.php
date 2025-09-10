<?php

namespace App\Filament\Pages;

use App\Models\Driver;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use UnitEnum;
use BackedEnum;

class ScheduleChecker extends Page
{
    use InteractsWithForms;

    // Navigation settings (correct type)
    public static UnitEnum|string|null $navigationGroup = 'Scheduling';
    public static ?string $navigationLabel = 'Availability Checker';
    public static BackedEnum|string|null $navigationIcon = 'heroicon-o-calendar';

    protected string $view = 'filament.schedule-checker';

    public $start_date;
    public $end_date;

    public $availableDrivers = [];
    public $availableVehicles = [];

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\DateTimePicker::make('start_date')
                ->label('Start Time')
                ->required(),

            Forms\Components\DateTimePicker::make('end_date')
                ->label('End Time')
                ->required()
                ->afterOrEqual('start_date'),
        ];
    }

    public function mount(): void
    {
        // $this->form->fill([
        //     'start_date' => now(),
        //     'end_date' => now()->addHour(),
        // ]);
    }

    public $combinedData = [];

    public function submit()
    {
        $this->form->validate();

        $start = $this->form->getState('start_date');
        $end = $this->form->getState('end_date');

        $availableDrivers = Driver::all()
            ->filter(fn($driver) => $driver->isAvailableBetween($start, $end))->where('active', true);

        $availableVehicles = Vehicle::all()
            ->filter(fn($vehicle) => $vehicle->isAvailableBetween($start, $end))->where('active', true);

        // Merge into combined array
        $this->combinedData = [];

        $max = max($availableDrivers->count(), $availableVehicles->count());

        for ($i = 0; $i < $max; $i++) {
            $this->combinedData[] = [
                'driver' => $availableDrivers->get($i)?->name ?? null,
                'vehicle_model' => $availableVehicles->get($i)?->model ?? null,
                'vehicle_plate' => $availableVehicles->get($i)?->plate ?? null,
            ];
        }
    }
}
