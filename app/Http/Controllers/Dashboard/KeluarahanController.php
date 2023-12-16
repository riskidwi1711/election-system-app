<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class KeluarahanController extends Controller
{
    private $model;
    private $route_prefix;

    public function __construct()
    {
        $this->model = new Kelurahan();
        $this->route_prefix = 'Kelurahan';
    }

    public function index()
    {
        $data = [
            'title' => 'Data ' . $this->route_prefix,
            'table_coloumn' => ['Nama', 'Kecamatan', 'Opsi'],
            'prefix' => strtolower($this->route_prefix),
            'table' => $this->model->with('kecamatan')->orderBy('created_at', 'desc')->get()
        ];

        return view('pages.' . $this->route_prefix . '.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Data ' . $this->route_prefix,
            'prefix' => strtolower($this->route_prefix),
            'additional_data' => [
                "kecamatan" => Kecamatan::all()
            ]
        ];

        return view('pages.' . $this->route_prefix . '.create', $data);
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Data ' . $this->route_prefix,
            'prefix' => strtolower($this->route_prefix),
            'data' => $this->model->where('id', $id)->first(),
            'additional_data' => [
                "kecamatan" => Kecamatan::all()
            ]
        ];

        return view('pages.' . $this->route_prefix . '.edit', $data);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required',
            'kecamatan_id' => 'required'
        ]);


        $this->model->create($request->all());

        return redirect(route(strtolower($this->route_prefix)));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kecamatan_id' => 'required'
        ]);

        $data = $this->model->find($request->id);
        $data->update($request->all());

        return redirect(route(strtolower($this->route_prefix)));
    }

    public function destroy($id)
    {
        $data = $this->model->find($id);
        $data->delete();
        return redirect(route(strtolower($this->route_prefix)));
    }
}
