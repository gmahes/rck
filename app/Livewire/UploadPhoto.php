<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UploadPhoto extends Component
{
    use WithFileUploads;

    public $foto;
    public $nik;
    public $status;

    public function mount($nik = null, $status = null)
    {
        $this->nik = $nik;
        $this->status = $status;
    }
    public function updatedFoto()
    {
        $this->validate([
            'foto' => 'mimes:jpg,jpeg,png,webp',
        ]);
    }
    public function render()
    {
        return view('livewire.upload-photo');
    }
}
