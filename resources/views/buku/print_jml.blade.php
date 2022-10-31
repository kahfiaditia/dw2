<form action="{{ route('buku.print_barcode') }}" method="POST" target="_blank">
    @csrf
    <div class="row">
        <input type="hidden" name="id" id="id" value="{{ $id }}">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Judul <code>*</code></label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ $item->judul }}"
                    readonly placeholder="Judul">
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-4">
                <label>Jumlah Print <code>*</code></label>
                <div class="input-group">
                    <input name="jml" id="jml" type="number" class="form-control" onkeyup="myFunction()"
                        value="{{ $item->jml_buku }}" placeholder="Jumlah Print">
                    <span class="input-group-text"><i class="mdi mdi-printer"></i><i class="mdi mdi-barcode"></i></span>
                    <input name="jml_max" id="jml_max" type="hidden" class="form-control"
                        value="{{ $item->jml_buku }}" placeholder="Jumlah Print">
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="row modal-footer">
        <div class="col-sm-12">
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" style="float: right" id="save">Print</button>
        </div>
    </div>
</form>
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script>
    function myFunction() {
        var jml = document.getElementById("jml").value;
        var jml_max = document.getElementById("jml_max").value;
        if (jml > jml_max) {
            Swal.fire(
                'Gagal',
                'Print melebihi dari Jumlah Buku',
                'error'
            )
            document.getElementById("jml").value = jml_max;
        }
    }
    $(document).ready(function() {
        $("#jml").change(function() {
            let jml = $(this).val();
            var jml_max = document.getElementById("jml_max").value;
            if (jml > jml_max) {
                Swal.fire(
                    'Gagal',
                    'Print melebihi dari Jumlah Buku',
                    'error'
                )
                document.getElementById("jml").value = jml_max;
            }
        });
    });
</script>
