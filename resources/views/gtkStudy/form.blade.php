@csrf
@csrf
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label for="level">Tingkat<sup style="color: red;">*</sup></label>
            <select class="form-control" id="level" name="level" required>
                <option value="SD" @selected(old('level', data_get($gtk ?? null, 'level')) == 'SD')>SD/MI</option>
                <option value="SMP" @selected(old('level', data_get($gtk ?? null, 'level')) == 'SMP')>SMP/MTs</option>
                <option value="SMA" @selected(old('level', data_get($gtk ?? null, 'level')) == 'SMA')>SMA/SMK/MA</option>
                <option value="D1" @selected(old('level', data_get($gtk ?? null, 'level')) == 'D1')>D1</option>
                <option value="D2" @selected(old('level', data_get($gtk ?? null, 'level')) == 'D2')>D2</option>
                <option value="D3" @selected(old('level', data_get($gtk ?? null, 'level')) == 'D3')>D3</option>
                <option value="D4" @selected(old('level', data_get($gtk ?? null, 'level')) == 'D4')>D4</option>
                <option value="S1" @selected(old('level', data_get($gtk ?? null, 'level')) == 'S1')>S1</option>
                <option value="S2" @selected(old('level', data_get($gtk ?? null, 'level')) == 'S2')>S2</option>
                <option value="S3" @selected(old('level', data_get($gtk ?? null, 'level')) == 'S3')>S3</option>
            </select>
        </div>

        <div class="form-group">
            <label for="institution">Nama Sekolah/Institusi<sup style="color: red;">*</sup></label>
            <input type="text" class="form-control" id="institution" name="institution" required value="{{ old('institution', data_get($gtk ?? null, 'institution')) }}">
        </div>

        <div class="form-group">
            <label for="major">Jurusan</label>
            <input type="text" class="form-control" id="major" name="major" value="{{ old('major', data_get($gtk ?? null, 'major')) }}">
        </div>

        <div class="form-group">
            <label for="graduation_year">Tahun Lulus<sup style="color: red;">*</sup></label>
            <input type="text" class="form-control" id="graduation_year" name="graduation_year" required value="{{ old('graduation_year', data_get($gtk ?? null, 'graduation_year')) }}">
        </div>

        <div class="form-group">
            <label for="certificate_number">No. Ijazah<sup style="color: red;">*</sup></label>
            <input type="text" class="form-control" id="certificate_number" name="certificate_number" required value="{{ old('certificate_number', data_get($gtk ?? null, 'certificate_number')) }}">
        </div>

        
        <div class="form-group">
            <label for="file">Scan Ijazah <sup style="color: red;">*</sup></label>
            <input type="file" class="form-control-file" id="file" name="file" required accept=".pdf,image/*">
        </div>
    </div>
</div>



@push('footer')
    <script>
    	$('.is-datepicker').datetimepicker({
            format: "YYYY-MM-DD"
        });
    </script>
@endpush