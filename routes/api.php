<?php

use App\Http\Controllers\Dashboard\HasilSuaraController;
use App\Models\CalonPresiden;
use App\Models\FileUpload;
use App\Models\Kelurahan;
use App\Models\Saksi;
use App\Models\Suara;
use App\Models\SuaraMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Can;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->group(function () {
    Route::prefix('telegram')->group(function () {
        Route::get('list_capres', function () {
            $capres = CalonPresiden::all();
            $message = [];
            foreach ($capres as $key => $pres) {
                $message[$key]['id'] = $pres->no_urut;
                $message[$key]['name'] = $pres->nama_calon_presiden . "-" . $pres->nama_wakil_presiden;
            }
            $response = [
                "response_code" => "00",
                "response_msg" => "success",
                "message" => $message
            ];

            return response()->json($response);
        });
        Route::post('validate_user', function (Request $request) {
            $response = [
                "response_code" => "00",
                "response_msg" => "success"
            ];
            $username =  $request->username;
            $valid = Saksi::where('id_telegram', $username)->first();
            if ($valid) {
                $response['response_code'] = "00";
                $response['response_msg'] = "User validated";
                $response['message'] = [];
            } else {
                $response['response_code'] = "99";
                $response['response_msg'] = "User not validated";
                $response['message'] = [];
            }

            return response()->json($response);
        });
        Route::post('save_suara', function (Request $request) {
            $response = [
                "response_code" => "00",
                "response_msg" => "success"
            ];
            try {
                $username =  $request->username;
                $valid = Saksi::where('id_telegram', $username)->first();
                if (!$valid) {
                    throw new Exception('Saksi tidak terdaftar.');
                }

                $get_capres = CalonPresiden::where('no_urut', $request->no_urut_calon)->first();
                if (!$get_capres) {
                    throw new Exception('Calon yang di pilih tidak valid.');
                }

                $total_suara_sah = $request->total_suara_sah;
                $total_suara_tidak_sah = $request->total_suara_tidak_sah;
                $total_suara_sisa = $request->total_suara_sisa;

                $Suara = Suara::create([
                    'saksi_id' => $valid->id,
                    'calon_presiden_id' => $get_capres->id,
                    'suara_sah' => $total_suara_sah,
                    'suara_tidak_sah' => $total_suara_tidak_sah,
                    'suara_sisa' => $total_suara_sisa
                ]);

                $response['response_code'] = "00";
                $response['response_msg'] = "Berhasil menyimpan suara";
                $response['message'] = $Suara;
            } catch (\Throwable $th) {
                $response['response_code'] = "99";
                $response['response_msg'] = $th->getMessage();
                $response['message'] = [];
            }

            return response()->json($response);
        });
        Route::post('konfirmasi_suara', function (Request $request) {
            $response = [
                "response_code" => "00",
                "response_msg" => "success"
            ];
            try {
                $username =  $request->username;
                $valid = Saksi::where('id_telegram', $username)->first();
                if (!$valid) {
                    throw new Exception('Saksi tidak terdaftar.');
                }

                $calon_1 = CalonPresiden::where('no_urut', 1)->first();
                $calon_2 = CalonPresiden::where('no_urut', 2)->first();
                $calon_3 = CalonPresiden::where('no_urut', 3)->first();
                $suara_calon[] = $request->suara_calon_1;
                $suara_calon[] = $request->suara_calon_2;
                $suara_calon[] = $request->suara_calon_3;
                $suara_tidak_sah = $request->suara_tidak_sah;
                $suara_sisa = $request->suara_sisa;

                $dataToInsert = [
                    [
                        'saksi_id' => $valid->id,
                        'calon_presiden_id' => $calon_1->id,
                        'suara_sah' => $suara_calon[0],
                        'suara_tidak_sah' => 0,
                        'suara_sisa' => 0,
                    ],
                    [
                        'saksi_id' => $valid->id,
                        'calon_presiden_id' => $calon_3->id,
                        'suara_sah' => $suara_calon[1],
                        'suara_tidak_sah' => 0,
                        'suara_sisa' => 0,
                    ],
                    [
                        'saksi_id' => $valid->id,
                        'calon_presiden_id' => $calon_2->id,
                        'suara_sah' => $suara_calon[2],
                        'suara_tidak_sah' => 0,
                        'suara_sisa' => 0,
                    ]
                ];

                foreach ($dataToInsert as $data) {
                    Suara::updateOrCreate(['saksi_id' => $data['saksi_id'], 'calon_presiden_id' => $data['calon_presiden_id']], $data);
                }

                SuaraMasuk::updateOrCreate(['saksi_id' => $valid->id], [
                    'suara_sah' => array_sum($suara_calon),
                    'suara_sisa' => $suara_sisa,
                    'suara_tidak_sah' => $suara_tidak_sah,
                    'photo_path' => $request->foto
                ]);

                $response['response_code'] = "00";
                $response['response_msg'] = "Berhasil menyimpan suara";
                $response['message'] = 'success';
            } catch (\Throwable $th) {
                $response['response_code'] = "99";
                $response['response_msg'] = $th->getMessage();
                $response['message'] = [];
            }

            return response()->json($response);
        });
        Route::post('upload_foto', function (Request $request) {
            $response = [
                "response_code" => "00",
                "response_msg" => "success"
            ];
            try {
                $username =  $request->username;
                // $valid = Saksi::where('id_telegram', $username)->first();
                // if (!$valid) {
                //     throw new Exception('Saksi tidak terdaftar.');
                // }

                $validatedData = $request->validate([
                    'url' => 'required|url'
                ]);
                $url = $validatedData['url'];
                $extension = pathinfo(parse_url($url)['path'], PATHINFO_EXTENSION);

                $client = new Client();
                $resp = $client->get($url);
                $contentType = $resp->getHeader('content-type')[0];
                $fileName = time() . '.' . $extension;

                FileUpload::create([
                    'file_name' => $fileName,
                    'file_path' => 'uploads/c1/'
                ]);

                $path = public_path('uploads/c1/' . $fileName);
                file_put_contents($path, $resp->getBody());

                $response['response_code'] = "00";
                $response['response_msg'] = "Berhasil upload foto";
                $response['message'] = $fileName;
            } catch (RequestException $e) {
                $response['response_code'] = "99";
                $response['response_msg'] = 'Gagal mengunduh file dari URL yang diberikan';
                $response['message'] = [];
            } catch (Exception $th) {
                $response['response_code'] = "99";
                $response['response_msg'] = $th->getMessage();
                $response['message'] = [];
            }

            return response()->json($response);
        });
    });
    Route::prefix('admin')->group(function () {
        Route::get('/get_kelurahan/{id}', function ($id) {
            $kelurahan = Kelurahan::where('kecamatan_id', $id)->get();
            return response()->json($kelurahan);
        });
    });
});
