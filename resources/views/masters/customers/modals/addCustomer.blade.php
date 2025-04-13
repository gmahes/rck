<!-- Modal -->
<div class="modal fade" id="addCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-dark fw-bold fs-5" id="staticBackdropLabel">
                    Tambah Data Pelanggan
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start text-dark">
                <form action="{{ route('add-customer') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="name" class="form-label">Nama
                                    Pelanggan</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="name"
                                    placeholder="Masukkan Nama Pelanggan" name="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="idNumber" class="form-label">Nomor Identitas</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="idNumber"
                                    placeholder="Masukkan Nomor Identitas Pelanggan" name="idNumber" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="idNumberType" class="form-label">Tipe Nomor Identitas</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select form-select-sm" id="idNumberType" name="idNumberType"
                                    required>
                                    <option value="" selected disabled>Pilih Tipe Nomor Identitas</option>
                                    <option value="KTP">KTP</option>
                                    <option value="NPWP">NPWP</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="address" class="form-label">Alamat Pelanggan</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="address"
                                    placeholder="Masukkan Alamat Pelanggan" name="address" required>
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