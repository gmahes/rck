<!-- Modal -->
<div class="modal fade" id="addComplaint" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-dark fw-bold fs-5" id="staticBackdropLabel">
                    Data Pengaduan
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start text-dark">
                <form action="{{ route('add-complaint') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (Auth::user()->role == 'user')
                    <input type="hidden" name="user" value="{{ Auth::user()->userDetail->nik }}">
                    @endif
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-4 my-auto">
                                    <label for="troubleID" class="form-label">Trouble ID</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="troubleID"
                                        placeholder="Masukkan Permasalahan" readonly value="{{ $troubleID }}" disabled>
                                </div>
                            </div>
                            @if (Auth::user()->role != 'user')
                            <div class="row mt-2">
                                <div class="col-4 my-auto">
                                    <label for="user" class="form-label">Pelapor<p class="d-inline fw-bold">*</p>
                                        </label>
                                </div>
                                <div class="col-8 mt-1">
                                    <select name="user" id="user" class="selectpicker form-control form-control-sm"
                                        data-live-search="true" data-size="3" required>
                                        <option value="" selected disabled>Pilih Pelapor</option>
                                        @foreach ($employees as $user)
                                        <option value="{{ $user->nik }}">{{ $user->fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="row mt-2">
                                <div class="col-4 mt-2">
                                    <label for="category" class="form-label">Kategori<p class="d-inline fw-bold">*</p>
                                    </label>
                                </div>
                                <div class="col-8 my-auto">
                                    <select name="category" id="category"
                                        class="selectpicker form-control form-control-sm" data-live-search="true"
                                        data-size="3" required>
                                        <option value="" selected disabled>Pilih Kategori</option>
                                        <optgroup label="Perangkat Keras" class="text-start">
                                            @foreach ($hardware as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Perangkat Lunak" class="text-start">
                                            @foreach ($software as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4 my-auto">
                                    <label for="trouble" class="form-label">Permasalahan<p class="d-inline fw-bold">*
                                        </p></label>
                                </div>
                                <div class="col-8">
                                    <textarea name="trouble" id="trouble" class="form-control form-control-sm w-100"
                                        cols="" rows="3" placeholder="Masukkan Permasalahan" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-4 mt-2">
                                    <label for="foto" class="form-label">Gambar Pendukung</label>
                                </div>
                                <div class="col-8">
                                    @livewire('upload-photo')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="text-start">
                                <p class="text-danger form-text"><em><strong>* </strong>Wajib diisi
                                    </em></p>
                            </div>
                        </div>
                        <div class="col">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>