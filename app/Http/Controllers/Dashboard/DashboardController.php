<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CalonPresiden;
use App\Models\Kelurahan;
use App\Models\Saksi;
use App\Models\Suara;
use App\Models\SuaraMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $all_suara = SuaraMasuk::all();
        $kelurahan = Kelurahan::all();
        $suara_sisa = 0;
        $suara_sah = 0;
        $suara_tidak_sah = 0;
        $total_suara = 0;
        $chartData = [];
        $pieData = [];
        $calonName = [];

        // Initialize the query without executing it yet
        $query = Suara::select(
            'calon_presiden_id',
            'calon_presiden.nama_calon_presiden',
            'calon_presiden.nama_wakil_presiden',
            DB::raw('SUM(suara_sah) as total_suara_sah')
        )
            ->join('calon_presiden', 'suara.calon_presiden_id', '=', 'calon_presiden.id')
            ->join('saksi', 'suara.saksi_id', '=', 'saksi.id')
            ->join('kelurahan', 'saksi.kelurahan_id', '=', 'kelurahan.id');

        // Check if 'kelurahan' is present in the request
        if ($request->has('kelurahan')) {
            $query->where('kelurahan.id', $request->kelurahan);
        }

        // Group by 'calon_presiden_id' as before
        $query->groupBy('calon_presiden_id');

        // Retrieve the data
        $suaraSahByCalonPresiden = $query->get();

        $suaraSahTerbanyak = Suara::select(
            'calon_presiden_id',
            'calon_presiden.nama_calon_presiden',
            'calon_presiden.nama_wakil_presiden',
            DB::raw('SUM(suara_sah) as total_suara_sah')
        )
            ->join('calon_presiden', 'suara.calon_presiden_id', '=', 'calon_presiden.id')
            ->groupBy('calon_presiden_id', 'calon_presiden.nama_calon_presiden', 'calon_presiden.nama_wakil_presiden')
            ->orderByDesc('total_suara_sah')
            ->limit(1)
            ->first();

        foreach ($suaraSahByCalonPresiden as $result) {
            $suara_sah_total[] = intval($result['total_suara_sah']);
            $calonName[] = $result['nama_calon_presiden'] . '-' . $result['nama_wakil_presiden'];
            $chartData = [
                'name' => 'Suara sah',
                'data' => $suara_sah_total
            ];
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
            "calon_names" => $calonName,
            "table_data" => $suaraSahByCalonPresiden,
            "suara_sah_tertinggi" => $suaraSahTerbanyak,
            "kelurahan" => $kelurahan
        ];
        return view('pages.Home.index', $data);
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
