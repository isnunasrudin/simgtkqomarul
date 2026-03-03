@extends('layouts.app')

@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Selamat Datang, {{ Auth::user()->name }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">

    <div class="row">
        <div class="col-md-4">

            <div class="card card-profile">
                <div class="card-header" style="background-image: url('../assets/img/blogpost.jpg')">
                    <div class="profile-picture">
                        <div class="avatar avatar-xl">
                            <img src="{{ \Storage::url(data_get(Auth::user()->gtk ?? null, 'photo')) }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-profile text-center">
                        <div class="name">{{ Auth::user()->name }}</div>
                        <div class="job">{{ Auth::user()->gtk->type }}</div>
                        <div class="desc">{{ Auth::user()->gtk->satuanKerja->name }}</div>
                        <div class="view-profile">
                            <a href="{{ route('gtk.edit', Auth::user()->gtk->id) }}" class="btn btn-secondary btn-block">Edit Data Diri</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Kelengkapan Data GTK</div>
                </div>
                <div class="card-body">

                    <div class="d-flex">
                        <div class="avatar avatar-online">
                            <span class="avatar-title rounded-circle border border-white bg-info">
                                <i class="fa fa-check"></i>
                            </span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">
                                Data Diri
                            </h6>
                            <span class="text-muted">Data diri anda sudah lengkap</span>
                        </div>
                        <div class="float-right pt-1">
                            <a href="{{ route('gtk.edit', Auth::user()->gtk->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        </div>
                    </div>

                    <div class="d-flex mt-4">
                        <div class="avatar avatar-online">
                            <span class="avatar-title rounded-circle border border-white bg-info">
                                <i class="fa fa-check"></i>
                            </span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">
                                Riwayat Pendidikan
                            </h6>
                            <span class="text-muted">Data pendidikan anda sudah lengkap</span>
                        </div>
                        <div class="float-right pt-1">
                            <a href="{{ route('gtk.studies.index', Auth::user()->gtk->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        </div>
                    </div>

                    <div class="d-flex mt-4">
                        <div class="avatar">
                            <span class="avatar-title rounded-circle border border-white bg-info">
                                <i class="fa fa-file"></i>
                            </span>
                        </div>
                        <div class="flex-1 ml-3 pt-1">
                            <h6 class="text-uppercase fw-bold mb-1">
                                Surat Keterangan
                            </h6>
                            <span class="text-muted">
                                Riwayat SK Pengangkatan
                            </span>
                        </div>
                        <div class="float-right pt-1">
                            <a href="{{ route('gtk.contracts.index', Auth::user()->gtk->id) }}" class="btn btn-primary btn-sm">Lihat</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection