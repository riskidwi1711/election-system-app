@extends('layouts.dashboard')
@section('pages')

{{-- page title --}}
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Edit Data Calon Presiden & Wakil Presiden</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-muted " href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Data Calon Presiden & Wakil Presiden</li>
                        <li class="breadcrumb-item" aria-current="page">Edit Data Calon Presiden & Wakil Presiden</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src={{asset("dashboard_assets/dist/images/breadcrumb/ChatBc.png")}} alt=""
                        class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>
</div>
{{-- end page title --}}

{{-- Calon Presiden & Wakil Presiden form --}}
<div class="card w-100">
    <form method="POST" action="{{route('capres.update')}}" enctype="multipart/form-data">
        @csrf
        <input type="text" name="id" value="{{$model_data->id}}" hidden>
        <div class="card-body">
            <h5>Edit Calon Presiden & Wakil Presiden baru</h5>
            <p class="card-subtitle mb-3">
                Calon Presiden & Wakil Presiden akan di Editkan sesuai dengan no urut.
            </p>
            @error('*')
            <div class="alert bg-light-primary text-info alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center text-primary font-medium">
                    <i class="ti ti-info-circle me-2 fs-4"></i>
                    {{$message}}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
        </div>
        <div class="card-body border-top">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="isst" class="control-label col-form-label">Nama Calon Presiden</label>
                        <input type="text" class="form-control" id="isst" name="nama_calon_presiden"
                            placeholder="Masukan nama calon Presiden" value="{{$model_data->nama_calon_presiden}}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="isst" class="control-label col-form-label">Nama Wakil Presiden</label>
                        <input type="text" class="form-control" id="isst" name="nama_wakil_presiden"
                            placeholder="Masukan nama calon Wakil Presiden" value="{{$model_data->nama_wakil_presiden}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="isst" class="control-label col-form-label">No Urut</label>
                        <input type="number" type="text" class="form-control" id="isst"
                            placeholder="Masukan no urut Calon Presiden & Wakil Presiden" name="no_urut" value="{{$model_data->no_urut}}">
                    </div>
                </div>
                <div class="col-6 pt-2">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload Foto</label>
                        <input class="form-control" type="file" id="formFile" name="foto" value="{{$model_data->foto}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="p-3 border-top">
            <div class="action-form">
                <div class="text-end">
                    <button type="submit" class="btn btn-info px-4 waves-effect waves-light">
                        Simpan
                    </button>
                    <button type="submit" class="btn btn-dark px-4 waves-effect waves-light">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- end Calon Presiden & Wakil Presiden form --}}
@endsection