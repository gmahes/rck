<!-- Modal -->
<div class="modal fade" id="editDriver{{ $driver->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Edit Data Karyawan</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit-driver', $driver->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editfullname{{ $driver->id }}" class="form-label">Nama
                                    Lengkap</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm"
                                    id="editfullname{{ $driver->id }}" placeholder="Masukkan Nama Lengkap"
                                    name="fullname" value="{{ $driver->fullname }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editVehicleNumber{{ $driver->id }}" class="form-label">Nomor
                                    Kendaraan</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm"
                                    id="editVehicleNumber{{ $driver->id }}" placeholder="Masukkan Nomor Kendaraan"
                                    name="vehicle_number" value="{{ $driver->vehicle_number }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editVehicleType{{ $driver->id }}" class="form-label">Role</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select form-select-sm" aria-label="editVehicleType{{ $driver->id }}"
                                    name="vehicle_type" required>
                                    @foreach ($vehicle_type as $vehicle)
                                    <option value="{{ $vehicle }}" @if ($vehicle==$driver->vehicle_type) selected
                                        @endif>{{ $vehicle }}</option>
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editStatus{{ $driver->id }}" class="form-label">Status</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select form-select-sm" aria-label="editStatus{{ $driver->id }}"
                                    name="status" required>
                                    <option value="Aktif" @if ($driver->status=='Aktif') selected @endif>Aktif</option>
                                    <option value="Non Aktif" @if ($driver->status=='Non Aktif') selected @endif>Non
                                        Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="d-flex flex-row-reverse">
                            <div class="text-end">
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </div>
                            <div class="text-end me-2">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>