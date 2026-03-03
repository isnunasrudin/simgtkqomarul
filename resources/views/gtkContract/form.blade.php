@csrf
<div x-data="{ type: '{{ old('type', $contract->type ?? ($gtk->type ?? 'GURU')) }}', has_secondary_job: {{ old('secondary_job', $contract->secondary_job ?? null) ? 'true' : 'false' }} }" class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="reference_number">Nomor SK <sup style="color: red;">*</sup></label>
            <input type="text" class="form-control" id="reference_number" name="reference_number" required value="{{ old('reference_number', $contract->reference_number ?? '') }}">
        </div>
        <div class="form-group">
            <label for="issued_date">Tanggal SK <sup style="color: red;">*</sup></label>
            <input type="date" class="form-control" id="issued_date" name="issued_date" required value="{{ old('issued_date', $contract->issued_date ?? '') }}">
        </div>
        <div class="form-group">
            <label for="effective_date">TMT <sup style="color: red;">*</sup></label>
            <input type="date" class="form-control" id="effective_date" name="effective_date" required value="{{ old('effective_date', $contract->effective_date ?? '') }}">
        </div>
        <div class="form-group">
            <label for="expired_date">Tanggal Selesai</label>
            <input type="date" class="form-control" id="expired_date" name="expired_date" value="{{ old('expired_date', $contract->expired_date ?? '') }}">
        </div>

        <div class="form-group">
            <label for="file">File SK</label>
            <input type="file" class="form-control" id="file" name="file">
        </div>
    </div>
    <div class="col-md-6">

    <div class="form-group">
        <label for="type">Jenis <sup style="color: red;">*</sup></label>
        <select class="form-control" id="type" x-model="type" name="type" required>
            <option value="GURU">Guru</option>
            <option value="TU">Tenaga Kependidikan</option>
        </select>
    </div>

    <template x-if="type === 'GURU'">
        <div>
            <div class="form-group">
                <label for="mapel">Mata Pelajaran <sup style="color: red;">*</sup></label>
                <input type="text" class="form-control" id="mapel" name="mapel" required value="{{ old('mapel', $contract->mapel ?? '') }}">
            </div>
            <div class="form-group">
                <label for="mapel_point">Jam Mengajar <sup style="color: red;">*</sup></label>
                <input type="number" class="form-control" id="mapel_point" name="mapel_point" required value="{{ old('mapel_point', $contract->mapel_point ?? '') }}">
            </div>
        </div>
    </template>

    <div class="form-check">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" value="" x-model="has_secondary_job">
            <span class="form-check-sign">Memiliki Tugas Tambahan</span>
        </label>
    </div>

    <template x-if="has_secondary_job">
        @if($isEdit)
        <div>
            <div class="form-group">
                <label for="secondary_job">Tugas Tambahan <sup style="color: red;">*</sup></label>
                <input type="text" class="form-control" id="secondary_job" name="secondary_job" required value="{{ old('secondary_job', $contract->secondary_job ?? '') }}">
            </div>
            <div class="form-group">
                <label for="secondary_job_point">Equivalen Jam Pembelajaran <sup style="color: red;">*</sup></label>
                <input type="number" class="form-control" id="secondary_job_point" name="secondary_job_point" required value="{{ old('secondary_job_point', $contract->secondary_job_point ?? '') }}">
            </div>
        </div>
        @else
        <div class="form-group">
            <label for="secondary_job_id">Tugas Tambahan <sup style="color: red;">*</sup></label>
            <select name="secondary_job_id" id="secondary_job_id" class="form-control">
                @foreach (\App\Models\Ref\TugasTambahan::all() as $job)
                    <option value="{{ $job->id }}">{{ $job->name }}</option>
                @endforeach
            </select>
        </div>
        @endif
    </template>

    </div>
</div>

@push('footer')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush