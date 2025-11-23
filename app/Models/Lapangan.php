<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $table='lapangan';
    protected $primaryKey = 'l_id';

    protected $fillable = 
    [
        'l_label',
        'l_foto',
        'l_deskripsi',
        'l_harga',
        'l_status',
        'created_at',
        'updated_at',
    ];
}