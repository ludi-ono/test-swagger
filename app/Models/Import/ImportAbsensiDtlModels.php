<?php

namespace App\Models\Import;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ImportAbsensiDtlModels extends Model
{
    protected $table = 'trx_absen';    

    // use Notifiable;

    protected $fillable = [
        'id', 'id_hdr', 'nik', 'nama', 'tanggal', 'status', 'user_at', 'created_at', 'updated_at'
    ];
}
