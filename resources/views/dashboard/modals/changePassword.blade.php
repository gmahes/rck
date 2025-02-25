<!-- Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Ganti Password</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('change-password', Auth::user()->getAuthIdentifier()) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="password1" class="form-label">Password Saat Ini</label>
                            </div>
                            <div class="col-8">
                                <input type="password" class="form-control form-control-sm" id="password1"
                                    placeholder="Masukkan Password Saat Ini" name="oldpassword" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <label for="password2" class="form-label">Password Baru</label>
                            </div>
                            <div class="col-8">
                                <input type="password" class="form-control form-control-sm" id="password2"
                                    placeholder="Masukkan Password Baru" name="newpassword" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                {{-- <label for="password2" class="form-label">Password Baru</label> --}}
                            </div>
                            <div class="col-8">
                                <input type="password" class="form-control form-control-sm" id="password3"
                                    placeholder="Masukkan Lagi Password Baru" name="newpassword1" required>
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