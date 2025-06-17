<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UploadPhoto extends Component
{
    use WithFileUploads;

    public $foto;
    public $savedPhotoURL;

    public function mount($savedPhotoPath = null)
    {
        if ($savedPhotoPath) {
            $this->savedPhotoURL = Storage::url($savedPhotoPath);
        }
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
