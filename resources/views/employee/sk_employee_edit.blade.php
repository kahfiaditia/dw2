<form action="{{ route('employee.update_sk') }}" enctype="multipart/form-data" onsubmit="return validate()" method="POST">
    @csrf
    <div class="row">
        <input type="hidden" name="id" id="id" value="{{ $id }}">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">No SK <code>*</code></label>
                <input type="text" class="form-control" id="edit_no_sk" name="edit_no_sk" value="{{ $item->no_sk }}"  autofocus
                    placeholder="No SK">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-4">
                <label>Tanggal SK <code>*</code></label>
                <div class="input-group" id="datepicker2">
                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="edit_tgl_sk" name="edit_tgl_sk" value="{{ $item->tgl_sk }}"
                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker"
                        data-date-autoclose="true" >
                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Jabatan <code>*</code></label>
                <input type="text" class="form-control" id="edit_jabatan" name="edit_jabatan" value="{{ $item->jabatan }}"
                    placeholder="Jabatan">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <input type="hidden" name="dok_sk_old" id="dok_sk_old" value="{{ $item->dok_sk }}">
                <label for="formFile" class="form-label">Dokumen SK</label>
                <input class="form-control edit_dok_sk" type="file" name="edit_dok_sk" id="edit_dok_sk" >
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
        var edit_no_sk = document.getElementById("edit_no_sk").value;
        var edit_tgl_sk = document.getElementById("edit_tgl_sk").value;
        var edit_jabatan = document.getElementById("edit_jabatan").value;
        var edit_dok_sk = document.getElementById("edit_dok_sk").value;
        var dok_sk_old = document.getElementById("dok_sk_old").value;
        if(edit_no_sk === '' || edit_tgl_sk === '' || edit_jabatan === '' || (dok_sk_old === '' && edit_dok_sk === '')){
            Swal.fire(
                'Gagal',
                'Tanda * (bintang) wajib diisi',
                'error'
            )
            ok = false;
        }
        return ok;
    }
    $(document).ready(function() {
        $('#edit_dok_sk').bind('change', function() {
            var file = document.querySelector("#edit_dok_sk");
            if (/\.(jpe?g|png|jpg)$/i.test(file.files[0].name) === false) {
                Swal.fire(
                    'Gagal',
                    'Tipe dokumen yang diperbolehkan jpeg, png ,jpg',
                    'error'
                ).then(function() {})
                document.getElementById('dok_sk').value = null;
            } else {
                var size = this.files[0].size / 1000;
                if (size > 2000) {
                    Swal.fire(
                        'Gagal',
                        'Maksimal ukuran 2 MB',
                        'error'
                    ).then(function() {})
                    document.getElementById('dok_sk').value = null;
                }
            }
        });
    });
</script>
