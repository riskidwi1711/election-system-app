<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saksi extends Model
{
    use HasFactory;
    protected $table = "saksi";
    protected $fillable = ['tps', 'kelurahan_id', 'kecamatan_id','nik', 'nama', 'id_telegram'];

    public function kelurahan(){
        return $this->belongsTo(Kelurahan::class);
    }

    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class);
    }
}
