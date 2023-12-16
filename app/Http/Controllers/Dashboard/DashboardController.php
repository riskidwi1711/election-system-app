<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CalonPresiden;
use App\Models\Saksi;
use App\Models\Suara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $all_suara = Suara::all();
        $suara_sisa = 0;
        $suara_sah = 0;
        $suara_tidak_sah = 0;
        $total_suara = 0;
        $all_calon_presiden = CalonPresiden::all();

        // Inisialisasi array untuk menyimpan data suara
        $suara_data = [];
        $chartData = [];
        $pieData = [];
        $calonName = [];

        // Loop melalui setiap calon presiden
        foreach ($all_calon_presiden as $calon) {
            // Ambil total suara berdasarkan calon_presiden_id
            $calonName[] = $calon->nama_calon_presiden;
            $suara = Suara::select(
                'calon_presiden.nama_calon_presiden', 
                'calon_presiden.nama_wakil_presiden',// Sesuaikan dengan nama kolom yang benar
                DB::raw('SUM(suara_sah) as suara_sah_total'),
                DB::raw('SUM(suara_tidak_sah) as suara_tidak_sah_total'),
                DB::raw('SUM(suara_sisa) as suara_sisa_total')
            )
                ->join('calon_presiden', 'suara.calon_presiden_id', '=', 'calon_presiden.id') // Sesuaikan dengan nama tabel yang benar
                ->where('suara.calon_presiden_id', $calon->id)
                ->groupBy('calon_presiden.nama_calon_presiden', 'suara.calon_presiden_id') // Sesuaikan dengan nama kolom yang benar
                ->first();
            
            if ($suara) {
                $chartData[] =
                    [
                        'name' => $suara->nama_calon_presiden . ' - '. $suara->nama_wakil_presiden,
                        'data' => [
                            intval($suara->suara_sah_total),
                            intval($suara->suara_tidak_sah_total),
                            intval($suara->suara_sisa_total),
                        ],
                    ];
                $pieData[] =  intval($suara->suara_sah_total) + intval($suara->suara_tidak_sah_total) +  intval($suara->suara_sisa_total);
            }

            // Jika tidak ada data, set nilai 0
            if (!$suara) {
                $suara = (object)[
                    'calon_presiden_id' => $calon->nama_calon_presiden,
                    'suara_sah_total' => 0,
                    'suara_tidak_sah_total' => 0,
                    'suara_sisa_total' => 0,

                ];

                $chartData[] =
                    [
                        'name' => $calon->nama_calon_presiden .' - '. $calon->nama_wakil_presiden,
                        'data' => [
                            0,
                            0,
                            0,
                        ],
                    ];
                $pieData[] = 0;
            }

            // Tambahkan data suara ke dalam array
            $suara_data[] = $suara;
        }

        foreach ($all_suara as $suara) {
            $total_suara += $suara->suara_sisa + $suara->suara_sah + $suara->suara_tidak_sah;
            $suara_sisa += $suara->suara_sisa;
            $suara_sah += $suara->suara_sah;
            $suara_tidak_sah += $suara->suara_tidak_sah;
        }
        

        $data = [
            "count_saksi" => Saksi::all()->count(),
            "count_calon" => CalonPresiden::all()->count(),
            "count_total_suara" => $total_suara,
            "count_suara_tidak_sah" => $suara_tidak_sah,
            "count_suara_sah" => $suara_sah,
            "count_suara_sisa" => $suara_sisa,
            "chart_data" => $chartData,
            "pie_data" => $pieData,
            "calon_names"=> $calonName
        ];
        return view('pages.home.index', $data);
    }

    public function chartConfig()
    {
        // Ambil data dari model

        $data = Suara::join('calon_presiden', 'suara.calon_presiden_id', '=', 'calon_presiden.id')
            ->select('suara.*', 'calon_presiden.no_urut')
            ->get();

        // Pisahkan data ke dalam array untuk setiap kategori (misalnya, suara sah, tidak sah, sisa)
        $suaraSah = $data->groupBy('calon_presiden_id')->map(function ($group) {
            return $group->pluck('suara_sah')->toArray();
        });

        $suaraTidakSah = $data->groupBy('calon_presiden_id')->map(function ($group) {
            return $group->pluck('suara_tidak_sah')->toArray();
        });

        $suaraSisa = $data->groupBy('calon_presiden_id')->map(function ($group) {
            return $group->pluck('suara_sisa')->toArray();
        });

        // Kategori (misalnya, nama kandidat atau tanggal pemilu)
        $categories = $data->groupBy('calon_presiden_id')->map(function ($group) {
            return $group->first()->no_urut;
        });


        $series = [];
        foreach ($suaraSah as $calonId => $suaraSahData) {
            $series[] = [
                'name' => $categories[$calonId],
                'data' => $suaraSahData,
            ];
        }

        $chartConfig = [
            'series' => $series,
            'chart' => [
                // Konfigurasi grafik
            ],
            'colors' => ["var(--bs-primary)", "var(--bs-secondary)", "var(--bs-tertiary)"],
            'plotOptions' => [
                'bar' => [
                    // Konfigurasi plotOptions
                ],
            ],
            'dataLabels' => [
                // Konfigurasi dataLabels
            ],
            'legend' => [
                // Konfigurasi legend
            ],
            'grid' => [
                // Konfigurasi grid
            ],
            'yaxis' => [
                // Konfigurasi yaxis
            ],
            'xaxis' => [
                'categories' => $categories->values()->toArray(),
                // Konfigurasi xaxis
            ],
            'tooltip' => [
                // Konfigurasi tooltip
            ],
        ];

        return $chartConfig;
    }
}
