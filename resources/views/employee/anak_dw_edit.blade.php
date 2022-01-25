<form action="{{ route('employee.update_anak_dw') }}" method="POST">
    @csrf
    <div class="row">
        <input type="hidden" name="id" id="id" value="{{ $id }}">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom01" class="form-label">Anak Karyawan <code>*</code></label>
                <select class="form-control select select2" name="edit_anak_id" id="edit_anak_id" >
                    @foreach ($child as $anak)
                    <option value="{{ $anak->id }}" {{ $anak->id === $item->anak_id ? 'selected' : '' }}>{{ $anak->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom01" class="form-label">Jenjang <code>*</code></label>
                <select class="form-control select select2" name="edit_jenjang" id="edit_jenjang" >
                    <option value="KB" {{ $item->jenjang === 'KB' ? 'selected' : '' }}>KB</option>
                    <option value="TK" {{ $item->jenjang === 'TK' ? 'selected' : '' }}>TK</option>
                    <option value="SD" {{ $item->jenjang === 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ $item->jenjang === 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMK" {{ $item->jenjang === 'SMK' ? 'selected' : '' }}>SMK</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
            <div class="text-sm-end mt-2 mt-sm-0">
                <button class="btn btn-primary" type="submit" id="save">Simpan</button>
            </div>
        </div>
    </div>
</form>
