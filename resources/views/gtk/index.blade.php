@extends('layouts.app')

@section('content')
<div class="page-inner">
	<div class="page-header">
		<h4 class="page-title">Data GTK</h4>
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
				<a href="{{ route('gtk.index') }}">Data GTK</a>
			</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h4 class="card-title">Guru & Tenaga Kependidikan</h4>
						<a href="{{ route('gtk.create') }}" class="btn btn-primary btn-round ml-auto">
							<i class="fa fa-plus"></i>
							Tambah Data
						</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="basic-datatables" class="display table table-striped table-hover">
							<thead>
								<tr>
									<th>Instansi</th>
									<th>Kredensial</th>
									<th>Nama</th>
									<th>TTL</th>
									<th>Masa Kerja</th>
									<th>Pendidikan</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($allGtk as $gtk)
								<tr>
									<td>
										<span class="badge badge-primary">{{ $gtk->satuanKerja->name ?? '-' }}</span>
									</td>
									<td>
										@if($gtk->user)
										<span class="badge badge-success">
											<i class="fa fa-check"></i>
										</span>
										@else
										<form action="{{ route('gtk.generate-credentials', $gtk->id) }}" method="POST">
											@csrf
											@method('PATCH')
											<button type="submit" class="btn btn-danger btn-round btn-sm">
												<i class="fa fa-plus"></i>
											</button>
										</form>
										@endif
									</td>
									<td class="">
										<a href="{{ route('gtk.edit', $gtk->id) }}" class="d-flex align-items-center text-dark" style="text-decoration: none">
											@if($gtk->photo)
											<img src="{{ \Storage::url($gtk->photo) }}" alt="" class="img-thumbnail mr-2" style="width: 50px; height: 50px;">
											@endif
											<div>
												<p class="mb-0 font-weight-bold text-primary">{{ $gtk->name }}</p>
												<small>{{ $gtk->type == 'TU' ? 'Tenaga Kependidikan' : 'Guru' }}</small>
											</div>
										</a>
									</td>
									<td>{{ $gtk->birth_place }}, {{ \Carbon\Carbon::parse($gtk->birth_date)->format('d F Y') }}</td>
									<td>{{ floor(\Carbon\Carbon::parse($gtk->tmt_yayasan)->diffInMonths(now()) / 12) }} tahun {{ \Carbon\Carbon::parse($gtk->tmt_yayasan)->diffInMonths(now()) % 12 }} bulan</td>
									<td>
										@if($gtk->activeStudy)
										{{ $gtk->activeStudy->level }}
										@else
										<span class="text-danger">Belum ada</span>
										@endif
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
</script>
@endpush