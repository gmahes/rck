<!-- Modal -->
<div class="modal fade" id="deleteSupplier{{ $supplier->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Hapus Pelanggan</strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('del-supplier',$supplier->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="row text-center">
                        <p class="text-dark modal-title">Apakah anda yakin akan menghapus data <br> <strong>{{
                                $supplier->name }}</strong> ?
                        </p>
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