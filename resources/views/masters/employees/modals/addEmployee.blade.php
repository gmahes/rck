<!-- Modal -->
<div class="modal fade" id="addEmployee" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-dark fw-bold fs-5" id="staticBackdropLabel">
                    Tambah Data
                    Karyawan
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-start text-dark">
                <form action="{{ route('add-employee') }}" method="POST" autocomplete="off">
                    @csrf
                    @if (Auth::user()->role == 'administrator')
                    <input type="hidden" name="role" value="user">
                    @endif
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="username" class="form-label">Username</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="username"
                                    placeholder="Masukkan Username" name="username" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="nik" class="form-label">NIK</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="nik"
                                    placeholder="Masukkan NIK" name="nik" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="fullname" class="form-label">Nama
                                    Lengkap</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="fullname"
                                    placeholder="Masukkan Nama Lengkap" name="fullname" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="position" class="form-label">Jabatan</label>
                            </div>
                            <div class="col-8">
                                <select name="position" id="position" class="selectpicker form-control form-control-sm"
                                    data-width="100%" aria-label="position" data-live-search="true" data-size="3"
                                    required>
                                    <option value="" selected disabled>Pilih Jabatan</option>
                                    @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">
                                        {{ $position->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->role == 'superadmin')
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="role" class="form-label">Role</label>
                            </div>
                            <div class="col-8">
                                <select class="selectpicker form-control form-control-sm" aria-label="role" name="role"
                                    required>
                                    <option value="" selected disabled>Pilih Role</option>
                                    @foreach ($role_list as $role)
                                    <option value="{{ $role }}">{{ $role }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif
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