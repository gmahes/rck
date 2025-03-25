<?php

namespace App\Livewire;

use App\Models\Drivers;
use Livewire\Component;

class DriverList extends Component
{
    public $vehicleType = '';
    public $drivers = [];
    // public function mount()
    // {
    //     $this->drivers = Drivers::all()->sortBy('fullname');
    // }

    public function updatedVehicleType()
    {
        $this->drivers = Drivers::all()->where('vehicle_type', $this->vehicleType)->sortBy('fullname');
    }

    public function render()
    {
        return view('livewire.driver-list');
    }
}
