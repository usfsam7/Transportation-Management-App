<div class="activity-stats">
   
    <a href="{{ route('filament.app.resources.trips.index') }}" class="stat-item">
        🚚 Active Trips : <strong>{{ \App\Models\Trip::active()->count() }}</strong>
    </a>
    <span class="separator">|</span>
    <div class="stat-item">
        <a href="{{ route('filament.app.resources.drivers.index') }}" class="stat-item">
        👤 Active Drivers : <strong>{{ \App\Models\Driver::where('active', true)->count() }}</strong>
    </div>
    <span class="separator">|</span>
    <div class="stat-item">
        <a href="{{ route('filament.app.resources.vehicles.index') }}" class="stat-item">
        🚛 Active Vehicles : <strong>{{ \App\Models\Vehicle::where('active', true)->count() }}</strong>
    </div>
</div>

<style>
    .activity-stats {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.890rem;

    }

    .activity-stats .stat-item {
        display: flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .activity-stats .separator {
        color: #9ca3af;
    }
</style>
