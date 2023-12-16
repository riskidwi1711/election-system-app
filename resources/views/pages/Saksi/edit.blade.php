@extends('layouts.dashboard')
@section('pages')

{{-- page title --}}
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Edit Data Saksi</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-muted " href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Data Saksi</li>
                        <li class="breadcrumb-item" aria-current="page">Edit Data Saksi</li>
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

{{-- saksi form --}}
<div class="card w-100">
    <form method="POST" action="{{route('saksi.update')}}">
        @csrf
        <input type="text" name="id" value="{{$saksi->id}}" hidden>
        <div class="card-body">
            <h5>Edit saksi baru</h5>
            <p class="card-subtitle mb-3">
                Saksi akan di Editkan sesuai dengan tps, kecamatan, keluarahan yang di masukan, pastikan memilih tps
                di kelurahan dan kecamatan yang benar.
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
                        <label for="isst" class="control-label col-form-label">Nama Saksi</label>
                        <input name="nama" type="text" class="form-control" id="isst" value="{{$saksi->nama}}"
                            placeholder="Masukan nama saksi">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="open" class="control-label col-form-label">Id Telegram</label>
                        <input name="id_telegram" type="text" class="form-control" value="{{$saksi->id_telegram}}"
                            id="open" placeholder="Masukan id telgram saksi">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <label class="control-label col-form-label">Pilih Kecamatan</label>
                        <select name="kecamatan" class="form-select">
                            @foreach ($kecamatan as $item)
                            @if ($item == $saksi->kecamatan)
                            <option selected value="{{$item}}">{{$item}}</option>
                            @endif
                            <option value="{{$item}}">{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <label class="control-label col-form-label">Pilih Kelurahan</label>
                        <select name="kelurahan" class="form-select">
                            @foreach ($kelurahan as $item)
                            @if ($item == $saksi->kelurahan)
                            <option selected value="{{$item}}">{{$item}}</option>
                            @endif
                            <option value="{{$item}}">{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="control-label col-form-label">Pilih Tps</label>
                        <select name="tps" class="form-select">
                            <option selected>Pilih Salah Satu TPS</option>
                            @foreach ($tps as $item)
                            @if ($item == $saksi->tps)
                            <option selected value="{{$item}}">TPS {{$item}}</option>
                            @endif
                            <option value="{{$item}}">TPS {{$item}}</option>
                            @endforeach
                        </select>
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
{{-- end saksi form --}}
@endsection