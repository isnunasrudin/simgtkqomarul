@extends('layouts.gtkEdit')

@section('main-content')

    <div class="email-head d-lg-flex d-block">
        <h3>
            <i class="fa fa-star favorite"></i>
            Data SK
        </h3>

        <button class="btn btn-primary btn-sm ml-3" data-toggle="modal" data-target="#addContractModal">
            <i class="fas fa-plus"></i>
            Tambah Kontrak
        </button>
        <div class="modal fade" id="addContractModal" tabindex="-1" role="dialog" aria-labelledby="addContractModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 800px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addContractModalLabel">Tambah Kontrak</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('gtk.contracts.store', $gtk) }}" method="POST" enctype="multipart/form-data">
                            @include('gtkContract.form', ['gtk' => $gtk, 'isEdit' => false])
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary d-inline-block">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="email-body">
        <div class="table-responsive">
            <table id="basic-datatables" class="display table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Status</th>
                        <th>Nomor Kontrak</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Berakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contracts as $contract)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <form action="{{ route('gtk.contracts.activate', [$gtk, $contract]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-{{ $contract->is_primary ? 'success' : 'secondary' }} btn-sm">
                                        <i class="fas fa-{{ $contract->is_primary ? 'check' : 'times' }}"></i>
                                        {{ $contract->is_primary ? 'Aktif' : 'Tidak Aktif' }}
                                    </button>
                                </form>
                            </td>
                            <td>{{ $contract->reference_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($contract->effective_date)->format('d-m-Y') }}</td>
                            <td>{{ $contract->expired_date ? \Carbon\Carbon::parse($contract->expired_date)->format('d-m-Y') : '-' }}</td>
                            <td>
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
                                                <form action="{{ route('gtk.contracts.update', [$gtk, $contract]) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    @include('gtkContract.form', ['gtk' => $gtk, 'contract' => $contract, 'isEdit' => true])
                                                    <div class="d-flex justify-content-end mt-3">
                                                        <button type="submit" class="btn btn-primary d-inline-block">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('gtk.contracts.destroy', [$gtk, $contract]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kontrak ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection