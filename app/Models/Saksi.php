<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saksi extends Model
{
    use HasFactory;
    protected $table = "saksi";
    protected $fillable = ['tps', 'kelurahan', 'kecamatan', 'nama', 'id_telegram'];
}
