<form action="{{ route('employee.update_riwayat') }}" onsubmit="return validate()" method="POST">
    @csrf
    <div class="row">
        <input type="hidden" name="id" id="id" value="{{ $id }}">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Penyakit <code>*</code></label>
                <input type="text" class="form-control" id="edit_penyakit" name="edit_penyakit"
                    value="{{ $item->penyakit }}" autofocus placeholder="Penyakit">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Keterangan <code>*</code></label>
                <textarea class="form-control" id="edit_keterangan" name="edit_keterangan" placeholder="Keterangan" rows="3">{{ $item->keterangan }}</textarea>
            </div>
        </div>
    </div>
    <div class="row modal-footer">
        <div class="row">
            <div class="col-sm-6">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end mt-2 mt-sm-0">
                    <button class="btn btn-primary" type="submit" id="save">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    function validate() {
        var ok = true;
        var edit_penyakit = document.getElementById("edit_penyakit").value;
        var edit_keterangan = document.getElementById("edit_keterangan").value;
        if (edit_penyakit === '' || edit_keterangan === '') {
            Swal.fire(
                'Gagal',
                'Tanda * (bintang) wajib diisi',
                'error'
            )
            ok = false;
        }
        return ok;
    }
</script>
