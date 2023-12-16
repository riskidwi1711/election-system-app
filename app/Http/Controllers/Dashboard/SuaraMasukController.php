<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Saksi;
use App\Models\SuaraMasuk;
use Exception;
use Illuminate\Http\Request;

class SuaraMasukController extends Controller
{
    private $model;
    private $route_prefix;

    public function __construct()
    {
        $this->model = new SuaraMasuk();
        $this->route_prefix = 'SuaraMasuk';
    }

    public function index()
    {
        $data = [
            'model_data' => $this->model->with('saksi')->orderBy('created_at', 'desc')->get()
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
