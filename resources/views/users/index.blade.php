@extends('layouts.app')

@section('content')
<div class="page-inner">
	<div class="page-header">
		<h4 class="page-title">Data Kredensial</h4>
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
				<a href="{{ route('users.index') }}">Data Kredensial</a>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h4 class="card-title">Kredensial</h4>

						<button type="button" class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#tambahModal">
							<i class="fa fa-plus"></i>
							Tambah Data
						</button>

						<div class="modal fade" id="tambahModal" role="dialog" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Tambah Data</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form action="{{ route('users.store') }}" method="POST">
											@include('users.form', ['user' => null])
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
												<button type="submit" class="btn btn-primary">Simpan</button>
											</div>
										</form>
									</div>
								</div>
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
						<table id="basic-datatables" class="display table table-striped table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama</th>
									<th>Data GTK</th>
									<th>Email</th>
									<th>Password Default</th>
									<th>Terakhir Login</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($users as $user)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $user->name }}</td>
									<td>
										@if($user->gtk)
										<a href="{{ route('gtk.show', $user->gtk->id) }}">{{ $user->gtk->name }}</a>
										@else
										-
										@endif
									</td>
									<td>{{ $user->email }}</td>
									<td>
										{{ $user->default_password ?? '-' }}
									</td>
									<td>
										{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : '-' }}
									</td>
									<td>
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal{{ $user->id }}">
											<i class="fa fa-edit"></i>
										</button>

										<div class="modal fade" id="editModal{{ $user->id }}" role="dialog" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Edit Data</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<form action="{{ route('users.update', $user->id) }}" method="POST">
															@csrf
															@method('PUT')
															@include('users.form', ['user' => $user])
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
																<button type="submit" class="btn btn-primary">Simpan</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>

										<form action="{{ route('users.reset-password', $user->id) }}" method="POST" style="display: inline;">
											@csrf
											@method('PATCH')
											<button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Apakah Anda yakin ingin mereset password data ini?')">
												<i class="fa fa-key"></i>
											</button>
										</form>

										<form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
												<i class="fa fa-trash"></i>
											</button>
										</form>
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
	$('#basic-datatables').DataTable({});

	$('.select2').select2({
		theme: 'bootstrap',
	});
</script>
@endpush