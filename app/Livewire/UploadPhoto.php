<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadPhoto extends Component
{
    use WithFileUploads;

    public $foto;

    public function updatedFoto()
    {
        $this->validate([
            'foto' => 'mimes:jpg,jpeg,png,webp',
        ]);
    }

    public function simpan()
    {
        $this->validate([
            'foto' => 'required|mimes:jpg,jpeg,png,webp',
        ]);

        $this->foto->store('public/foto');

        session()->flash('pesan', 'Foto berhasil diupload.');
    }
    public function render()
    {
        return view('livewire.upload-photo');
    }
}
