<!-- Modal -->
<div class="modal fade" id="editBupotList{{ $bupot->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Edit Data Bupot</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <form id="editBupot" action="{{ route('edit-bupot', $bupot->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="percentage" value="{{ $bupot->supplier->percentage }}">
                            <div class="row">
                                <div class="col-md-5 mt-1">
                                    <label for="supplier{{ $bupot->id }}">Supplier</label>
                                </div>
                                <div class="col">
                                    <input type="text" id="supplier{{ $bupot->id }}"
                                        class="form-control form-control-sm" value="{{ $bupot->supplier->name }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-5 mt-1">
                                    <label for="date-{{ $bupot->id }}">Tgl Dokumen</label>
                                </div>
                                <div class="col">
                                    <input type="date" id="date-{{ $bupot->id }}" class="form-control form-control-sm"
                                        name="date" value="{{ $bupot->date }}" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-5 mt-1">
                                    <label for="docId{{ $bupot->id }}">No Dokumen</label>
                                </div>
                                <div class="col">
                                    <input type="text" id="docId-{{ $bupot->id }}" class="form-control form-control-sm"
                                        name="docId" value="{{ $bupot->docId }}" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-5 mt-1">
                                    <label for="editDpp{{ $loop->iteration }}">DPP</label>
                                </div>
                                <div class="col">
                                    <input type="text" id="editDpp{{ $loop->iteration }}"
                                        class="form-control form-control-sm" name="dpp" value="{{ $bupot->dpp }}"
                                        required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="idNumber{{ $bupot->id }}">No Identitas</label>
                            </div>
                            <div class="col">
                                <input type="text" id="idNumber{{ $bupot->id }}" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->id }}" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="kode_objek{{ $bupot->id }}">Kode Objek</label>
                            </div>
                            <div class="col">
                                <input type="text" id="kode_objek{{ $bupot->id }}" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->code }}" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="persentase{{ $bupot->id }}">Persentase</label>
                            </div>
                            <div class="col">
                                <input type="text" id="persentase{{ $bupot->id }}" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->percentage . '%' }}" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="document{{ $bupot->id }}">Jenis Dok</label>
                            </div>
                            <div class="col">
                                <input type="text" id="document{{ $bupot->id }}" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->document }}" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="facility{{ $bupot->id }}">Fasilitas</label>
                            </div>
                            <div class="col">
                                <input type="text" id="facility{{ $bupot->id }}" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->facility }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="d-flex flex-row-reverse">
                        <div class="text-end">
                            <button type="submit" form="editBupot" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                        <div class="text-end me-2">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>