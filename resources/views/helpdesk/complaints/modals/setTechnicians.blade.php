<!-- Modal -->
<div class="modal fade" id="setTechnicians{{ $item->troubleID }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Pilih Teknisi</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('confirm-complaint') }}" method="POST">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="troubleID" value="{{ $item->troubleID }}">
                    <div class="row">
                        <div class="col">
                            <label for="technician{{ $item->troubleID }}" class="form-label">Pilih Teknisi</label>
                            <select name="technician" id="technician{{ $item->troubleID }}"
                                class="selectpicker form-control form-control-sm" data-width="100%"
                                aria-label="technician" data-live-search="true" data-size="3" required>
                                <option value="" selected disabled>Pilih Teknisi</option>
                                @foreach ($technicians as $technician)
                                <option value="{{ $technician->nik }}">{{ $technician->fullname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row text-center mt-3">
                        <div class="col">
                            <button type="submit" class="btn btn-primary px-3">Ya</button>
                            <button type="button" class="btn btn-secondary px-2" data-bs-dismiss="modal">Tidak</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>