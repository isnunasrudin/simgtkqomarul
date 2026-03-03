@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Tambah GTK</h4>
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
                <a href="{{ route('gtk.create') }}">Tambah GTK</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah GTK</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('gtk.store') }}" method="POST" enctype="multipart/form-data">
                        @include('gtk.form', ['gtk' => null])
                        <button type="submit" class="btn btn-primary mt-2 d-block ml-auto">Simpan Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection