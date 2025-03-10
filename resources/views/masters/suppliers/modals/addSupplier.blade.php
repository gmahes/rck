<!-- Modal -->
<div class="modal fade" id="addSupplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-dark fw-bold fs-5" id="staticBackdropLabel">
                    Tambah Data Supplier
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start text-dark">
                <form action="{{ route('add-supplier') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="idNumber" class="form-label">Nomor Identitas</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="idNumber"
                                    placeholder="Masukkan Nomor Identitas Supplier" name="id" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="name" class="form-label">Nama
                                    Supplier</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="name"
                                    placeholder="Masukkan Nama Supplier" name="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="code" class="form-label">Kode Objek</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="code"
                                    placeholder="Masukkan Kode Objek" name="code" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="percentage" class="form-label">Persentase</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="percentage"
                                    placeholder="Masukkan hanya angka tanpa simbol %" name="percentage" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="document" class="form-label">Jenis Dokumen</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select form-select-sm" id="document" name="document" required>
                                    <option value="" selected disabled>Pilih Jenis Dokumen</option>
                                    <option value="TaxInvoice">Faktur Pajak</option>
                                    <option value="PaymentProof">Bukti Pembayaran</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mt-2">
                        <div class="row">
                            <div class="col-4">
                                <label for="facility" class="form-label">Fasilitas</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select form-select-sm" id="facility" name="facility" required>
                                    <option value="" selected disabled>Pilih Fasilitas</option>
                                    <option value="N/A">Tanpa Fasilitas</option>
                                    <option value="TaxExAr22">SKB PPh Pasal 22</option>
                                    <option value="TaxExAr23">SKB PPh Pasal 23</option>
                                    <option value="PP23">SK PP 23/2018</option>
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