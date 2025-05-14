<div>
    <div class="mt-1">
        <input class="form-control form-control-sm" type="file" id="foto" wire:model="foto"
            accept="image/jpeg,image/png,image/webp" name="photo">
        @error('foto') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>
    @if ($foto)
    <div class="mt-1">
        <label class="form-label">Preview:</label><br>
        <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail" style="max-height: 200px;">
    </div>
    @endif
</div>