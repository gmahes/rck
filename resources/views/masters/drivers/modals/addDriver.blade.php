<!-- Modal -->
<div class="modal fade" id="addDriver" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-dark fw-bold fs-5" id="staticBackdropLabel">
                    Tambah Data Supir
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start text-dark">
                <form action="{{ route('add-driver') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="fullname" class="form-label">Nama
                                    Lengkap</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="fullname"
                                    placeholder="Masukkan Nama Lengkap" name="fullname" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="vehicleNumber" class="form-label">Nomor Kendaraan</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="vehicleNumber"
                                    placeholder="Masukkan Nomor Kendaraan" name="vehicle_number" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="vehicleType" class="form-label">Jenis Kendaraan</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select form-select-sm" aria-label="vehicleType" name="vehicle_type"
                                    required>
                                    @foreach ($vehicle_type as $vehicle)
                                    <option value="{{ $vehicle }}">{{ $vehicle }}</option>
                                    @endforeach
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