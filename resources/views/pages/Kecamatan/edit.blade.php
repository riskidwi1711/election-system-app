@extends('layouts.dashboard')
@section('pages')

{{-- page title --}}
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Edit {{$title}}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-muted " href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{$title}}</li>
                        <li class="breadcrumb-item" aria-current="page">Edit {{$title}}</li>
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
    <form method="POST" action="{{route($prefix.'.update')}}">
        @csrf
        <input type="text" name="id" value="{{$data->id}}" hidden>
        <div class="card-body">
            <h5>Edit saksi baru</h5>
            <p class="card-subtitle mb-3">
                Edit kecamatan.
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
                        <label for="input-name" class="control-label col-form-label">Nama Kecamatan</label>
                        <input id="input-nama" name="nama" type="text" class="form-control" value="{{$data->nama}}"
                            placeholder="Masukan nama kecamatan">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="input-kode" class="control-label col-form-label">Kode</label>
                        <input id="input-kode" name="slug" type="text" class="form-control disabled"
                            value="{{$data->slug}}">
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
@pushOnce('scripts')
<script>
    let nameInput = document.getElementById('input-nama')
        let kodeInput = document.getElementById('input-kode')
        nameInput.addEventListener('change', function(e){
            val = e.target.value.toLowerCase()
            kodeInput.setAttribute('value', val.replace(' ', '_'));
            console.log(e)
        })

</script>
@endPushOnce
@endsection