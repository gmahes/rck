<div>
    <select wire:model.live="vehicleType" name="vehicleType" class="form-select form-select-sm">
        <option value="null">Pilih Tipe Kendaraan</option>
        <option value="Kendaraan Kecil">Kendaraan Kecil</option>
        <option value="Kendaraan Besar">Kendaraan Besar</option>
    </select>

    <select name="driver_id" class="form-select form-select-sm mt-1">
        <option value="null">Pilih Supir</option>
        @foreach ($drivers as $driver)
        <option value="{{ $driver->id }}">{{ $driver->fullname }}</option>
        @endforeach
    </select>
</div>