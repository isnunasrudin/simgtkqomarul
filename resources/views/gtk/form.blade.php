
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@csrf
<div class="row" x-data="{
    type: '{{ old('type', data_get($gtk ?? null, 'type', 'GURU')) }}', 
    has_secondary_job: {{ old('has_secondary_job', data_get($gtk ?? null, 'tugas_tambahan_id', false)) ? 'true' : 'false' }} 
}">
    <div class="col-md-6">
        <div class="form-group">
            <label for="type">Jenis Kepegawaian<sup style="color: red;">*</sup></label>
            <select class="form-control" id="type" name="type" required x-model="type">
                <option value="GURU">Guru</option>
                <option value="TU">Tenaga Kependidikan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Nama Lengkap<sup style="color: red;">*</sup></label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', data_get($gtk ?? null, 'name')) }}">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birth_place">Tempat Lahir<sup style="color: red;">*</sup></label>
                    <input type="text" class="form-control" id="birth_place" name="birth_place" required value="{{ old('birth_place', data_get($gtk ?? null, 'birth_place')) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-group">
                        <input type="text" class="form-control is-datepicker" name="birth_date" required value="{{ old('birth_date', data_get($gtk ?? null, 'birth_date')) }}">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-calendar-check"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="gender">Jenis Kelamin<sup style="color: red;">*</sup></label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="L" @selected(old('gender', data_get($gtk ?? null, 'gender')) == 'L')>Laki-laki</option>
                <option value="P" @selected(old('gender', data_get($gtk ?? null, 'gender')) == 'P')>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="kawin">Status Perkawinan<sup style="color: red;">*</sup></label>
            <select class="form-control" id="kawin" name="kawin" required>
                <option value="Belum Kawin" @selected(old('kawin', data_get($gtk ?? null, 'kawin')) == 'Belum Kawin')>Belum Kawin</option>
                <option value="Kawin" @selected(old('kawin', data_get($gtk ?? null, 'kawin')) == 'Kawin')>Kawin</option>
                <option value="Cerai" @selected(old('kawin', data_get($gtk ?? null, 'kawin')) == 'Cerai')>Cerai</option>
                <option value="Cerai Mati" @selected(old('kawin', data_get($gtk ?? null, 'kawin')) == 'Cerai Mati')>Cerai Mati</option>
            </select>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="rt">Rt<sup style="color: red;">*</sup></label>
                    <input type="text" class="form-control" id="rt" name="rt" required value="{{ old('rt', data_get($gtk ?? null, 'rt')) }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="rw">Rw<sup style="color: red;">*</sup></label>
                    <input type="text" class="form-control" id="rw" name="rw" required value="{{ old('rw', data_get($gtk ?? null, 'rw')) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dusun">Dusun<sup style="color: red;">*</sup></label>
                    <input type="text" class="form-control" id="dusun" name="dusun" required value="{{ old('dusun', data_get($gtk ?? null, 'dusun')) }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="desa">Desa<sup style="color: red;">*</sup></label>
                    <input type="text" class="form-control" id="desa" name="desa" required value="{{ old('desa', data_get($gtk ?? null, 'desa')) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kecamatan">Kecamatan<sup style="color: red;">*</sup></label>
                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" required value="{{ old('kecamatan', data_get($gtk ?? null, 'kecamatan')) }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kabupaten">Kabupaten<sup style="color: red;">*</sup></label>
                    <input type="text" class="form-control" id="kabupaten" name="kabupaten" required value="{{ old('kabupaten', data_get($gtk ?? null, 'kabupaten')) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="provinsi">Provinsi<sup style="color: red;">*</sup></label>
                    <input type="text" class="form-control" id="provinsi" name="provinsi" required value="{{ old('provinsi', data_get($gtk ?? null, 'provinsi')) }}">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="satuan_kerja_id">Satuan Kerja<sup style="color: red;">*</sup></label>
            <select class="form-control" id="satuan_kerja_id" name="satuan_kerja_id" required>
                @foreach (\App\Models\SatuanKerja::orderBy('code')->get() as $item)
                    <option value="{{ $item->id }}" @selected(old('satuan_kerja_id', data_get($gtk ?? null, 'satuan_kerja_id')) == $item->id)>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <template x-if="type === 'GURU'">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mapel">Mengajar<sup style="color: red;">*</sup></label>
                        <input type="text" class="form-control" id="mapel" name="mapel" value="{{ old('mapel', data_get($gtk ?? null, 'mapel')) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mapel_point">Jam Pembelajaran<sup style="color: red;">*</sup></label>
                        <input type="number" class="form-control" id="mapel_point" name="mapel_point" value="{{ old('mapel_point', data_get($gtk ?? null, 'mapel_point')) }}">
                    </div>
                </div>
            </div>
        </template>
        <template x-if="type === 'GURU'">
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" value="" x-model="has_secondary_job">
                    <span class="form-check-sign">Memiliki Tugas Tambahan</span>
                </label>
            </div>
        </template>
        <template x-if="has_secondary_job || type === 'TU'">
            <div class="form-group">
                <label for="tugas_tambahan_id">Tugas <span x-text="type === 'TU' ? 'Pokok' : 'Tambahan'"></span><sup style="color: red;">*</sup></label>
                <select class="form-control" id="tugas_tambahan_id" name="tugas_tambahan_id" required>
                    <option value="">Tidak Ada</option>
                    @foreach (\App\Models\Ref\TugasTambahan::all() as $item)
                        <option value="{{ $item->id }}" @selected(old('tugas_tambahan_id', data_get($gtk ?? null, 'tugas_tambahan_id')) == $item->id)>{{ $item->name }}</option>
                    @endforeach
                    </select>
                </div>
        </template>
        <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', data_get($gtk ?? null, 'nik')) }}">
        </div>
        <div class="form-group">
            <label for="nuptk">NUPTK</label>
            <input type="text" class="form-control" id="nuptk" name="nuptk" value="{{ old('nuptk', data_get($gtk ?? null, 'nuptk')) }}">
        </div>
        <div class="form-group">
            <label for="nigy">NIGY</label>
            <input type="text" class="form-control" id="nigy" name="nigy" value="{{ old('nigy', data_get($gtk ?? null, 'nigy')) }}">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tmt_yayasan">TMT Yayasan <sup style="color: red;">*</sup></label>
                    <input type="text" class="form-control is-datepicker" id="tmt_yayasan" name="tmt_yayasan" value="{{ old('tmt_yayasan', data_get($gtk ?? null, 'tmt_yayasan')) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tmt_satker">TMT Satuan Kerja <sup style="color: red;">*</sup></label>
                    <input type="text" class="form-control is-datepicker" id="tmt_satker" name="tmt_satker" value="{{ old('tmt_satker', data_get($gtk ?? null, 'tmt_satker')) }}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="photo">Foto</label>
            <input type="file" class="form-control" id="photo" name="photo">
            @if(data_get($gtk ?? null, 'photo'))
                <img src="{{ \Storage::url(data_get($gtk ?? null, 'photo')) }}" alt="" class="img-thumbnail mt-2" style="width: 100px;">
            @endif
        </div>
    </div>
</div>



@push('footer')
<script src="//unpkg.com/alpinejs" defer></script>
    <script>
    	$('.is-datepicker').datetimepicker({
            format: "YYYY-MM-DD"
        });
    </script>
@endpush