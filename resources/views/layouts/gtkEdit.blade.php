@extends('layouts.app')

@section('content')
<div class="page-inner page-inner-fill">
    <div class="page-with-aside mail-wrapper bg-white">
        <div class="page-aside bg-grey1">
            <div class="aside-header">
                <div class="title">Data GTK</div>
                <div class="description">{{ $gtk->name }}</div>
                <a class="btn btn-primary toggle-email-nav" data-toggle="collapse" href="#email-app-nav" role="button" aria-expanded="false" aria-controls="email-nav">
                    <span class="btn-label">
                        <i class="icon-menu"></i>
                    </span>
                    Menu
                </a>
            </div>
            <div class="aside-nav collapse" id="email-app-nav">
                <ul class="nav">
                    <li class="@active('gtk.edit')">
                        <a href="{{ route('gtk.edit', $gtk) }}">
                            <i class="fa fa-user py-2 mx-0 text-center" style="width: 50px"></i>
                            Data Diri
                        </a>
                    </li>
                    <li class="@active('gtk.studies.index')">
                        <a href="{{ route('gtk.studies.index', $gtk) }}">
                            <i class="fa fa-graduation-cap py-2 mx-0 text-center" style="width: 50px"></i>
                            Pendidikan
                        </a>
                    </li>
                    <li class="@active('gtk.contracts.index')">
                        <a href="{{ route('gtk.contracts.index', $gtk) }}">
                            <i class="fa fa-file-contract py-2 mx-0 text-center" style="width: 50px"></i>
                            SK
                        </a>
                    </li>

                    @can('admin')
                    <button type="button" class="btn btn-danger mx-4" data-toggle="modal" data-target="#delete-profile-{{ $gtk->id }}">
                        <i class="fas fa-trash"></i>
                        Hapus Data GTK
                    </button>
                    <div class="modal" tabindex="-1" role="dialog" id="delete-profile-{{ $gtk->id }}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Hapus Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin ingin menghapus data <b>{{ $gtk->name }}</b>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <form action="{{ route('gtk.destroy', $gtk->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                </ul>
            </div>
        </div>
        <div class="page-content mail-content">
            @yield('main-content')
        </div>
    </div>
</div>

{{-- <div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Edit GTK</h4>
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
<li class="separator">
    <i class="flaticon-right-arrow"></i>
</li>
<li class="nav-item">
    <a href="{{ route('gtk.edit', $gtk->id) }}">{{ $gtk->name }}</a>
</li>
</ul>
</div>

<div class="row">
    <div class="col-2">
        <div class="btn-group-vertical">
            <a href="{{ route('gtk.edit', $gtk->id) }}" class="btn btn-outline-secondary">Data Diri</a>
            <a href="{{ route('gtk.edit', $gtk->id) }}" class="btn btn-outline-secondary">Data Diri</a>
        </div>
    </div>
    <div class="col-10">
        @yield('main-content')
    </div>
</div>

@yield('main-content')
</div> --}}
@endsection