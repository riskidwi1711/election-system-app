<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suara extends Model
{
    use HasFactory;
    protected $table = 'suara';
    protected $fillable = ['saksi_id', 'calon_presiden_id', 'suara_sah', 'suara_tidak_sah', 'suara_sisa'];

    // Definisikan hubungan dengan model Saksi
    public function saksi()
    {
        return $this->belongsTo(Saksi::class);
    }

    // Definisikan hubungan dengan model CalonPresiden
    public function calonPresiden()
    {
        return $this->belongsTo(CalonPresiden::class);
    }
}
