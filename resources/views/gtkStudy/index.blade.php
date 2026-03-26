@extends('layouts.gtkEdit')

@section('main-content')

    <div class="email-head d-lg-flex d-block">
        <h3>
            <i class="fa fa-star favorite"></i>
            Data Pendidikan
        </h3>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-sm ml-3" data-toggle="modal" data-target="#createData">
            <i class="fa fa-plus"></i>
            Tambah Pendidikan
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createData" tabindex="-1" role="dialog" aria-labelledby="createData" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="modal-content" action="{{ route('gtk.studies.store', $gtk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pendidikan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('gtkStudy.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="email-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Aktif</th>
                            <th>Pendidikan</th>
                            <th>Jurusan</th>
                            <th>Institusi</th>
                            <th>Tahun Lulus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gtkStudies as $gtkStudy)
                            <tr>
                                <td>
                                    <form action="{{ route('gtk.studies.activate', [$gtk->id, $gtkStudy->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-{{ $gtkStudy->is_primary ? 'success' : 'secondary' }} btn-sm">{{ $gtkStudy->is_primary ? 'Ya' : 'Tidak' }}</button>
                                    </form>
                                </td>
                                <td>{{ $gtkStudy->level }}</td>
                                <td>{{ $gtkStudy->major }}</td>
                                <td>{{ $gtkStudy->institution }}</td>
                                <td>{{ $gtkStudy->graduation_year }}</td>
                                <td>
                                    <a href="{{ \Storage::disk('public')->url($gtkStudy->file) }}" target="_blank" class="btn btn-primary btn-sm">Lihat Ijazah</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-{{ $gtkStudy->id }}">
                                        Hapus
                                    </button>
                                    <div class="modal" tabindex="-1" role="dialog" id="delete-{{ $gtkStudy->id }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Data</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah anda yakin ingin menghapus data ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <form action="{{ route('gtk.studies.destroy', [$gtk->id, $gtkStudy->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
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
@endsection