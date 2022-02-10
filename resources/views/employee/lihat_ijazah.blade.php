<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Nama Sekolah/Universitas <code>*</code></label>
                <input type="text" class="form-control" id="nama_pendidikan" name="nama_pendidikan" value="{{ $item->nama_pendidikan }}" disabled autofocus
                    placeholder="Nama Sekolah/Universitas">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Gelar <code>*</code></label>
                <select class="form-control select select2" name="gelar_ijazah" id="gelar_ijazah" disabled>
                    <option value="">--Pilih Gelar--</option>
                    @foreach ($jurusan as $jurusan)
                        <option value="{{ $jurusan }}" {{ $item->gelar_ijazah === $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Jurusan <code>*</code></label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ $item->instansi }}" disabled
                    placeholder="Jurusan">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label>Tahun Pendidikan <code>*</code></label>
                <div class="input-daterange input-group">
                    <input type="text" class="form-control datepicker" name="tahun_masuk" value="{{ $item->tahun_masuk }}" placeholder="Tahun Masuk" id="tahun_masuk" disabled>
                    <input type="text" class="form-control datepicker" name="tahun_lulus" value="{{ $item->tahun_lulus }}" placeholder="Tahun Lulus" id="tahun_lulus" disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Gelar Akademik Panjang</label>
                <input type="text" class="form-control" id="gelar_akademik_panjang" name="gelar_akademik_panjang" value="{{ $item->gelar_akademik_panjang }}" disabled
                    placeholder="Gelar Akademik Panjang">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Gelar Akademik Pendek</label>
                <input type="text" class="form-control" id="gelar_akademik_pendek" name="gelar_akademik_pendek" value="{{ $item->gelar_akademik_pendek }}" disabled
                    placeholder="Gelar Akademik Pendek">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Gelar Non Akademik Panjang</label>
                <input type="text" class="form-control" id="gelar_non_akademik_panjang" name="gelar_non_akademik_panjang" value="{{ $item->gelar_non_akademik_panjang }}" disabled
                    placeholder="Gelar Non Akademik Panjang">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Gelar Non Akademik Pendek</label>
                <input type="text" class="form-control" id="gelar_non_akademik_pendek" name="gelar_non_akademik_pendek" value="{{ old('gelar_non_akademik_pendek') }}" disabled
                    placeholder="Gelar Non Akademik Pendek">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="validationCustom02" class="form-label">Nama Instansi/Lembaga Penerbit Sertifikat</label>
                <input type="text" class="form-control" id="instansi" name="instansi" value="{{ $item->instansi }}" disabled autofocus
                    placeholder="Nama Instansi/Lembaga Penerbit Sertifikat">
            </div>
        </div>
    </div>
</div>