<form action="{{ route('employee.update_kontak') }}" onsubmit="return validate()" method="POST">
    @csrf
    <div class="row">
        <input type="hidden" name="id" id="id" value="{{ $id }}">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Nama <code>*</code></label>
                <input type="text" class="form-control" id="edit_nama_kontak" name="edit_nama_kontak"
                    value="{{ $item->nama }}" autofocus placeholder="Nama">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">No HP <code>*</code></label>
                <input type="number" class="form-control" id="edit_no_hp_kontak" name="edit_no_hp_kontak"
                    value="{{ $item->no_hp }}" placeholder="No HP">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Keterangan <code>*</code></label>
                <textarea class="form-control" id="edit_keterangan_kontak" name="edit_keterangan_kontak" placeholder="Keterangan"
                    rows="3">{{ $item->keterangan }}</textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="">Tipe</label>
                <select name="tipe" id="tipe" class="form-control select select2" id="select2" required>
                    <option value="">-- Pilih Tipe --</option>
                    @foreach ($results as $result)
                        @if ($result == $item->tipe)
                            <option value="{{ $result }}" selected>{{ $result }}</option>
                        @else
                            <option value="{{ $result }}">{{ $result }}</option>
                        @endif
                    @endforeach
                </select>
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
        var edit_nama_kontak = document.getElementById("edit_nama_kontak").value;
        var edit_no_hp_kontak = document.getElementById("edit_no_hp_kontak").value;
        var edit_keterangan_kontak = document.getElementById("edit_keterangan_kontak").value;

        console.log(edit_keterangan_kontak);
        if (edit_nama_kontak === '' || edit_no_hp_kontak === '' || edit_keterangan_kontak === '') {
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

{{-- <link href="{{ URL::asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
    type="text/css" /> --}}
