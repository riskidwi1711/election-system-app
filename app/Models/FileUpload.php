<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;
    protected $table = 'file_uploads';
    protected $fillable = ['file_name','file_path'];

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
