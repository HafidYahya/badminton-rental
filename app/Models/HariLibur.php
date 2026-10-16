<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    protected $table = 'hari_libur';
    protected $primaryKey = 'hl_id';
    protected $guarded = [];

    protected $casts = [
        'hl_tanggal_mulai' => 'datetime',
        'hl_tanggal_selesai' => 'datetime',
    ];
}
