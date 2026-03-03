@extends('layouts.gtkEdit')

@section('main-content')

    <div class="email-head d-lg-flex d-block">
        <h3>
            <i class="fa fa-star favorite"></i>
            Data Pribadi
        </h3>
    </div>

    <div class="email-body">
        <form action="{{ route('gtk.update', $gtk->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('gtk.form', ['gtk' => $gtk])
            <button type="submit" class="btn btn-primary mt-2 d-block ml-auto">Update Data</button>
        </form>
    </div>
@endsection