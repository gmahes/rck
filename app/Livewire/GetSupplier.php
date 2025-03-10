<?php

namespace App\Livewire;

use App\Models\Suppliers;
use Livewire\Component;

class GetSupplier extends Component
{
    public $suppliers;
    public $selectedSupplier;
    public $idNumber;
    public $code;
    public $document;
    public $facility;
    public $percentage;

    public function mount()
    {
        $this->suppliers = Suppliers::all()->sortBy('name');
    }
    public function updatedSelectedSupplier($supplierId)
    {
        $supplier = Suppliers::find($supplierId);
        if ($supplier) {
            $this->idNumber = $supplier->id;
            $this->code = $supplier->code;
            $this->document = $supplier->document;
            $this->facility = $supplier->facility;
            $this->percentage = $supplier->percentage . '%';
        } else {
            $this->idNumber = '';
            $this->code = '';
            $this->document = '';
            $this->facility = '';
            $this->percentage = '';
        }
    }
    public function render()
    {
        return view('livewire.get-supplier');
    }
}
