<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saksi extends Model
{
    use HasFactory;
    protected $table = "saksi";
    protected $fillable = ['tps', 'kelurahan_id', 'kecamatan_id', 'nik', 'nama', 'id_telegram'];

    protected static function booted()
    {
        static::addGlobalScope('withLocation', function ($builder) {
            $builder->with(['kelurahan', 'kecamatan']);
        });
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}
