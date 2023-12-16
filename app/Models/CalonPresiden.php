<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonPresiden extends Model
{
    use HasFactory;
    protected $table = 'calon_presiden';
    protected $fillable = ['foto', 'nama_calon_presiden', 'nama_wakil_presiden', 'no_urut'];
}
