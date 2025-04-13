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
                        <form action="{{ route('edit-bupot', $bupot->id) }}" method="POST">
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
                            <div class="row mt-2">
                                <div class="col-auto d-flex">
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="idNumber">No Identitas</label>
                            </div>
                            <div class="col">
                                <input type="text" id="idNumber" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->id }}" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="kode_objek">Kode Objek</label>
                            </div>
                            <div class="col">
                                <input type="text" id="kode_objek" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->code }}" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="persentase">Persentase</label>
                            </div>
                            <div class="col">
                                <input type="text" id="persentase" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->percentage }}" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="document">Jenis Dok</label>
                            </div>
                            <div class="col">
                                <input type="text" id="document" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->document }}" disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="facility">Fasilitas</label>
                            </div>
                            <div class="col">
                                <input type="text" id="facility" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->facility }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>