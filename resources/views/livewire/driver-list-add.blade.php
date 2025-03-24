<div>
    <select name="driver_id" class="selectpicker" data-live-search="true" data-size="4" data-width="100%" required>
        <option value="">-- Pilih Supir --</option>
        <optgroup label="Kendaraan Besar">
            @foreach ($drivers as $driver)
            <option value="{{ $driver->id }}" wire:key="{{ $driver->id }}">{{ $driver->fullname }}</option>
            @endforeach
        </optgroup>
    </select>
</div>