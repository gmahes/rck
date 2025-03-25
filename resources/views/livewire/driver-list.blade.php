<div>
    <div class="col">
        <div class="row">
            <select wire:model.live="vehicleType" name="vehicleType" class="selectpicker">
                <option value="null">Pilih Tipe Kendaraan</option>
                <option value="Kendaraan Kecil">Kendaraan Kecil</option>
                <option value="Kendaraan Besar">Kendaraan Besar</option>
            </select>
        </div>
        <div class="row">
            <select name="driver" class="selectpicker mt-1">
                <option value="null">Pilih Supir</option>
                <option value="all">Semua Supir</option>
                @foreach ($drivers as $driver)
                <option value="{{ $driver->id }}" wire:key="driver-{{ $driver->id }}">{{ $driver->fullname }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>