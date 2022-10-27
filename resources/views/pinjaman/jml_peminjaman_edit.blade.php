<form action="{{ route('pinjaman.update_jml', $id) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-10">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Buku <code>*</code></label>
                <input type="text" class="form-control" id="judul" name="judul" disabled
                    value="{{ $item->buku->kategori->kode_kategori . ' - ' . $item->buku->judul }}" placeholder="Buku">
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Jumlah Buku <code>*</code></label>
                <input type="number" min="0" class="form-control number-only" id="jml" name="jml"
                    value="{{ $item->jml }}" placeholder="Jumlah Buku">
            </div>
        </div>
    </div>
    <div class="row" hidden>
        <input type="text" min="0" class="form-control number-only" id="buku_id" name="buku_id"
            value="{{ $item->buku_id }}" placeholder="buku_id">
        <input type="text" min="0" class="form-control number-only" id="jml_old" name="jml_old"
            value="{{ $item->jml }}" placeholder="Jumlah Buku">
    </div>
    <div class="row modal-footer">
        <div class="col-sm-12">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" style="float: right" id="save">Simpan</button>
        </div>
    </div>
</form>
