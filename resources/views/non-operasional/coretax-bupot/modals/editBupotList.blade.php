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
                        <div class="row mt-2">
                            <div class="col-md-5 mt-1">
                                <label for="supplier{{ $bupot->id }}">Supplier</label>
                            </div>
                            <div class="col">
                                <input type="text" id="supplier{{ $bupot->id }}" class="form-control form-control-sm"
                                    value="{{ $bupot->supplier->name }}" disabled>
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
                                    class="form-control form-control-sm" name="dpp" value="{{ $bupot->dpp }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col">

                    </div>
                </div>
            </div>
        </div>
    </div>