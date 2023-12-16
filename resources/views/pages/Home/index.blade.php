@extends('layouts.dashboard')
@section('pages')
@include('pages.Home.components.slider')
<!--  Row 1 -->
<div class="row">
    <div class="col-lg-8 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Total Perolehan Suara</h5>
                        <p class="card-subtitle mb-0">Total suara masuk per calon berdasarkan jenis suara</p>
                    </div>
                    <div>
                        <form class="d-flex gap-2 justify-content-center align-items-center"
                            action={{route('dashboard')}} method="GET">
                            <select name="kelurahan" class="form-select">
                                <option selected>Pilih kelurahan</option>
                                @foreach ($kelurahan as $item)
                                <option value="{{$item->id}}">{{$item->nama}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-12">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-12 col-md-6 col-sm-12">
                <!-- Yearly Breakup -->
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="card-title mb-9 fw-semibold">Total Perolehan Suara</h5>
                                <h4 class="fw-semibold mb-3">{{$count_total_suara}} Suara</h4>

                                <div class="d-flex align-items-center">
                                    @foreach ($calon_names as $key => $item)
                                    <div class="me-4">
                                        @if ($key == 0)
                                        <span class="round-8 p-2 bg-primary rounded-circle me-2 d-inline-block"></span>
                                        @else
                                        @if ($key == 1)
                                        <span class="round-8 p-2 bg-danger rounded-circle me-2 d-inline-block"></span>
                                        @else
                                        <span class="round-8 p-2 bg-success rounded-circle me-2 d-inline-block"></span>
                                        @endif
                                        @endif
                                        <span class="fs-2">{{$item}}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-center">
                                    <div id="breakup"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-6 col-sm-12">
                <!-- Monthly Earnings -->
                <div class="card">
                    <div class="card-body">
                        <div class="row alig n-items-start">
                            <div class="col-8">
                                <h6 class="card-title mb-1 fw-semibold">Paslon Suara Tertinggi </h6>
                                <h5 class="card-title mb-9 fw-semibold">{{$suara_sah_tertinggi['nama_calon_presiden']}}
                                    - {{$suara_sah_tertinggi['nama_wakil_presiden']}} </h5>
                                <h4 class="fw-semibold mb-3">{{$suara_sah_tertinggi['total_suara_sah']}} Suara</h4>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-end">
                                    <div
                                        class="text-white bg-success rounded-circle p-6 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-badges-filled fs-6"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Weekly Stats -->
    <div class="col-lg-4 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title fw-semibold">Suara Masuk</h5>
                <p class="card-subtitle mb-0">Semua Suara Masuk</p>
                <div class="position-relative mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-7">
                        <div class="d-flex">
                            <div
                                class="p-6 bg-light-primary rounded me-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-grid-dots text-primary fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4 fw-semibold">Suara Sah</h6>
                                <p class="fs-3 mb-0">Suara yang dianggap sah</p>
                            </div>
                        </div>
                        <div class="bg-light-primary badge">
                            <p class="fs-3 text-primary fw-semibold mb-0">{{$count_suara_sah}}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-7">
                        <div class="d-flex">
                            <div
                                class="p-6 bg-light-success rounded me-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-grid-dots text-success fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4 fw-semibold">Suara Tidak Sah</h6>
                                <p class="fs-3 mb-0">Suara yang tidak dianggap sah</p>
                            </div>
                        </div>
                        <div class="bg-light-success badge">
                            <p class="fs-3 text-success fw-semibold mb-0">{{$count_suara_tidak_sah}}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex">
                            <div
                                class="p-6 bg-light-danger rounded me-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-grid-dots text-danger fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4 fw-semibold">Suara Sisa</h6>
                                <p class="fs-3 mb-0">Suara sisa</p>
                            </div>
                        </div>
                        <div class="bg-light-danger badge">
                            <p class="fs-3 text-danger fw-semibold mb-0">{{$count_suara_sisa}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Performers -->
    <div class="col-lg-8 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Peringkat Sementara</h5>
                        <p class="card-subtitle mb-0">Peringkat sementara perolehan suara</p>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr class="text-muted fw-semibold">
                                <th scope="col" class="ps-0">Nama Pasangan Calon</th>
                                <th scope="col">Suara Sah</th>
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            @foreach ($table_data as $item)
                            <tr>
                                <td class="ps-0">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="fw-semibold mb-1">{{$item->nama_calon_presiden}} -
                                                {{$item->nama_wakil_presiden}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 fs-3">{{$item->total_suara_sah}} suara</p>
                                </td>
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


@pushOnce('scripts')
<script>
    var jsonString = {!!json_encode($chart_data)!!};
    console.log(jsonString)
    var chart = {
        series: [jsonString],
        chart: {
            toolbar: {
                show: false,
            },
            type: "bar",
            fontFamily: "Plus Jakarta Sans', sans-serif",
            foreColor: "#adb0bb",
            height: 320,
            stacked: false,
        },
        colors: ["var(--bs-primary)", "var(--bs-secondary)", "var(--bs-success)"],
        plotOptions: {
            bar: {
                horizontal: false,
                barHeight: "60%",
                columnWidth: "20%",
                borderRadius: [6],
                borderRadiusApplication: "end",
                borderRadiusWhenStacked: "all",
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: false,
                },
            },
        },
        yaxis: {
            min: -5,
            max: 5,
            title: {
                // text: 'Age',
            },
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            categories: {!!json_encode($calon_names)!!},
        },
        yaxis: {
            tickAmount: 4,
        },
        tooltip: {
            theme: "dark",
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), chart);
    chart.render();

    // pie
    var breakup = {
        color: "#adb5bd",
        series: {!!json_encode($chart_data['data'])!!},
        labels: {!!json_encode($calon_names)!!},
        chart: {
            width: 180,
            type: "donut",
            fontFamily: "Plus Jakarta Sans', sans-serif",
            foreColor: "#adb0bb",
        },
        plotOptions: {
            pie: {
                startAngle: 0,
                endAngle: 360,
                donut: {
                    size: "75%",
                },
            },
        },
        stroke: {
            show: false,
        },

        dataLabels: {
            enabled: true,
        },

        legend: {
            show: false,
        },
        colors: ["var(--bs-primary)", "var(--bs-warning)", "var(--bs-success)"],

        responsive: [
            {
                breakpoint: 991,
                options: {
                    chart: {
                        width: 120,
                    },
                },
            },
        ],
        tooltip: {
            theme: "dark",
            fillSeriesColor: false,
        },
    };

    var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
    chart.render();
</script>
@endPushOnce

@endsection