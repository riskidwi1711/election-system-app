@extends('layouts.dashboard')
@section('pages')

{{-- page title --}}
<div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">List Tabulasi Suara Masuk</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-muted " href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Data Tabulasi Suara Masuk</li>
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

{{-- saksi table --}}

<section class="datatables">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="mb-2">
                                <h5 class="mb-0">Data Tabulasi Suara</h5>
                            </div>
                            <p class="card-subtitle mb-3">
                                Hasil rekapitulasi suara yang di inputkan saksi melalui aplikasi telegram.
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nama Saksi</th>
                                    <th>TPS</th>
                                    <th>Kelurahan</th>
                                    <th>Suara Sah</th>
                                    <th>Suara Tidak Sah</th>
                                    <th>Suara Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model_data as $item)
                                <tr>
                                    <td>{{$item->saksi->nama}}</td>
                                    <td>TPS {{$item->saksi->tps}}</td>
                                    <td>{{$item->saksi->kelurahan->nama}}</td>
                                    <td>{{$item->suara_sah}}
                                    </td>
                                    <td>{{$item->suara_tidak_sah}}</td>
                                    <td>{{$item->suara_sisa}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nama Saksi</th>
                                    <th>TPS</th>
                                    <th>Kelurahan</th>
                                    <th>Suara Sah</th>
                                    <th>Suara Tidak Sah</th>
                                    <th>Suara Sisa</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@pushOnce('style')
<link rel="stylesheet"
    href={{asset("dashboard_assets/dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css")}}>
@endPushOnce

@pushOnce('scripts')
<script src={{asset("dashboard_assets/dist/libs/datatables.net/js/jquery.dataTables.min.js")}}></script>
<script src={{asset("dashboard_assets/dist/js/datatable/datatable-basic.init.js")}}></script>
@endPushOnce

{{-- end saksi table --}}
@endsection