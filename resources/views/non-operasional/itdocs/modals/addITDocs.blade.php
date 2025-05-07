<!-- Modal -->
<div class="modal fade" id="addITDocs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-dark fw-bold fs-5" id="staticBackdropLabel">
                    Tambah Dokumentasi IT
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start text-dark">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-4 mt-1">
                                        <label for="idDoc" class="form-label">Nomor ID</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="idDoc"
                                            placeholder="Masukkan Permasalahan" name="name" required disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-4 mt-1">
                                        <label for="name" class="form-label">Permasalahan</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="name"
                                            placeholder="Masukkan Permasalahan" name="name" required autocomplete="off">
                                    </div>
                                </div>
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