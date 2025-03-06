<!-- Modal -->
<div class="modal fade" id="editSupplier{{ $supplier->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Edit Data Supplier</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit-supplier', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editid{{ $supplier->id }}" class="form-label">Nomor Identitas</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="editid{{ $supplier->id }}"
                                    placeholder="Masukkan Nomor Identitas Supplier" name="id" disabled
                                    value="{{ $supplier->id }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editname{{ $supplier->id }}" class="form-label">Nama
                                    Supplier</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="editname{{ $supplier->id }}"
                                    placeholder="Masukkan Nama Supplier" name="name" required
                                    value="{{ $supplier->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editcode{{ $supplier->id }}" class="form-label">Kode Objek</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="editcode{{ $supplier->id }}"
                                    placeholder="Masukkan Kode Objek" name="code" required
                                    value="{{ $supplier->code }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editdocument{{ $supplier->id }}" class="form-label">Jenis Dokumen</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select form-select-sm" id="editdocument"
                                    name="document{{ $supplier->id }}" required>
                                    @foreach ($document as $key => $dokumen)
                                    <option value="{{ $key }}" @if ($key==$supplier->document) selected
                                        @endif>{{ $dokumen }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mt-2">
                        <div class="row">
                            <div class="col-4">
                                <label for="editfacility{{ $supplier->id }}" class="form-label">Fasilitas</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select form-select-sm" id="editfacility{{ $supplier->id }}"
                                    name="facility" required>
                                    @foreach ($facility as $key => $fasilitas)
                                    <option value="{{ $key }}" @if ($key==$supplier->facility) selected
                                        @endif>{{ $fasilitas }}</option>
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