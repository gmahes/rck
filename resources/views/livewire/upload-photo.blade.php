<div>
    <div class="mt-1">
        <input class="form-control form-control-sm" type="file" id="foto" wire:model="foto"
            accept="image/jpeg,image/png,image/webp">
        @error('foto') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>
    {{-- Preview gambar --}}
    @if ($foto)
    <div class="mt-1">
        <label class="form-label">Preview:</label><br>
        <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail" style="max-height: 200px;">
    </div>
    @endif
    @if (session()->has('pesan'))
    <div class="alert alert-success mt-3">
        {{ session('pesan') }}
    </div>
    @endif
</div>