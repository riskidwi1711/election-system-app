@extends('layouts.guests')
@section('content')
<div class="d-flex align-items-center justify-content-center w-100">
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
                <div class="card-body">
                    <a href="/"
                        class="text-nowrap logo-img text-center d-flex gap-3 justify-content-center align-items-center mb-5 w-100 d-flex">
                        <img src="{{asset('dashboard_assets/dist/images/logo/election.png')}}" width="35" alt="">
                        <h3 id="app-name" class="m-0 fw-bolder">Voting App</h3>
                    </a>
                    <form action="{{ route('store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama</label>
                            <input name="name" type="text" class="form-control" id="exampleInputtext"
                                aria-describedby="textHelp">
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif

                        </div>
                        <div class="mb-4">
                            <label for="exampleInputPassword1" class="form-label">Kata Sandi</label>
                            <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="exampleInputPassword1" class="form-label">Kata Sandi</label>
                            <input name="password_confirmation" type="password" class="form-control" id="exampleInputPassword1">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Daftar</button>
                        <div class="d-flex align-items-center">
                            <p class="fs-4 mb-0 text-dark">Sudah memiliki akun?</p>
                            <a class="text-primary fw-medium ms-2" href="/login">Masuk</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection