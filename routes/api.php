<?php

use App\Http\Controllers\Dashboard\HasilSuaraController;
use App\Models\CalonPresiden;
use App\Models\Saksi;
use App\Models\Suara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    });
});
