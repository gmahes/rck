<!-- Modal -->
<div class="modal fade" id="editCustomer{{ $customer->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Edit Data Pelanggan</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit-customer', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editname{{ $customer->id }}" class="form-label">Nama
                                    Pelanggan</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="editname{{ $customer->id }}"
                                    placeholder="Masukkan Nama Lengkap" name="name" value="{{ $customer->name }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editidNumber{{ $customer->id }}" class="form-label">Nomor
                                    Kendaraan</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm"
                                    id="editidNumber{{ $customer->id }}"
                                    placeholder="Masukkan Nomor Identitas Pelanggan" name="idNumber"
                                    value="{{ $customer->id }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editAddress{{ $customer->id }}" class="form-label">Role</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm"
                                    id="editAddress{{ $customer->id }}" placeholder="Masukkan Alamat" name="address"
                                    value="{{ $customer->address }}" required>
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