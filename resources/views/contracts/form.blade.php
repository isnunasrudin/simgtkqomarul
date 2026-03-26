@csrf
<div class="row" x-data="{ select_by: 'satker' }">
    <div class="col-md-6">
        <div class="form-group">
            <label for="year">Tahun <sup style="color: red;">*</sup></label>
            <input type="number" class="form-control" id="year" name="year" required value="{{ old('year', $contract->year ?? date('Y')) }}">
        </div>
        <div class="form-group">
            <label for="issued_date">Tanggal SK <sup style="color: red;">*</sup></label>
            <input type="date" class="form-control is-datepicker" id="issued_date" name="issued_date" required value="{{ old('issued_date', $contract->issued_date ?? date('Y-m-d')) }}">
        </div>
        <div class="form-group">
            <label for="effective_date">TMT <sup style="color: red;">*</sup></label>
            <input type="date" class="form-control is-datepicker" id="effective_date" name="effective_date" required value="{{ old('effective_date', $contract->effective_date ?? date('Y-m-d')) }}">
        </div>
        <div class="form-group">
            <label for="expired_date">Tanggal Selesai</label>
            <input type="date" class="form-control is-datepicker" id="expired_date" name="expired_date" value="{{ old('expired_date', $contract->expired_date ?? '') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">Pilih Berdasarkan</label>
            <div class="selectgroup w-100">
                <label class="selectgroup-item">
                    <input type="radio" name="select_by" value="gtk" class="selectgroup-input" checked="" x-model="select_by">
                    <span class="selectgroup-button">GTK</span>
                </label>
                <label class="selectgroup-item">
                    <input type="radio" name="select_by" value="satker" class="selectgroup-input" x-model="select_by">
                    <span class="selectgroup-button">Satker</span>
                </label>
            </div>
        </div>

        <div class="form-group" x-show="select_by == 'gtk'">
            <label for="gtk_ids" class="mb-0">GTK <sup style="color: red;">*</sup></label>
            <div class="mb-2">
                <a href="#" x-on:click="selectAllGtk($event)" class="btn btn-primary btn-sm mt-2 py-1 px-2">Pilih Semua GTK</a>
                <a href="#" x-on:click="deselectAllGtk($event)" class="btn btn-danger ml-2 btn-sm mt-2 py-1 px-2">Deselect Semua GTK</a>
            </div>
            <select name="gtk_ids[]" id="gtk_ids" class="select2-input" multiple>
                @foreach ($gtks as $name => $gtk)
                <optgroup label="{{ $name }}">
                    @foreach ($gtk as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </optgroup>
                @endforeach
            </select>
        </div>

        <div class="form-group" x-show="select_by == 'satker'">
            <label for="satker_ids" class="mb-0">Satker <sup style="color: red;">*</sup></label>
            <div class="mb-2">
                <a href="#" x-on:click="selectAllSatker($event)" class="btn btn-primary btn-sm mt-2 py-1 px-2">Pilih Semua Satker</a>
                <a href="#" x-on:click="deselectAllSatker($event)" class="btn btn-danger ml-2 btn-sm mt-2 py-1 px-2">Deselect Semua Satker</a>
            </div>
            <select name="satker_ids[]" id="satker_ids" class="select2-input" multiple>
                @foreach ($satker as $s)
                    <option value="{{ $s->id }}" selected="selected">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>



    </div>
</div>