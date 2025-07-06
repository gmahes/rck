<!-- Modal -->
<div class="modal fade" id="editComplaint{{ $item->troubleID }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-dark fw-bold fs-5" id="staticBackdropLabel">
                    Data Pengaduan
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start text-dark">
                <form action="{{ route('edit-complaint') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-4 my-auto">
                                    <label for="troubleID{{ $item->troubleID }}" class="form-label">Trouble ID</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control"
                                        id="troubleID{{ $item->troubleID }}" placeholder="Masukkan Permasalahan"
                                        readonly value="{{ $item->troubleID }}" disabled>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4 my-auto">
                                    <label for="user{{ $item->troubleID }}" class="form-label">Pengguna<p
                                            class="d-inline fw-bold">*</p>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <select name="user" class="selectpicker" id="user{{ $item->troubleID }}"
                                        data-width="100%" data-live-search="true" data-size="4" required>
                                        <option value="">-- Pilih Pengguna --</option>
                                        @foreach ($employees as $employee)
                                        <option value="{{ $employee->nik }}" @if ($employee->nik == $item->nik) selected
                                            @endif>
                                            {{ $employee->fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-4 my-auto">
                                    <label for="devices{{ $item->troubleID }}" class="form-label">Sistem yang
                                        bermasalah<p class="d-inline fw-bold">*</p></label>
                                </div>
                                <div class="col-8 my-auto">
                                    <input type="text" class="form-control form-control"
                                        id="devices{{ $item->troubleID }}" placeholder="Sistem yang bermasalah"
                                        name="devices" autocomplete="off" required value="{{ $item->devices }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 my-auto">
                                    <label for="trouble{{ $item->troubleID }}" class="form-label">Permasalahan<p
                                            class="d-inline fw-bold">*
                                        </p></label>
                                </div>
                                <div class="col-8">
                                    <textarea name="trouble" id="trouble{{ $item->troubleID }}"
                                        class="form-control w-100" cols="" rows="3" placeholder="Masukkan Permasalahan"
                                        required>{{ $item->trouble }}</textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4 my-auto">
                                    <label for="action{{ $item->troubleID }}" class="form-label">Tindakan</label>
                                </div>
                                <div class="col-8">
                                    <textarea name="action" id="action{{ $item->troubleID }}" class="form-control w-100"
                                        cols="" rows="3" placeholder="Masukkan Tindakan">{{ $item->action }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row mt-2">
                                <div class="col-4">
                                    <label for="foto{{ $item->troubleID }}" class="form-label">Gambar Pendukung</label>
                                </div>
                                <div class="col-8">
                                    @livewire('upload-photo', ['savedPhotoPath' => $item->photo])
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