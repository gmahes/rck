<?php

namespace App\Livewire;

use App\Models\Suppliers;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

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
        $document = [
            'TaxInvoice' => 'Faktur Pajak',
            'PaymentProof' => 'Bukti Pembayaran',
        ];
        $facility = [
            'N/A' => 'Tanpa Fasilitas',
            'TaxExAr22' => 'SKB PPh Pasal 22',
            'TaxExAr23' => 'SKB PPh Pasal 23',
            'PP23' => 'SK PP 23/2018'
        ];
        $supplier = Suppliers::find($supplierId);
        if ($supplier) {
            $this->idNumber = $supplier->id;
            $this->code = $supplier->code;
            $this->document = $document[$supplier->document];
            $this->facility = $facility[$supplier->facility];
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
