<div>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-md-4">
                    <label for="supplier" class="">Nama Supplier</label>
                </div>
                <div class="col" wire:ignore>
                    <select wire:model.live="selectedSupplier" id="supplier" class="selectpicker" name="supplier"
                        data-live-search="true" data-size="4" data-width="100%" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" wire:key="{{ $supplier->id }}">{{ $supplier->alias == ''
                            ? $supplier->name : $supplier->name. '
                            ('.$supplier->alias.')' }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="docId">Nomor Dokumen</label>
                </div>
                <div class="col">
                    <input type="text" id="docId" class="form-control form-control-sm" name="docId" required
                        autocomplete="off">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="dpp">DPP</label>
                </div>
                <div class="col">
                    <input type="text" id="dpp" class="form-control form-control-sm" name="dpp" autocomplete="off"
                        wire:model="dpp" wire:change="recalc" required>
                    <div class="form-text mt-1">
                        @php
                        $fmt = fn($n) => $n ? 'Rp '.number_format($n, 0, ',', '.') : '-';
                        $rateText = $percentage ?: ($rate ? ($rate.'%') : '0%');
                        @endphp
                        Perkiraan PPh ({{ $percentage . '%' }}) : <strong>Rp {{ number_format($pph, 0, ',', '.')
                            }}</strong>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="date">Tanggal Dokumen</label>
                </div>
                <div class="col">
                    <input type="date" id="date" class="form-control form-control-sm" name="date" required>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="sbu">SBU</label>
                </div>
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="ckl" id="sbu" name="sbu">
                        <label class="form-check-label" for="sbu">
                            CKL
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-md-4">
                    <label for="idNumber">No Identitas</label>
                </div>
                <div class="col">
                    <input type="text" id="idNumber" wire:model="idNumber" class="form-control form-control-sm"
                        disabled>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="kode_objek">Kode Objek</label>
                </div>
                <div class="col">
                    <input type="text" id="kode_objek" wire:model="code" class="form-control form-control-sm" disabled>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="persentase">Persentase</label>
                </div>
                <div class="col">
                    <input type="text" id="persentase" wire:model="percentage" class="form-control form-control-sm"
                        disabled>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="document">Jenis Dokumen</label>
                </div>
                <div class="col">
                    <input type="text" id="document" wire:model="document" class="form-control form-control-sm"
                        disabled>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="facility">Fasilitas</label>
                </div>
                <div class="col">
                    <input type="text" id="facility" wire:model="facility" class="form-control form-control-sm"
                        disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
        </div>
    </div>
</div>