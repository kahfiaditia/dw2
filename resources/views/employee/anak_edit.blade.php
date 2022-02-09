<form action="{{ route('employee.update_anak') }}" onsubmit="return validate()" method="POST">
    @csrf
    <div class="row">
        <input type="hidden" name="id" id="id" value="{{ $id }}">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Anak Ke <code>*</code></label>
                <input type="number" min="0" class="form-control" id="edit_anak_ke" name="edit_anak_ke" value="{{ $item->anak_ke }}"  autofocus
                    placeholder="Anak Ke">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Nama <code>*</code></label>
                <input type="text" class="form-control" id="edit_nama" name="edit_nama" value="{{ $item->nama }}"  autofocus
                    placeholder="Nama">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Usia <code>*</code></label>
                <input type="number" min="0" class="form-control" id="edit_usia" name="edit_usia" value="{{ $item->usia }}"  autofocus
                    placeholder="Usia">
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
<script type = "text/javascript">
    function validate() {
        var ok = true;
        var edit_anak_ke = document.getElementById("edit_anak_ke").value;
        var edit_nama = document.getElementById("edit_nama").value;
        var edit_usia = document.getElementById("edit_usia").value;
        if(edit_anak_ke === '' || edit_nama === '' || edit_usia === ''){
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
