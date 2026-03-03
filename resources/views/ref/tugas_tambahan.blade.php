@extends('layouts.app')

@section('content')
<div class="page-inner">
	<div class="page-header">
		<h4 class="page-title">Data Tugas Tambahan</h4>
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
				<a href="{{ route('ref.tugas_tambahan.index') }}">Data Tugas Tambahan</a>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h4 class="card-title">Tugas Tambahan</h4>

                        <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#createModal">
							<i class="fa fa-plus"></i>
							Tambah Data
						</button>
                        
                        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form class="modal-content" action="{{ route('ref.tugas_tambahan.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                            Tambah</span> 
                                            <span class="fw-light">
                                                Data
                                            </span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label>Nama Tugas Tambahan</label>
                                            <input type="text" class="form-control" placeholder="fill name" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label>Equivalen Jam Pelajaran</label>
                                            <input type="number" class="form-control" placeholder="fill point" name="point">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
					</div>
				</div>
				<div class="card-body">
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
						<table id="basic-datatables" class="display table table-striped table-hover" >
							<thead>
								<tr>
									<th>Nama</th>
									<th>Equivalen Jam Pelajaran</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($allTugasTambahan as $tugasTambahan)
									<tr>
										<td>{{ $tugasTambahan->name }}</td>
										<td>{{ $tugasTambahan->point }}</td>
										<td>
											<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-{{ $tugasTambahan->id }}">
												Edit
											</button>
                                            <div class="modal fade" id="edit-{{ $tugasTambahan->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form class="modal-content" action="{{ route('ref.tugas_tambahan.update', $tugasTambahan->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title">
                                                                <span class="fw-mediumbold">
                                                                Edit</span> 
                                                                <span class="fw-light">
                                                                    Data
                                                                </span>
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="form-group">
                                                                <label>Nama Tugas Tambahan</label>
                                                                <input type="text" class="form-control" placeholder="fill name" name="name" value="{{ old('name', $tugasTambahan->name) }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Equivalen Jam Pelajaran</label>
                                                                <input type="number" class="form-control" placeholder="fill point" name="point" value="{{ old('point', $tugasTambahan->point) }}">
                                                            </div>

															<div class="alert alert-info">
																<b>Perhatian!</b> Mengubah equivalen jam pelajaran tidak akan mempengaruhi data yang sudah ada.
															</div>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="submit" class="btn btn-primary">Edit Data</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

											<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-{{ $tugasTambahan->id }}">
												Hapus
											</button>
											{{-- DELETE --}}
											<div class="modal" tabindex="-1" role="dialog" id="delete-{{ $tugasTambahan->id }}">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Hapus Data</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<p>Apakah anda yakin ingin menghapus data <b>{{ $tugasTambahan->name }}</b>?</p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														<form action="{{ route('ref.tugas_tambahan.destroy', $tugasTambahan->id) }}" method="POST" class="d-inline">
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
		</div>
	</div>
</div>
@endsection