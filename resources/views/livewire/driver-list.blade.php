<div>
    <select wire:model.live="vehicleType" name="vehicleType" class="form-select form-select-sm">
        <option value="">Pilih Kategori Kendaraan</option>
        <option value="Kendaraan Kecil">Kendaraan Kecil</option>
        <option value="Kendaraan Besar">Kendaraan Besar</option>
    </select>

    <select name="drivers" class="form-select form-select-sm">
        <option value="">Pilih Supir</option>
        @foreach ($drivers as $driver)
        <option value="{{ $driver->id }}">{{ $driver->fullname }}</option>
        @endforeach
    </select>
</div>