<?php

namespace App\Livewire;

use App\Models\Drivers;
use Livewire\Component;

class DriverListAdd extends Component
{
    public $drivers = [];
    public function mount()
    {
        $this->drivers = Drivers::all()->sortBy('fullname');
    }

    public function render()
    {
        return view('livewire.driver-list-add');
    }
}
