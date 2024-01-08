<?php

namespace App\Models\Import;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ImportAbsensiHdrModels extends Model
{
    protected $table = 'trx_absen_hdr';    

    // use Notifiable;

    protected $fillable = [
        'id', 'file_name', 'user_at', 'created_at', 'updated_at'
    ];
}
