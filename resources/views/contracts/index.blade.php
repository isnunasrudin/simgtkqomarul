@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data SK</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('/') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('contracts.index') }}">Data SK</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Data SK</h4>
                        
                        <button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#createMassalSK">
                            <i class="fas fa-plus"></i>
                            Buat Surat Keputusan (SK)
                        </button>
                        <div class="modal fade" id="createMassalSK" tabindex="-1" role="dialog" aria-labelledby="createMassalSKLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document" style="max-width: 800px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createMassalSKLabel">Buat SK Massal</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('contracts.generate-batch') }}" method="POST" enctype="multipart/form-data" id="form-create-massal-sk">
                                            @include('contracts.form')
                                            <div class="d-flex justify-content-end mt-3">
                                                <button type="submit" class="btn btn-primary d-inline-block">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <label for="year">Tahun</label>
                    <form action="{{ route('contracts.index') }}" method="GET" class="d-flex align-items-center mb-3">
                        <div class="form-group">
                            <select name="year" id="year" class="form-control">
                                @foreach ($years as $year)
                                <option value="{{ $year }}" {{ request()->input('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                    </form>
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No. SK</th>
                                    <th>Tugas Tambahan</th>
                                    <th>Beban Kerja</th>
                                    <th>Draf</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contracts as $contract)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($contract->gtk->photo)
                                            <img src="{{ \Storage::url($contract->gtk->photo) }}" alt="" class="img-thumbnail mr-2" style="width: 50px; height: 50px;">
                                            @endif
                                            <div>
                                                <h4 class="mb-0 font-weight-bold text-primary">{{ $contract->gtk->name }}</h4>
                                                <span><small>{{ $contract->type == 'TU' ? 'Tenaga Kependidikan' : ('Guru ' . $contract->mapel) }}</small></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold">{{ $contract->reference_number ?? '-' }}</span>
                                        <br>
                                        <small>{{ \Carbon\Carbon::parse($contract->issued_date)->format('d F Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold">{{ $contract->secondary_job ?? '-' }}</span>
                                    </td>
                                    <td>
                                        {{ (int) $contract->secondary_job_point + (int) $contract->mapel_point }}
                                    </td>
                                    <td>
                                        @if($contract->file_draft)
                                        <a href="{{ \Storage::disk('public')->url($contract->file_draft) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        @endif

                                        @if($contract->file_draft)
                                        <button type="button" data-toggle="modal" data-target="#generateModal{{ $contract->id }}" class="btn {{ $contract->file_draft ? 'btn-outline-primary' : 'btn-primary' }} btn-sm">Generate</button>
                                        <div class="modal fade" id="generateModal{{ $contract->id }}" tabindex="-1" role="dialog" aria-labelledby="generateModalLabel{{ $contract->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="generateModalLabel{{ $contract->id }}">Generate Kontrak</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin mengenerate kontrak ini? <br>
                                                            <small class="text-danger">Data sebelumnya akan dihapus.</small>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <a href="{{ route('contracts.generate', $contract) }}" class="btn btn-primary">Generate</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <a href="{{ route('contracts.generate', $contract) }}" class="btn btn-primary btn-sm">Generate</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($contract->file)
                                        <a href="{{ \Storage::disk('public')->url($contract->file) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-file"></i>
                                        </a>
                                        @endif

                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editContractModal{{ $contract->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <div class="modal fade" id="editContractModal{{ $contract->id }}" tabindex="-1" role="dialog" aria-labelledby="editContractModalLabel{{ $contract->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document" style="max-width: 800px">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editContractModalLabel{{ $contract->id }}">Edit Kontrak</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('gtk.contracts.update', [$contract->gtk, $contract]) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            @include('gtkContract.form', ['gtk' => $contract->gtk, 'contract' => $contract, 'isEdit' => true])
                                                            <div class="d-flex justify-content-end mt-3">
                                                                <button type="submit" class="btn btn-primary d-inline-block">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer')

<script>
    $(document).ready(function() {
        $('.select2-input').select2({
            theme: 'bootstrap',
            search: true,
            closeOnSelect: false
        });

        
    	$('.is-datepicker').datetimepicker({
            format: "YYYY-MM-DD"
        });
    });

    function selectAllGtk(e) {
        e.preventDefault();
        $('#gtk_ids').val($('#gtk_ids option').map(function() { return $(this).val(); }).get());
        $('#gtk_ids').trigger('change');
    }

    function deselectAllGtk(e) {
        e.preventDefault();
        $('#gtk_ids').val([]);
        $('#gtk_ids').trigger('change');
    }

    function selectAllSatker(e) {
        e.preventDefault();
        $('#satker_ids').val($('#satker_ids option').map(function() { return $(this).val(); }).get());
        $('#satker_ids').trigger('change');
    }

    function deselectAllSatker(e) {
        e.preventDefault();
        $('#satker_ids').val([]);
        $('#satker_ids').trigger('change');
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#basic-datatables').DataTable({});
    $('#form-create-massal-sk').submit(async function(e){
        e.preventDefault();
        const formData = new FormData(e.target);
        
        // Tampilkan loading
        Swal.fire({
            title: 'Loading...',
            text: 'Sedang memproses data...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false
        });

        try {
            const response = await fetch("{{ route('contracts.generate-batch') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            await Swal.fire({
                title: 'Memproses Data...',
                html: `
                    <div class="progress-container" style="width: 100%; background: #eee; border-radius: 10px; margin-top: 10px;">
                        <div id="progress-bar" style="width: 0%; height: 20px; background: #3085d6; border-radius: 10px; transition: width 0.3s;"></div>
                    </div>
                    <p id="progress-text" style="margin-top: 10px;">Menghubungkan ke server...</p>
                `,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: async () => {
                    const bar = document.getElementById('progress-bar');
                    const text = document.getElementById('progress-text');

                    const total = data.contracts.length;
                    let current = 0;

                    try {
                        
                        for await (const id of data.contracts) {
                            await fetch("/contracts/" + id + "/generate", {
                                method: 'GET',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });
                            
                            current++;
                            const percentage = (current / total) * 100;
                            bar.style.width = percentage + '%';
                            text.innerText = `Memproses data ${current} dari ${total} (${percentage.toFixed(0)}%)`;
                        }

                        Swal.clickConfirm();
                        location.reload();
                    } catch (error) {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    }
                }
            });
            

        } catch (error) {
            console.log(error);
            Swal.fire({
                title: 'Error',
                text: 'Terjadi kesalahan saat memproses data',
                icon: 'error',
                timer: 1000,
                showConfirmButton: false
            });
        }
    })
</script>
@endpush