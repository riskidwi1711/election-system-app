<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuaraMasuk extends Model
{
    use HasFactory;
    protected $table = 'suara_masuk';
    protected $fillable = ['saksi_id', 'suara_sah', 'suara_tidak_sah', 'suara_sisa', 'photo_path'];

    public function saksi(){
        return $this->belongsTo(Saksi::class);
    }
}
