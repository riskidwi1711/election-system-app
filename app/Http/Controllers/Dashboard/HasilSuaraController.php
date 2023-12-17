<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Saksi;
use App\Models\Suara;
use Exception;
use Illuminate\Http\Request;

class HasilSuaraController extends Controller
{
    private $model;
    private $route_prefix;

    public function __construct()
    {
        $this->model = new Suara();
        $this->route_prefix = 'Suara';
    }

    public function index()
    {


        $suaraData = Suara::selectRaw('saksi_id, calon_presiden_id,calon_presiden.nama_calon_presiden,calon_presiden.nama_wakil_presiden,saksi.tps,saksi.nama,kelurahan.nama as kelurahan,kecamatan.nama as kecamatan, SUM(suara_sah) as total_suara_sah')
            ->join('saksi', 'suara.saksi_id', '=', 'saksi.id')
            ->join('calon_presiden', 'suara.calon_presiden_id', '=', 'calon_presiden.id')
            ->join('kecamatan', 'saksi.kecamatan_id', '=', 'kecamatan.id')
            ->join('kelurahan', 'saksi.kelurahan_id', '=', 'kelurahan.id')
            ->groupBy('saksi_id', 'calon_presiden_id')
            ->get();

        $formattedOutput = [];
        $formattedKey = [];

        foreach ($suaraData as $item) {
            $saksiId = $item->saksi_id;
            $nama_calon = $item->nama_calon_presiden;
            $nama_wakil = $item->nama_wakil_presiden;
            $nama_saksi = $item->nama;
            $totalSuaraSah = $item->total_suara_sah;
            $kelurahan = $item->kelurahan;
            $kecamatan = $item->kecamatan;
            $tps = $item->tps;

            // if (!isset($formattedOutput[$saksiId])) {
            //     $formattedOutput[$nama_saksi] = [];
            // }
            $formattedOutput[$nama_saksi]['saksi'] = $nama_saksi;
            $formattedOutput[$nama_saksi]['kelurahan'] = $kelurahan;
            $formattedOutput[$nama_saksi]['kecamatan'] = $kecamatan;
            $formattedOutput[$nama_saksi]['tps'] = 'TPS '.$tps;
            $formattedOutput[$nama_saksi][$nama_calon . '-' . $nama_wakil] = $totalSuaraSah;
        }

        foreach ($formattedOutput as $k => $data) {

            foreach ($data as $key => $val) {
                $formattedKey[] = $key;
            }
        }

        $formattedKey = array_unique($formattedKey);

        $data = [
            'model_data' => $this->model->with('saksi', 'calonPresiden')->orderBy('created_at', 'desc')->get(),
            'formattedKey' => $formattedKey,
            'formattedOutput' => $formattedOutput
        ];

        return view('pages.' . $this->route_prefix . '.index', $data);
    }

    public function create()
    {
        $data = [];

        return view('pages.' . $this->route_prefix . '.create', $data);
    }

    public function store(Request $request)
    {
        try {

            // check if user validated
            $saksi = Saksi::find($request->saksi_id)->first();
            if (!$saksi) {
                throw new Exception('Saksi tidak ditemukan.');
            }

            $request->validate([
                'presiden_id' => 'required',
                'saksi_id' => 'required',
                'suara_sah' => 'required',
                'suara_tidak_sah' => 'required',
                'suara_sisa' => 'required'
            ]);

            $suara = $this->model->create($request->all());

            $response = [
                "response_code" => "00",
                "response_msg" => "success",
                "message" => $suara
            ];
        } catch (\Throwable $th) {
            $response = [
                "response_code" => "99",
                "response_msg" => "failed",
                "message" => $th->getMessage()
            ];
        }

        return response()->json($response);
    }
}
