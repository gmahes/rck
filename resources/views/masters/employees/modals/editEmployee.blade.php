<!-- Modal -->
<div class="modal fade" id="editData{{ $employee->username }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Edit Data Karyawan</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit-employee', $employee->username) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editusername{{ $employee->username }}" class="form-label">Username</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm"
                                    id="editusername{{ $employee->username }}" placeholder="Masukkan Username"
                                    name="username" value="{{ $employee->username }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editnik{{ $employee->username }}" class="form-label">NIK</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm"
                                    id="editnik{{ $employee->username }}" placeholder="Masukkan NIK" name="nik"
                                    value="{{ $employee->nik }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editfullname{{ $employee->username }}" class="form-label">Nama
                                    Lengkap</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm"
                                    id="editfullname{{ $employee->username }}" placeholder="Masukkan Nama Lengkap"
                                    name="fullname" value="{{ $employee->fullname }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editposition{{ $employee->username }}" class="form-label">Jabatan</label>
                            </div>
                            <div class="col-8">
                                <select name="position" id="editposition{{ $employee->username }}"
                                    class="selectpicker form-control form-control-sm" data-live-search="true"
                                    data-width="100%" data-size="3" required>
                                    @foreach ($positions as $position)
                                    <option value="{{ $position->id }}" @if ($position->id==$employee->position_id)
                                        selected @endif>{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->role == 'superadmin')
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="editrole{{ $employee->username }}" class="form-label">Role</label>
                            </div>
                            <div class="col-8">
                                <select class="selectpicker form-control form-control-sm"
                                    aria-label="editrole{{ $employee->username }}" name="role" required>
                                    @foreach ($role_list as $role)
                                    <option value="{{ $role }}" @if ($role==$employee->userAuth->role) selected
                                        @endif>{{ $role }}</option>
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