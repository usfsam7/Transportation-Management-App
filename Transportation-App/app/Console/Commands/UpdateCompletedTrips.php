<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trip;
use Carbon\Carbon;

class UpdateCompletedTrips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trips:update-completed';
    protected $description = 'Mark trips as completed if their end time has passed';

    /**
     * The console command description.
     *
     * @var string
     */


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        Trip::where('status', '!=', 'completed')
            ->where('ends_at', '<=', $now)
            ->update(['status' => 'completed']);

        $this->info('Trips updated successfully.');
    }
}
