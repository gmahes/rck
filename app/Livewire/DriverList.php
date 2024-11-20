<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use App\Models\Drivers;
use Livewire\Component;

class DriverList extends Component
{
    public $vehicleType = '';
    public $drivers = [];

    public function mount()
    {
        $this->drivers = Drivers::all();
    }

    public function updatedVehicleType()
    {
        try {
            $this->drivers = Drivers::where('vehicle_type', $this->vehicleType)->get();
        } catch (\Exception $e) {
            // Tangkap error jika terjadi kesalahan saat query
            Log::error('Error fetching drivers: ' . $e->getMessage());
        }
        $this->render();
    }

    public function render()
    {
        return view('livewire.driver-list');
    }
}
