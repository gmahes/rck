<?php

namespace App\Livewire;

use App\Models\Suppliers;
use Illuminate\Database\Console\DumpCommand;
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
    public $rate = 0.0;
    public $dpp = '';
    public $pph = 0;

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
            $this->percentage = $supplier->percentage;
        } else {
            $this->idNumber = '';
            $this->code = '';
            $this->document = '';
            $this->facility = '';
            $this->percentage = '';
        }
    }
    public function recalc()
    {
        $this->recalcPPh();
    }
    private function recalcPPh(): void
    {
        $dppNumber = (int) preg_replace('/[^\d]/', '', (string) $this->dpp);
        $percentage = (float) $this->percentage; // langsung ambil dari properti

        $this->pph = ($dppNumber > 0 && $percentage > 0)
            ? (int) round($dppNumber * ($percentage / 100))
            : 0;
    }

    public function render()
    {
        return view('livewire.get-supplier');
    }
}
