<x-filament::page>
    <div class="space-y-6">
        {{ $this->form }}
        <br>
        <x-filament::button wire:click="submit" class="mt-4">
            Show Available
        </x-filament::button>

        @if(count($combinedData))
            <div class="overflow-x-auto mt-6 bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-2">Available Drivers & Vehicles</h2>
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left">Driver Name</th>
                        
                            <th class="border px-4 py-2 text-left">Vehicle Model</th>
                            <span></span>
                            <th class="border px-4 py-2 text-left">Plate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($combinedData as $row)
                            <tr>
                                <td class="border px-4 py-2">{{ $row['driver'] ?? '-' }}</td>
                                <span></span>
                                <td class="border px-4 py-2">{{ $row['vehicle_model'] ?? '-' }}</td>
                                <span></span>
                                <td class="border px-4 py-2">{{ $row['vehicle_plate'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-filament::page>
