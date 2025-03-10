<div>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-md-4">
                    <label for="supplier" class="">Nama Supplier</label>
                </div>
                <div class="col">
                    <select wire:model.live="selectedSupplier" id="supplier" class="form-select form-select-sm">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" wire:key="{{ $supplier->id }}">{{ $supplier->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="date">Tanggal Dokumen</label>
                </div>
                <div class="col">
                    <input type="date" id="date" class="form-control form-control-sm" name="date">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="docId">Nomor Dokumen</label>
                </div>
                <div class="col">
                    <input type="text" id="docId" class="form-control form-control-sm" name="docId">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="dpp">DPP</label>
                </div>
                <div class="col">
                    <input type="text" id="dpp" class="form-control form-control-sm" name="dpp">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label for="whdate">Tanggal Potong</label>
                </div>
                <div class="col">
                    <input type="date" id="whdate" class="form-control form-control-sm" name="date"
                        value="{{ date('Y-m-d') }}">
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
</div>