<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Saksi;
use Illuminate\Http\Request;

class SaksiController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Saksi();
    }

    public function index()
    {
        $data = [
            'saksi_data' => $this->model->orderBy('created_at', 'desc')->get()
        ];

        return view('pages.Saksi.index', $data);
    }

    public function create()
    {
        $data = [
            'kecamatan' => ['Kedaton'],
            'kelurahan' => ['Kedaton', "Penengahan", "Penengahan Raya", "Sidodadi", "Sukamenanti", "Sukamenanti Baru", "Surabaya"],
            'tps' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        ];

        return view('pages.Saksi.create', $data);
    }

    public function edit($saksi_id)
    {
        $data = [
            'saksi' => $this->model->where('id',$saksi_id)->first(),
            'kecamatan' => ['Kedaton'],
            'kelurahan' => ['Kedaton', "Penengahan", "Penengahan Raya", "Sidodadi", "Sukamenanti", "Sukamenanti Baru", "Surabaya"],
            'tps' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        ];

        return view('pages.Saksi.edit', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tps' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'id_telegram' => 'required'
        ]);

        $this->model->create($request->all());

        return redirect(route('saksi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tps' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'id_telegram' => 'required'
        ]);

        $data = $this->model->find($request->id);
        $data->update($request->all());

        return redirect(route('saksi'));
    }

    public function destroy($saksi_id)
    {
        $data = $this->model->find($saksi_id);
        $data->delete();
        return redirect(route('saksi'));
    }
}
