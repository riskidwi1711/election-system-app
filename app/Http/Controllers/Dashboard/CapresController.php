<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CalonPresiden;
use Illuminate\Http\Request;

class CapresController extends Controller
{
    private $model;
    private $route_prefix;

    public function __construct()
    {
        $this->model = new CalonPresiden();
        $this->route_prefix = 'Capres';
    }

    public function index()
    {
        $data = [
            'model_data' => $this->model->orderBy('created_at', 'desc')->get()
        ];

        return view('pages.' . $this->route_prefix . '.index', $data);
    }

    public function create()
    {
        $data = [
            'kecamatan' => ['Kedaton'],
            'kelurahan' => ['Kedaton', "Penengahan", "Penengahan Raya", "Sidodadi", "Sukamenanti", "Sukamenanti Baru", "Surabaya"],
            'tps' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        ];

        return view('pages.' . $this->route_prefix . '.create', $data);
    }

    public function edit($saksi_id)
    {
        $data = [
            'model_data' => $this->model->find($saksi_id)->first()
        ];

        return view('pages.' . $this->route_prefix . '.edit', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_calon_presiden' => 'required',
            'nama_wakil_presiden' => 'required',
            'no_urut' => 'required',
        ]);

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Sesuaikan aturan validasi sesuai kebutuhan
        ]);

        // Simpan gambar ke penyimpanan yang diinginkan (contoh: penyimpanan publik)
        $path = $request->file('foto')->store('uploads', 'public');
        $image_name = $path;

        $this->model->create([
            'nama_calon_presiden' => $request->nama_calon_presiden,
            'nama_wakil_presiden' => $request->nama_wakil_presiden,
            'no_urut' => $request->no_urut,
            'foto' => $image_name,
        ]);

        return redirect(route($this->route_prefix));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_calon_presiden' => 'required',
            'nama_wakil_presiden' => 'required',
            'no_urut' => 'required',
        ]);

        $data = $this->model->find($request->id);
        
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('uploads', 'public');
            $image_name = $path;
            $data->update([
                'nama_calon_presiden' => $request->nama_calon_presiden,
                'nama_wakil_presiden' => $request->nama_wakil_presiden,
                'no_urut' => $request->no_urut,
                'foto' => $image_name,
            ]);
        } else {
            $data->update([
                'nama_calon_presiden' => $request->nama_calon_presiden,
                'nama_wakil_presiden' => $request->nama_wakil_presiden,
                'no_urut' => $request->no_urut,
            ]);
        }

        return redirect(route($this->route_prefix));
    }

    public function destroy($id)
    {
        $data = $this->model->find($id);
        $data->delete();
        return redirect(route($this->route_prefix));
    }
}
